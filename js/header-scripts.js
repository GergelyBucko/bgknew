// HEADER INTERAKCIÓK – az eredeti elemek felhasználásával

const servicesToggle = document.getElementById("servicesToggle");
const servicesMenu = document.getElementById("servicesMenu");
const chevronIcon = document.getElementById("chevronIcon");
const mobileMenuToggle = document.getElementById("mobileMenuToggle");
const mobileMenu = document.getElementById("mobileMenu");
const mobileOverlay = document.getElementById("mobileOverlay");
const hamburgerIcon = document.getElementById("hamburgerIcon");
const closeIcon = document.getElementById("closeIcon");

if (!servicesToggle || !servicesMenu || !chevronIcon || !mobileMenuToggle || !mobileMenu || !mobileOverlay || !hamburgerIcon || !closeIcon) {
  console.warn("Header elemek hiányoznak – header-scripts.js");
} else {
  let servicesOpen = false;

  // ====== Services dropdown (desktop) ======
  function openServices() {
    const isAtTop = window.scrollY <= 10;
    if (isAtTop) {
      servicesMenu.classList.remove("absolute", "top-[4rem]");
      servicesMenu.classList.add("sticky", "top-[4rem]");
    } else {
      servicesMenu.classList.remove("sticky", "top-[4rem]");
      servicesMenu.classList.add("absolute", "top-[4rem]");
    }
    servicesMenu.classList.remove("max-h-0", "opacity-0");
    servicesMenu.classList.add("max-h-[300px]", "opacity-100");
    chevronIcon.classList.add("rotate-180");
    servicesToggle.setAttribute("aria-expanded", "true");
    servicesOpen = true;
  }

  function closeServices() {
    servicesMenu.classList.remove("max-h-[300px]", "opacity-100");
    servicesMenu.classList.add("max-h-0", "opacity-0");
    chevronIcon.classList.remove("rotate-180");
    servicesToggle.setAttribute("aria-expanded", "false");
    servicesOpen = false;
  }

  servicesToggle.addEventListener("click", () => {
    servicesOpen ? closeServices() : openServices();
  });

  // Enter/Space billentyű
  servicesToggle.addEventListener("keydown", (e) => {
    if (e.key === "Enter" || e.key === " ") {
      e.preventDefault();
      servicesOpen ? closeServices() : openServices();
    }
  });

  // Lenyílóban kattintásra zárjon
  document.querySelectorAll("#servicesMenu a").forEach(link => {
    link.addEventListener("click", () => closeServices());
  });

  // Kívül kattintásra zárás
  document.addEventListener("click", (e) => {
    if (servicesOpen && !servicesMenu.contains(e.target) && !servicesToggle.contains(e.target)) {
      closeServices();
    }
  });

  // Scrollnál módosítsuk a pozíciót
  window.addEventListener("scroll", () => {
    if (!servicesOpen) return;
    const isAtTop = window.scrollY <= 10;
    if (isAtTop) {
      servicesMenu.classList.remove("absolute", "top-[4rem]");
      servicesMenu.classList.add("sticky", "top-[4rem]");
    } else {
      servicesMenu.classList.remove("sticky", "top-[4rem]");
      servicesMenu.classList.add("absolute", "top-[4rem]");
    }
  });

  // ESC zárja a services-t
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && servicesOpen) closeServices();
  });

  // ====== Mobile menu (offcanvas) ======
  function disableBodyScroll() { document.body.classList.add("no-scroll"); }
  function enableBodyScroll()  { document.body.classList.remove("no-scroll"); }

  function trapFocusWithin(container, event) {
    const focusables = container.querySelectorAll('a, button, input, textarea, select, [tabindex]:not([tabindex="-1"])');
    if (!focusables.length) return;
    const first = focusables[0];
    const last  = focusables[focusables.length - 1];

    if (event.shiftKey && document.activeElement === first) {
      event.preventDefault(); last.focus();
    } else if (!event.shiftKey && document.activeElement === last) {
      event.preventDefault(); first.focus();
    }
  }

  function openMobileMenu() {
    mobileMenu.classList.remove("translate-x-full");
    mobileMenu.classList.add("translate-x-0");
    mobileOverlay.classList.remove("hidden");
    hamburgerIcon.classList.add("hidden");
    closeIcon.classList.remove("hidden");
    mobileMenuToggle.setAttribute("aria-expanded", "true");
    disableBodyScroll();

    setTimeout(() => {
      const firstFocusable = mobileMenu.querySelector('a, button, [tabindex]:not([tabindex="-1"])');
      firstFocusable && firstFocusable.focus();
    }, 10);
  }

  function closeMobileMenu() {
    mobileMenu.classList.add("translate-x-full");
    mobileMenu.classList.remove("translate-x-0");
    mobileOverlay.classList.add("hidden");
    hamburgerIcon.classList.remove("hidden");
    closeIcon.classList.add("hidden");
    mobileMenuToggle.setAttribute("aria-expanded", "false");
    enableBodyScroll();
    mobileMenuToggle.focus();
  }

  mobileMenuToggle.addEventListener("click", () => {
    const isOpen = mobileMenu.classList.contains("translate-x-0");
    isOpen ? closeMobileMenu() : openMobileMenu();
  });

  mobileOverlay.addEventListener("click", closeMobileMenu);

  // Mobil menüben linkre kattintva zárjon
  document.querySelectorAll("#mobileMenu a").forEach(link => {
    link.addEventListener("click", () => closeMobileMenu());
  });

  // ESC zárja a mobil menüt
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && mobileMenu.classList.contains("translate-x-0")) {
      closeMobileMenu();
    }
  });

  // Tab csapda
  mobileMenu.addEventListener("keydown", (e) => {
    if (e.key === "Tab") trapFocusWithin(mobileMenu, e);
  });

  // Resize: md fölött csukjuk a mobil menüt; md alatt csukjuk a services dropdownt
  window.addEventListener("resize", () => {
    if (window.innerWidth < 768 && servicesOpen) closeServices();
    if (window.innerWidth >= 768 && mobileMenu.classList.contains("translate-x-0")) {
      closeMobileMenu();
    }
  });
}
