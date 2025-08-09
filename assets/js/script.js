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

  document.querySelectorAll('.leistung, .ueber-mich, .info-box, .kontaktformular')
    .forEach(section => revealObserver.observe(section));

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
