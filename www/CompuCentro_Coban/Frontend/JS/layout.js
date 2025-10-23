document.addEventListener("DOMContentLoaded", () => {
  // === Menú responsivo hamburguesa ===
  const menuToggle = document.getElementById("menu-toggle");
  const nav = document.getElementById("nav");

  if (menuToggle && nav) {
    menuToggle.addEventListener("click", () => {
      nav.classList.toggle("active");
      menuToggle.classList.toggle("abierto");
    });
  }

  // === Cierra el menú automáticamente al hacer clic en un enlace ===
  const enlaces = nav?.querySelectorAll("a") || [];
  enlaces.forEach((enlace) => {
    enlace.addEventListener("click", () => {
      nav.classList.remove("active");
      menuToggle.classList.remove("abierto");
    });
  });

  // === Efecto “shrink” del header al hacer scroll ===
  const header = document.querySelector("header");
  window.addEventListener("scroll", () => {
    if (window.scrollY > 50) {
      header.classList.add("scrolled");
    } else {
      header.classList.remove("scrolled");
    }
  });
});
