<?php
if (PHP_SESSION_ACTIVE !== session_status()) {
  session_set_cookie_params([
    'secure'   => true,     // nur über HTTPS
    'httponly' => true,     // nicht per JS auslesbar
    'samesite' => 'Lax',    // CSRF-Schutz, aber Form-Posts funktionieren
  ]);
}

session_start();
if (empty($_SESSION['csrf'])) {
  $_SESSION['csrf'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>

<html lang="de">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <link as="font" crossorigin href="assets/fonts/architects-daughter/architects-daughter.woff2" rel="preload" type="font/woff2" />


  <title>Zeichenbüro Peter Kopf – Technischer Zeichner in Ubstadt-Weiher (Ortsteil Zeutern)</title>
  <meta name="description" content="Zeichenbüro Peter Kopf – Technischer Zeichner in Ubstadt-Weiher (Ortsteil Zeutern). Präzise CAD-Zeichnungen, 3D-Visualisierung & technische Dokumentation. Jetzt Kontakt aufnehmen!">

  <!-- Canonical -->
  <link rel="canonical" href="https://zeichenbuero-pk.de/" />

  <!-- Open Graph für Social Media -->
  <meta property="og:type" content="website" />
  <meta property="og:title" content="Zeichenbüro Peter Kopf – Technischer Zeichner in Ubstadt-Weiher (Ortsteil Zeutern)" />
  <meta property="og:description" content="Präzise CAD-Zeichnungen, 3D-Visualisierung und technische Dokumentation für Bauherren, Architekten und Firmen." />
  <meta property="og:url" content="https://zeichenbuero-pk.de/" />
  <meta property="og:image" content="https://zeichenbuero-pk.de/assets/img/og-cover.jpg" />
  <meta property="og:site_name" content="Zeichenbüro Peter Kopf" />
  <meta property="og:locale" content="de_DE" />
  <meta property="og:image:alt" content="Zeichenbüro Peter Kopf – CAD, 3D‑Visualisierung und technische Zeichnungen" />
  <meta property="og:image:width" content="1200" />
  <meta property="og:image:height" content="630" />


  <!-- Twitter Cards -->
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="Zeichenbüro Peter Kopf – Technischer Zeichner in Ubstadt-Weiher (Ortsteil Zeutern)" />
  <meta name="twitter:description" content="Präzise CAD‑Zeichnungen, 3D‑Visualisierung und technische Dokumentation für Bauherren, Architekten und Firmen." />
  <meta name="twitter:image" content="https://zeichenbuero-pk.de/assets/img/og-cover.jpg" />
  <meta name="twitter:url" content="https://zeichenbuero-pk.de/" />

  <!-- LocalBusiness Schema.org -->
  <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "LocalBusiness",
      "name": "Zeichenbüro Peter Kopf",
      "image": "https://zeichenbuero-pk.de/assets/img/og-cover.jpg",
      "url": "https://zeichenbuero-pk.de/",
      "telephone": "+49 172 6304124",
      "email": "info@zeichenbuero-pk.de",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Oberdorfstraße 60",
        "addressLocality": "Ubstadt-Weiher",
        "postalCode": "76698",
        "addressCountry": "DE"
      },
      "areaServed": ["Ubstadt-Weiher", "Zeutern", "Stettfeld", "Weiher", "Karlsruhe", "Bruchsal"],
      "priceRange": "€€"
    }
  </script>

  <!-- Favicons -->
  <link rel="apple-touch-icon" sizes="180x180" href="assets/img/fav/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="assets/img/fav/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="assets/img/fav/favicon-16x16.png">
  <link rel="manifest" href="assets/img/fav/manifest.json">
  <link rel="mask-icon" href="assets/img/fav/safari-pinned-tab.svg" color="#003366">
  <meta name="msapplication-TileColor" content="#003366">
  <meta name="theme-color" content="#003366">


  <link href="assets/css/style.css" rel="stylesheet" />
  <script defer="" src="assets/js/script.js"></script>
  <meta content="light" name="color-scheme" />
  <meta content="strict-origin-when-cross-origin" name="referrer" />
  <link rel="preload" as="image" href="assets/img/logo02.png" imagesrcset="assets/img/logo02.png 1x" imagesizes="250px">

  <link
    as="font"
    crossorigin=""
    href="assets/fonts/architects-daughter/architects-daughter.woff2"
    rel="preload"
    type="font/woff2" />
</head>

