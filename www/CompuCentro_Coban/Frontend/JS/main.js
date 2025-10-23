document.addEventListener("DOMContentLoaded", () => {
  // === Carrusel automático con flechas y puntos ===
  const slides = document.querySelectorAll(".hero-carrusel .slide");
  const puntosContainer = document.querySelector(".puntos");
  let index = 0;

  // Crear los puntos de navegación
  slides.forEach((_, i) => {
    const punto = document.createElement("div");
    punto.classList.add("punto");
    if (i === 0) punto.classList.add("active");
    punto.addEventListener("click", () => {
      mostrarSlide(i);
      reiniciarIntervalo();
    });
    puntosContainer.appendChild(punto);
  });

  const puntos = document.querySelectorAll(".punto");
  slides[index].classList.add("active");

  function mostrarSlide(nuevoIndex) {
    slides[index].classList.remove("active");
    puntos[index].classList.remove("active");
    index = (nuevoIndex + slides.length) % slides.length;
    slides[index].classList.add("active");
    puntos[index].classList.add("active");
  }

  function cambiarSlide() {
    mostrarSlide(index + 1);
  }

  let intervalo = setInterval(cambiarSlide, 14000);

  // Flechas
  document.querySelector(".flecha-izq").addEventListener("click", () => {
    mostrarSlide(index - 1);
    reiniciarIntervalo();
  });

  document.querySelector(".flecha-der").addEventListener("click", () => {
    mostrarSlide(index + 1);
    reiniciarIntervalo();
  });

  function reiniciarIntervalo() {
    clearInterval(intervalo);
    intervalo = setInterval(cambiarSlide, 14000);
  }

  // ✅ Control con el teclado
  document.addEventListener("keydown", (e) => {
    if (e.key === "ArrowLeft") {
      mostrarSlide(index - 1);
      reiniciarIntervalo();
    }
    if (e.key === "ArrowRight") {
      mostrarSlide(index + 1);
      reiniciarIntervalo();
    }
  });
});
