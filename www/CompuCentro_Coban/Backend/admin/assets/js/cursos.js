document.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector(".form-curso");
  if (form) {
    form.addEventListener("submit", (e) => {
      const nombre = form.nombre.value.trim();
      if (nombre.length < 3) {
        alert("⚠️ El nombre del curso debe tener al menos 3 caracteres.");
        e.preventDefault();
      }
    });
  }
});