<body>
  <a class="skip-link" href="#main">Zum Inhalt springen</a>
  <nav aria-label="Hauptnavigation" class="navbar">
    <div class="nav-inner">
      <div class="logo2">
        <img
          alt="Zeichenbüro Peter Kopf – Logo"
          decoding="async"
          fetchpriority="high"
          height="214"
          src="assets/img/logo02.png"
          width="250" />

      </div>
      <button
        aria-controls="main-menu"
        aria-expanded="false"
        aria-label="Menü öffnen"
        class="menu-toggle">
        ☰
      </button>
      <div hidden="" id="main-menu">
        <ul>
          <li><a href="#hero">Home</a></li>
          <li><a href="#leistungen">Leistungen</a></li>
          <li><a href="#ueberuns">Über mich</a></li>
          <li><a href="#kontakt">Kontakt</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <main id="main" role="main">
    <!-- DSGVO Cookie Hinweis -->
    <div
      class="cookie-banner"
      id="cookie-banner"
      role="region"
      aria-label="Hinweis zu Cookies und Speicher">
      <span>
        Diese Website verwendet ausschließlich technisch notwendige Funktionen
        und speichert eine Zustimmung im lokalen Speicher Ihres Browsers. Es
        werden keine Tracking-Cookies gesetzt.
        <a href="datenschutz.html" rel="noopener noreferrer" target="_blank">Mehr erfahren</a>.
      </span>
      <button id="cookie-ok-btn" aria-label="Hinweis schließen">
        Verstanden
      </button>
    </div>

    <!-- HERO -->
    <header class="hero" id="hero" role="banner">
      <div class="glass-con">
        <div class="shimmer-overlay"></div>
        <h1>
          <span class="title-top">ZEICHENBÜRO</span>
          <span class="title-name">Peter Kopf</span>
          <span class="sr-only"> – Technischer Zeichner in Ubstadt‑Weiher (Ortsteil Zeutern)</span>
        </h1>
        <p>
          Technisch. Präzise. Massgeschneidert. <br />
          Technische Zeichnungen auf höchster CAD-Kompetenz
        </p>
      </div>
    </header>

    <!-- LEISTUNGEN -->

    <section id="leistungen" class="leistungen v3">
      <div class="section-inner">
        <div class="section-head">
          <h2>Leistungen</h2>
          <p class="subline">
            Präzise CAD-Arbeit – von der Idee bis zum fertigen Plan.
          </p>
        </div>

        <div class="leistungen-grid">
          <article class="leistung">
            <div class="icon">
              <img
                alt="Zirkel und Lineal"
                decoding="async"
                loading="lazy"
                src="assets/img/icons_svg/cad.svg" />
            </div>
            <h3>Planung &amp; Ausarbeitung</h3>
            <p>
              Vom Konzept bis zum fertigen Plan – präzise &amp; normgerecht.
            </p>
          </article>

          <article class="leistung">
            <div class="icon">
              <img
                alt="3D-Visualisierung / Ebenen-Stack"
                decoding="async"
                loading="lazy"
                src="assets/img/icons_svg/visualisierung.svg" />
            </div>
            <h3>3D &amp; Visualisierung</h3>
            <p>Komplexe Inhalte anschaulich dargestellt.</p>
          </article>

          <article class="leistung">
            <div class="icon">
              <img
                alt="Dokument mit Stift"
                decoding="async"
                loading="lazy"
                src="assets/img/icons_svg/dokumentation.svg" />
            </div>
            <h3>Technische Dokumentation</h3>
            <p>Vor-Ort-Erfassung und präzise Auswertung.</p>
          </article>

          <article class="leistung">
            <div class="icon">
              <img
                alt="Papierrolle / Plot"
                decoding="async"
                loading="lazy"
                src="assets/img/icons_svg/druck.svg" />
            </div>
            <h3>Druck &amp; Übergabe</h3>
            <p>Pläne im Großformat perfekt aufbereitet.</p>
          </article>

          <article class="leistung">
            <div class="icon">
              <img
                alt="Würfel auf Raster (3D-Modell)"
                decoding="async"
                loading="lazy"
                src="assets/img/icons_svg/modell.svg" />
            </div>
            <h3>3D-Druck &amp; Modellfertigung</h3>
            <p>
              Physische Modelle aus CAD-Daten für Präsentationen &amp;
              Prototypen.
            </p>
          </article>

          <article class="leistung leistung-cta">
            <div class="icon" aria-hidden="true">
              <img
                alt="Kontakt-Icon"
                decoding="async"
                loading="lazy"
                src="assets/img/icons_svg/kontakt.svg" />
            </div>
            <h3>Mehr Anforderungen?</h3>
            <p>
              Jetzt unverbindlich anfragen – praxisnah &amp;
              lösungsorientiert.
            </p>
            <a class="cta-link" href="#kontakt">Kontakt aufnehmen →</a>
          </article>
        </div>
      </div>
    </section>

    <!-- ÜBER UNS -->
    <section aria-labelledby="uebermich" class="ueber-mich wow" id="ueberuns">
      <div class="ueber-mich-text">
        <h2 class="handwritten" id="uebermich">Über mich</h2>
        <p>
          Mein Name ist <strong>Peter Kopf</strong>. Ich bin Technischer
          Zeichner der Fachrichtung Maschinenbau und habe 1994 mein eigenes
          Zeichenbüro gegründet.
        </p>
        <p>
          Ich unterstütze Unternehmen mit präzisen Zeichnungen – von
          CAD-Planung über Revisionspläne bis zur Druckausgabe. Dabei bringe
          ich meine langjährige Erfahrung aus verschiedenen Branchen wie
          <strong>Sondermaschinenbau</strong>, <strong>Stahlbau</strong>,
          <strong>Fernwärme</strong> oder <strong>Haustechnik</strong> ein.
        </p>
        <p>
          Ich arbeite mit
          <strong>AutoCAD (inkl. MEP &amp; Architectural)</strong>,
          <strong>Brixcad</strong> und <strong>Nova Plancal</strong> –
          zuverlässig, strukturiert und auf Wunsch auch direkt bei Ihnen vor
          Ort.
        </p>
        <p>
          <strong>Ich freue mich auf Ihre Nachricht!</strong>
        </p>
      </div>
    </section>
    <!-- CTA -->
    <section
      aria-labelledby="cta-demo"
      style="text-align: center; padding: 4rem 1rem">
      <h2 class="handwritten" id="cta-demo" style="text-align: center">
        Bereit für Ihr nächstes Projekt?
      </h2>
      <p>
        Ich freue mich auf Ihre Anfrage – lassen Sie uns gemeinsam loslegen!
      </p>
      <!-- <button
        aria-label="Kontakt aufnehmen"
        class="skizzen-button"
        onclick="document.getElementById('kontakt').scrollIntoView({ behavior: 'smooth' })">
        Kontakt aufnehmen
      </button> -->
      <button id="cta-scroll" aria-label="Kontakt aufnehmen" class="skizzen-button">
        Kontakt aufnehmen
      </button>

    </section>
    <!-- KONTAKT -->
    <section
      aria-labelledby="kontakt-heading"
      class="kontaktformular wow"
      id="kontakt">
      <h2 id="kontakt-heading">Kontakt</h2>

      <form action="/contact.php" method="POST" aria-describedby="kontakt-beschreibung">
        <input type="hidden" name="csrf" value="<?= htmlspecialchars($_SESSION['csrf'], ENT_QUOTES) ?>">

        <p id="kontakt-beschreibung">Felder mit * sind erforderlich.</p>

        <label for="name">Ihr Name *</label>
        <input id="name" name="name" type="text" autocomplete="name" maxlength="100" required />

        <label for="email">Ihre E-Mail *</label>
        <input id="email" name="email" type="email" autocomplete="email" maxlength="150" required />

        <label for="nachricht">Ihre Nachricht *</label>
        <textarea id="nachricht" name="message" rows="5" maxlength="2000" required></textarea>

        <!-- Honeypot -->
        <div style="position:absolute;left:-9999px" aria-hidden="true">
          <label for="company">Firma (leer lassen)</label>
          <input type="text" id="company" name="company" tabindex="-1" autocomplete="off" />
        </div>

        <fieldset class="ds-check">
          <label><input id="privacy" name="privacy" type="checkbox" required />
            <span>Ich habe die <a href="datenschutz.html" target="_blank" rel="noopener noreferrer">Datenschutzerklärung</a> gelesen …</span>
          </label>
        </fieldset>

        <button class="skizzen-button" type="submit">Nachricht senden</button>
      </form>


    </section>

    <!-- Footer Start -->
  </main>
  <footer class="site-footer wow">
    <div class="footer-content">
      <div class="footer-left">
        <strong>Peter Kopf – Technischer Zeichner</strong><br />
        Oberdorfstraße 60<br />
        76698 Ubstadt-Weiher<br />
        <a href="mailto:info@zeichenbuero-pk.de">info@zeichenbuero-pk.de</a>
        <br />
        <a href="tel:+491726304124">+49 172 6304124</a>
      </div>
      <div class="footer-right">
        <nav aria-label="Rechtliche Informationen">
          <strong>Rechtliches</strong><br />
          <br />
          <a href="impressum.html">Impressum</a><br />
          <a href="datenschutz.html">Datenschutz</a>
        </nav>
      </div>
    </div>
    <div class="footer-credit">
      Website erstellt von <strong>Steven Kirstein – Web Developer</strong>
    </div>
  </footer>
  <!-- Footer End -->

  <!-- Popup -->
  <div
    id="popup"
    role="dialog"
    aria-modal="true"
    aria-labelledby="popup-title"
    hidden
    style="
    position: fixed;
    inset: 0;
    align-items: center;
    justify-content: center;
    background: rgba(0, 0, 0, 0.45);
    z-index: 9999;
  ">

    <div
      style="
          background: #fff;
          max-width: 460px;
          width: 90%;
          padding: 18px 20px;
          border-radius: 14px;
          box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        ">
      <h3 id="popup-title" style="margin: 0 0 8px 0; font-size: 1.15rem">
        Erfolg
      </h3>
      <p id="popup-msg" style="margin: 0 0 14px 0">
        Ihre Nachricht wurde gesendet.
      </p>
      <button id="popup-close" type="button" class="skizzen-button">
        Schließen
      </button>
    </div>
  </div>


</body>

</html>