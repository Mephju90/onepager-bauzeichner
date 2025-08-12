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

  // HAMBURGER MENU
  const toggleButton = document.querySelector(".menu-toggle");
  const nav = document.getElementById("main-menu");

  toggleButton?.addEventListener("click", () => {
    const isExpanded = toggleButton.getAttribute("aria-expanded") === "true";
    toggleButton.setAttribute("aria-expanded", (!isExpanded).toString());
    nav.hidden = isExpanded;
  });
});


  // NAV aria-current auf Basis der sichtbaren Section
  const sections = [
    ['hero', '#hero'],
    ['leistungen', '#leistungen'],
    ['ueberuns', '#ueberuns'],
    ['kontakt', '#kontakt']
  ];
  const navLinks = Array.from(document.querySelectorAll('nav a[href^="#"]'));
  const sectionEls = sections.map(([k,sel]) => document.querySelector(sel)).filter(Boolean);

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
