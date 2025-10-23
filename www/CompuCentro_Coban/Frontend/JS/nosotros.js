document.addEventListener("DOMContentLoaded", () => {
  //VALORES
  const valores = document.querySelectorAll(".valor");
  if (valores.length) {
    const valoresObserver = new IntersectionObserver((entries) => {
      if (entries.some(e => e.isIntersecting)) {
        valores.forEach((valor, i) => {
          setTimeout(() => valor.classList.add("visible"), i * 200);
        });
      } else {
        valores.forEach((valor) => valor.classList.remove("visible"));
      }
    }, { threshold: 0.25 });
    valores.forEach(v => valoresObserver.observe(v));
  }
  //MISIÓN / VISIÓN 
  const cards = document.querySelectorAll(".card");
  if (cards.length) {
    const cardsObserver = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) entry.target.classList.add("visible");
        else entry.target.classList.remove("visible");
      });
    }, { threshold: 0.2 });
    cards.forEach(c => cardsObserver.observe(c));
  }

  //SECCIONES CON .reveal 
  const revealSections = document.querySelectorAll(".reveal");
  if (revealSections.length) {
    const revealObserver = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) entry.target.classList.add("visible");
        else entry.target.classList.remove("visible");
      });
    }, { threshold: 0.15, rootMargin: "0px 0px -10% 0px" });
    revealSections.forEach(sec => revealObserver.observe(sec));
  }
});
