// HEADER INTERAKCIÓK – DOMContentLoaded nélkül!

const servicesToggle = document.getElementById("servicesToggle");
const servicesMenu = document.getElementById("servicesMenu");
const chevronIcon = document.getElementById("chevronIcon");
const mobileMenuToggle = document.getElementById("mobileMenuToggle");
const mobileMenu = document.getElementById("mobileMenu");
const mobileOverlay = document.getElementById("mobileOverlay");
const hamburgerIcon = document.getElementById("hamburgerIcon");
const closeIcon = document.getElementById("closeIcon");

if (
  !servicesToggle ||
  !servicesMenu ||
  !chevronIcon ||
  !mobileMenuToggle ||
  !mobileMenu ||
  !mobileOverlay ||
  !hamburgerIcon ||
  !closeIcon
) {
  console.warn("Header elemek hiányoznak – header-scripts.js");
} else {
  let servicesOpen = false;

  servicesToggle.addEventListener("click", () => {
    servicesOpen = !servicesOpen;
    const isAtTop = window.scrollY <= 10;

    if (servicesOpen) {
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
    } else {
      servicesMenu.classList.remove("max-h-[300px]", "opacity-100");
      servicesMenu.classList.add("max-h-0", "opacity-0");
      chevronIcon.classList.remove("rotate-180");
    }
  });

  function closeMobileMenu() {
    mobileMenu.classList.add("translate-x-full");
    mobileMenu.classList.remove("translate-x-0");
    mobileOverlay.classList.add("hidden");
    hamburgerIcon.classList.remove("hidden");
    closeIcon.classList.add("hidden");
    document.body.classList.remove("no-scroll");
  }

  mobileMenuToggle.addEventListener("click", () => {
    const isOpen = mobileMenu.classList.contains("translate-x-0");
    if (!isOpen) {
      mobileMenu.classList.remove("translate-x-full");
      mobileMenu.classList.add("translate-x-0");
      mobileOverlay.classList.remove("hidden");
      hamburgerIcon.classList.add("hidden");
      closeIcon.classList.remove("hidden");
      document.body.classList.add("no-scroll");
    } else {
      closeMobileMenu();
    }
  });

  mobileOverlay.addEventListener("click", closeMobileMenu);

  window.addEventListener("resize", () => {
    if (window.innerWidth < 768 && servicesOpen) {
      servicesMenu.classList.remove("max-h-[300px]", "opacity-100");
      servicesMenu.classList.add("max-h-0", "opacity-0");
      chevronIcon.classList.remove("rotate-180");
      servicesOpen = false;
    }

    if (window.innerWidth >= 768) {
      closeMobileMenu();
    }
  });
}
