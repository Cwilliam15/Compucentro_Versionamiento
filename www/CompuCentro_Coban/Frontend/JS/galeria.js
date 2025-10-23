const modal = document.getElementById("modal");
const modalImg = document.getElementById("imgModal");
const captionText = document.getElementById("caption");
const cerrar = document.getElementById("cerrar");
const imgs = document.querySelectorAll(".item img");
const prev = document.getElementById("prev");
const next = document.getElementById("next");
const miniaturas = document.getElementById("miniaturas");

let currentIndex = 0;

// Crear miniaturas
imgs.forEach((img, index) => {
  const thumb = document.createElement("img");
  thumb.src = img.src;
  thumb.dataset.index = index;
  thumb.alt = img.alt;
  thumb.addEventListener("click", () => showImage(index));
  miniaturas.appendChild(thumb);
});

// Mostrar modal al hacer clic en una imagen
imgs.forEach((img, index) => {
  img.addEventListener("click", () => {
    modal.style.display = "flex";
    showImage(index);
  });
});

// Función para mostrar imagen
function showImage(index) {
  currentIndex = index;

  // Efecto suave de cambio
  modalImg.style.opacity = 0;
  setTimeout(() => {
    modalImg.src = imgs[index].src;
    modalImg.alt = imgs[index].alt;
    modalImg.setAttribute("aria-label", imgs[index].alt);
    captionText.textContent = imgs[index].alt;
    modalImg.style.opacity = 1;
  }, 150);

  // Marcar miniatura activa
  document.querySelectorAll(".miniaturas img").forEach(t => t.classList.remove("active"));
  miniaturas.children[index].classList.add("active");
}

// Cerrar modal con clic en la X
cerrar.addEventListener("click", () => {
  modal.style.display = "none";
});

// Navegación con flechas (en pantalla)
prev.addEventListener("click", () => {
  currentIndex = (currentIndex - 1 + imgs.length) % imgs.length;
  showImage(currentIndex);
});
next.addEventListener("click", () => {
  currentIndex = (currentIndex + 1) % imgs.length;
  showImage(currentIndex);
});

// Auto-play cada () segundos (solo si el modal está abierto)
setInterval(() => {
  if (modal.style.display === "flex") {
    currentIndex = (currentIndex + 1) % imgs.length;
    showImage(currentIndex);
  }
}, 12000);

// Navegación con teclado (izquierda, derecha, ESC)
document.addEventListener("keydown", (e) => {
  if (modal.style.display === "flex") {
    if (e.key === "ArrowRight") {
      currentIndex = (currentIndex + 1) % imgs.length;
      showImage(currentIndex);
    }
    if (e.key === "ArrowLeft") {
      currentIndex = (currentIndex - 1 + imgs.length) % imgs.length;
      showImage(currentIndex);
    }
    if (e.key === "Escape") {
      modal.style.display = "none";
    }
  }
});

// Cerrar modal al hacer clic fuera de la imagen
modal.addEventListener("click", (e) => {
  if (e.target === modal) modal.style.display = "none";
});
