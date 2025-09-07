<?php

declare(strict_types=1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/* Cookie-Flags – am besten ganz oben, VOR session_start() */

if (PHP_SESSION_ACTIVE !== session_status()) {
  session_set_cookie_params([
    'secure'   => true,
    'httponly' => true,
    'samesite' => 'Lax',
  ]);
}
session_start();

require __DIR__ . '/../private/vendor/autoload.php';
$config = require __DIR__ . '/../private/config.mail.php';

/* ========= Helper ========= */
function clean_line(string $s, int $max = 200): string
{
  $s = trim(strip_tags($s));
  $s = preg_replace('/[\x00-\x1F\x7F]+/u', '', $s); // Steuerzeichen
  $s = str_replace(["\r", "\n"], ' ', $s);          // Header-Injection verhindern
  return mb_substr($s, 0, $max, 'UTF-8');
}
function clean_textblock(string $s, int $max = 5000): string
{
  $s = str_replace(["\r\n", "\r"], "\n", trim($s));
  $s = preg_replace('/[\x00-\x08\x0B-\x0C\x0E-\x1F\x7F]/u', '', $s);
  return mb_substr($s, 0, $max, 'UTF-8');
}
function bad_request(string $msg = 'Ungültige Anfrage.'): void
{
  http_response_code(400);
  exit($msg);
}

/* ========= Nur POST ========= */
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
  http_response_code(405);
  exit('Nur POST erlaubt.');
}

/* ========= CSRF ========= */
if (empty($_POST['csrf']) || !hash_equals($_SESSION['csrf'] ?? '', (string)$_POST['csrf'])) {
  bad_request();
}
/* Einmal‑Token nach Prüfung invalidieren */
unset($_SESSION['csrf']);


/* ========= Honeypot ========= */
if (!empty($_POST['company'] ?? '')) { // Feld muss leer sein
  http_response_code(200);
  exit('OK');
}

/* ========= DSGVO-Checkbox (falls im Formular vorhanden) ========= */
if (empty($_POST['privacy'])) {
  bad_request('Bitte stimmen Sie der Datenschutzerklärung zu.');
}

/* ========= Eingaben ========= */
$name    = clean_line($_POST['name']    ?? '', 200);
$email   = clean_line($_POST['email']   ?? '', 320);
$message = clean_textblock($_POST['message'] ?? '', 5000);

if ($name === '' || $email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $message === '') {
  bad_request('Bitte alle Felder korrekt ausfüllen.');
}

/* ========= Rate‑Limit (60s/IP) – robust mit File‑Lock & System‑Temp ========= */
$windowSec = 60; // <<< Wartefenster in Sekunden (hier: 60s)

$rlDir = rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'zk_rate';
if (!is_dir($rlDir)) {
  @mkdir($rlDir, 0700, true);
}

$ip     = (string)($_SERVER['REMOTE_ADDR'] ?? '0.0.0.0');
$rlFile = $rlDir . DIRECTORY_SEPARATOR . hash('sha256', $ip) . '.lock';

$fp = @fopen($rlFile, 'c+'); // c+ = create if not exists
if ($fp) {
  // exklusives Lock, verhindert Race-Conditions
  if (@flock($fp, LOCK_EX)) {
    $now  = time();
    $last = 0;

    // vorhandenen Zeitstempel lesen
    $contents = stream_get_contents($fp);
    if ($contents !== false) {
      $last = (int)trim($contents);
    }

    if ($now - $last < $windowSec) {
      @flock($fp, LOCK_UN);
      @fclose($fp);

      // Mehr Kontext für Browser/JS:
      header('Retry-After: ' . ($windowSec - ($now - $last))); // Sekunden bis zur nächsten erlaubten Anfrage
      http_response_code(429);

      // Wenn per Fetch/XHR angefragt wurde, JSON zurückgeben
      $accept = $_SERVER['HTTP_ACCEPT'] ?? '';
      if (stripos($accept, 'application/json') !== false) {
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode([
          'ok' => false,
          'error' => 'rate_limited',
          'message' => 'Bitte warten Sie kurz und versuchen es erneut.',
          'retry_after' => ($windowSec - ($now - $last))
        ], JSON_UNESCAPED_UNICODE);
        exit;
      }

      // Fallback: Plaintext
      header('Content-Type: text/plain; charset=UTF-8');
      exit('Bitte warten Sie kurz und versuchen es erneut.');
    }


    // neuen Zeitstempel schreiben (atomar)
    ftruncate($fp, 0);
    rewind($fp);
    fwrite($fp, (string)$now);
    fflush($fp);
    @flock($fp, LOCK_UN);
  }
  @fclose($fp);
}

/* optionale Garbage-Collection: alte Dateien (> 24h) entfernen */
if (mt_rand(1, 50) === 1) { // ~2% der Requests
  $now = time();
  foreach ((array)@glob($rlDir . DIRECTORY_SEPARATOR . '*.lock') as $file) {
    if (@is_file($file) && ($now - (int)@filemtime($file) > 86400)) {
      @unlink($file);
    }
  }
}


$mail = new PHPMailer(true);

try {
  $mail->SMTPDebug  = 0;  // sicherstellen, dass kein Debug nach außen geht
  $mail->isSMTP();
  $mail->Host       = $config['host'];
  $mail->SMTPAuth   = true;
  $mail->Username   = $config['username'];
  $mail->Password   = $config['password'];
  $mail->SMTPSecure = ($config['encryption'] === 'ssl')
    ? PHPMailer::ENCRYPTION_SMTPS
    : PHPMailer::ENCRYPTION_STARTTLS;
  $mail->Port       = (int)$config['port'];
  $mail->Timeout    = (int)($config['timeout'] ?? 20);
  $mail->CharSet    = 'UTF-8';

  $mail->setFrom($config['from_email'], $config['from_name']);
  $mail->Sender = $config['from_email'];
  $mail->addAddress($config['to_email'], $config['to_name']);
  $mail->addReplyTo($email, $name);

  $mail->isHTML(true);
  $mail->Subject = 'Kontaktformular: ' . $name;
  $mail->Body    = '<p><strong>Name:</strong> ' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '</p>'
    . '<p><strong>E‑Mail:</strong> ' . htmlspecialchars($email, ENT_QUOTES, 'UTF-8') . '</p>'
    . '<p><strong>Nachricht:</strong><br>' . nl2br(htmlspecialchars($message, ENT_QUOTES, 'UTF-8')) . '</p>';
  $mail->AltBody = "Name: $name\nE‑Mail: $email\n\nNachricht:\n$message";

  $mail->send();

  /* 303 See Other statt 302 */
  header('Location: /index.php?status=ok', true, 303);
  exit;
} catch (Exception $e) {
  error_log('MAIL ERROR: ' . ($mail->ErrorInfo ?: $e->getMessage()));
  http_response_code(500);
  exit('Fehler beim Senden.');
}
