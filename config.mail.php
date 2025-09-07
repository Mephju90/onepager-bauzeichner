<?php
declare(strict_types=1);

// config.mail.php (FINAL)

require __DIR__ . '/vendor/autoload.php';

$dotenvPath = dirname(__DIR__) . '/private';
if (!is_dir($dotenvPath)) {
  throw new RuntimeException('Konfigurationsordner /private fehlt.');
}

$dotenv = Dotenv\Dotenv::createImmutable($dotenvPath);
$dotenv->safeLoad(); 

// Helper: Pflichtwert holen oder Exception
$req = function(string $key, ?string $fallback = null): string {
  $val = $_ENV[$key] ?? $fallback ?? '';
  $val = is_string($val) ? trim($val) : '';
  if ($val === '') {
    throw new RuntimeException("Fehlender Mail-Parameter: {$key}");
  }
  return $val;
};

// Helper: Optionaler Integer mit Fallback + Bounds
$int = function(string $key, int $fallback, int $min = 1, int $max = 65535): int {
  $raw = $_ENV[$key] ?? null;
  $val = is_numeric($raw) ? (int)$raw : $fallback;
  if ($val < $min || $val > $max) $val = $fallback;
  return $val;
};

// Encryption normalisieren
$enc = strtolower(trim($_ENV['MAIL_SECURE'] ?? 'ssl'));
if (!in_array($enc, ['ssl','tls'], true)) {
  $enc = 'ssl';
}

// --- TESTMODUS: lokal oder manuell ---
$testMode = ($_ENV['APP_ENV'] ?? '') !== 'production';
// -> wenn APP_ENV != production, gehen Mails nur an dich

if ($testMode) {
  return [
    'host'       => $req('MAIL_HOST', 'mxe9b3.netcup.net'),
    'port'       => $int('MAIL_PORT', $enc === 'ssl' ? 465 : 587),
    'encryption' => $enc,
    'username'   => $req('MAIL_USER', 'info@zeichenbuero-pk.de'),
    'password'   => $req('MAIL_PASS'),
    'from_email' => $req('MAIL_FROM', 'info@zeichenbuero-pk.de'),
    'from_name'  => 'Zeichenbüro Peter Kopf (TEST)',
    'to_email'   => 'kontakt@steven-kirstein.de',   // deine Test-Adresse
    'to_name'    => 'Steven Test',
    'timeout'    => 15,
  ];
}


return [
  'host'       => $req('MAIL_HOST', 'mxe9b3.netcup.net'),
  'port'       => $int('MAIL_PORT', $enc === 'ssl' ? 465 : 587),
  'encryption' => $enc, // 'ssl' oder 'tls' – im Mailer passend mappen
  'username'   => $req('MAIL_USER', 'info@zeichenbuero-pk.de'),
  'password'   => $req('MAIL_PASS'), // Pflicht!
  'from_email' => $req('MAIL_FROM', 'info@zeichenbuero-pk.de'),
  'from_name'  => trim($_ENV['MAIL_FROM_NAME'] ?? 'Zeichenbüro Peter Kopf'),
  'to_email'   => $req('MAIL_TO', 'info@zeichenbuero-pk.de'),
  'to_name'    => trim($_ENV['MAIL_TO_NAME'] ?? 'Kontakt'),
  'timeout'    => $int('MAIL_TIMEOUT', 15, 5, 60),
];
