document.addEventListener("DOMContentLoaded", () => {
  const tarjetas = document.querySelectorAll(".card");

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) entry.target.classList.add("visible");
    });
  }, { threshold: 0.15 });

  tarjetas.forEach(t => observer.observe(t));
});
