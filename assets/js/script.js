// COOKIE BANNER
// Cookie-Banner schließen
document.addEventListener("DOMContentLoaded", () => {
  const cookieBanner = document.querySelector(".cookie-banner");
  const cookieButton = cookieBanner?.querySelector("button");

  // Schließen bei Klick
  cookieButton?.addEventListener("click", () => {
    cookieBanner.style.display = "none";
    // Optional: Speichern, dass der Nutzer zugestimmt hat
    localStorage.setItem("cookiesAccepted", "true");
  });

  // Beim Laden prüfen, ob schon akzeptiert wurde
  if (localStorage.getItem("cookiesAccepted") === "true") {
    cookieBanner.style.display = "none";
  }

  // Scroll-Reveal Observer
  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.3 });

 document.querySelectorAll('.leistung, .ueber-mich, .info-box, .kontaktformular')
  .forEach(section => observer.observe(section));

  // KONTAKT
  const kontakt = document.querySelector('.kontaktformular');
  if (kontakt) {
    const kontaktObserver = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          kontaktObserver.unobserve(entry.target);
        }
      });
    }, { threshold: 0.3 });

    kontaktObserver.observe(kontakt);
  }

  // Hamburger Menü
  const toggleButton = document.querySelector(".menu-toggle");
  const nav = document.getElementById("main-menu");

  toggleButton?.addEventListener("click", () => {
    const isExpanded = toggleButton.getAttribute("aria-expanded") === "true";
    toggleButton.setAttribute("aria-expanded", !isExpanded);
    nav.hidden = isExpanded;
  });
});

const footer = document.querySelector('.site-footer');
const observer = new IntersectionObserver(
  entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        footer.classList.add('visible');
      }
    });
  },
  { threshold: 0.1 }
);

observer.observe(footer);
