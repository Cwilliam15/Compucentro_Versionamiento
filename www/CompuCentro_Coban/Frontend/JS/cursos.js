

//Efecto de carga 
window.addEventListener("load", () => document.body.classList.add("loaded"));

//Autorellenar el curso en preinscripción
document.addEventListener("DOMContentLoaded", () => {
  // Detectar si estamos en la página de preinscripción
  if (window.location.pathname.includes("preinscripcion.html")) {
    const params = new URLSearchParams(window.location.search);
    const cursoSeleccionado = params.get("curso");

    if (cursoSeleccionado) {
      // Buscar el campo correspondiente
      const campoCurso = document.querySelector('input[name="cursoPreferencia"], select[name="cursoPreferencia"]');
      if (campoCurso) {
        campoCurso.value = cursoSeleccionado;
      }
    }
  }
});
