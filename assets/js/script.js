document.addEventListener("DOMContentLoaded", () => {
  // COOKIE BANNER
  const banner = document.getElementById("cookie-banner");
  const btn = document.getElementById("cookie-ok-btn");

  if (localStorage.getItem("cookiesAccepted") === "true") {
    banner.style.display = "none";
  } else {
    btn?.addEventListener("click", () => {
      banner.style.display = "none";
      localStorage.setItem("cookiesAccepted", "true");
    });
  }

  
  // SCROLL-REVEAL (Allgemein)
  const revealObserver = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        revealObserver.unobserve(entry.target);
      }
    });
  }, { threshold: 0.3 });

  const candidates = document.querySelectorAll('.leistung, .ueber-mich, .info-box, .kontaktformular');
  candidates.forEach(el => {
    // Apply reveal only if element starts below the initial viewport
    const rect = el.getBoundingClientRect();
    const aboveFold = rect.top < (window.innerHeight * 0.8);
    if (aboveFold) {
      el.classList.add('visible');
    } else {
      el.classList.add('reveal');
      revealObserver.observe(el);
    }
  });

  // FOOTER Reveal
  const footer = document.querySelector('.site-footer');
  if (footer) {
    const footerObserver = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          footer.classList.add('visible');
          footerObserver.unobserve(entry.target);
        }
      });
    }, { threshold: 0.1 });

    footerObserver.observe(footer);
  }

  // HAMBURGER MENU mit korrektem ARIA-State
  const toggleButton = document.querySelector(".menu-toggle");
  const nav = document.getElementById("main-menu");

  if (toggleButton && nav) {
    // Initial geschlossen
    toggleButton.setAttribute("aria-expanded", "false");
    nav.hidden = true;

    function setMenu(open) {
      nav.hidden = !open;
      toggleButton.setAttribute("aria-expanded", String(open));
      if (open) {
        nav.querySelector("a")?.focus();
      }
    }

    toggleButton.addEventListener("click", () => setMenu(nav.hidden));

    // Esc-Taste zum Schließen
    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape" && !nav.hidden) {
        setMenu(false);
      }
    });
  }



  // NAV aria-current auf Basis der sichtbaren Section
  const sections = [
    ['hero', '#hero'],
    ['leistungen', '#leistungen'],
    ['ueberuns', '#ueberuns'],
    ['kontakt', '#kontakt']
  ];
  const navLinks = Array.from(document.querySelectorAll('nav a[href^="#"]'));
  const sectionEls = sections.map(([k,sel]) => document.querySelector(sel)).filter(Boolean);

    // Initial: Home-Link markieren
  navLinks.forEach(a => {
    if (a.getAttribute("href") === "#hero") {
      a.setAttribute("aria-current", "page");
    } else {
      a.removeAttribute("aria-current");
    }
  });


  const currentObserver = new IntersectionObserver((entries)=>{
    let best = null;
    entries.forEach(entry=>{
      if (entry.isIntersecting) {
        if (!best || entry.intersectionRatio > best.intersectionRatio) best = entry;
      }
    });
    if (best) {
      const id = '#' + best.target.id;
      navLinks.forEach(a => {
        if (a.getAttribute('href') === id) {
          a.setAttribute('aria-current','page');
        } else {
          a.removeAttribute('aria-current');
        }
      });
    }
  }, { rootMargin: '-20% 0px -60% 0px', threshold: [0.2, 0.6, 0.9] });

  sectionEls.forEach(el => currentObserver.observe(el));

    // --- CTA-Scroll (ohne inline-onclick) ---
  const ctaBtn = document.getElementById("cta-scroll");
  if (ctaBtn) {
    ctaBtn.addEventListener("click", () => {
      const ziel = document.getElementById("kontakt");
      if (ziel) ziel.scrollIntoView({ behavior: "smooth" });
    });
  }

  // --- Popup-Handling (aus index.php ausgelagert) ---
  const popup    = document.getElementById("popup");
  const btnClose = document.getElementById("popup-close");

  if (popup && btnClose) {
    function openPopup() { popup.hidden = false; btnClose.focus(); }
    function closePopup() { popup.hidden = true; }

    btnClose.addEventListener("click", closePopup);
    popup.addEventListener("click", (e) => { if (e.target === popup) closePopup(); });
    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape" && !popup.hidden) closePopup();
    });

    const params = new URLSearchParams(window.location.search);
    if (params.get("status") === "ok") {
      openPopup();
      if (history.replaceState) {
        const url = new URL(window.location);
        url.searchParams.delete("status");
        history.replaceState({}, "", url);
      }
    }
  }

});

// --- Counter (extern, CSP-freundlich) ---
try {
  fetch("counter.php", { cache: "no-store" }).catch(() => {});
} catch (_) {}

