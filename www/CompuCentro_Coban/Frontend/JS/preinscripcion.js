// --- Detectar curso desde la URL y autocompletar el campo ---
const params = new URLSearchParams(window.location.search);
const cursoSeleccionado = params.get("curso");

if (cursoSeleccionado) {
  const campoCurso = document.querySelector("#curso");
  if (campoCurso) {
    campoCurso.value = decodeURIComponent(cursoSeleccionado);
    // Opcional: evitar que el usuario lo cambie
    campoCurso.readOnly = true;
  }
}

// Mostrar aviso visual arriba del formulario
if (cursoSeleccionado) {
  const aviso = document.createElement("div");
  aviso.innerHTML = `
    <i class="fa-solid fa-circle-info" style="color:#083B70; margin-right:8px;"></i>
    Estás preinscribiéndote al curso: <b>${decodeURIComponent(cursoSeleccionado)}</b>
  `;
  aviso.style.background = "#eaf2fc";
  aviso.style.color = "#083B70";
  aviso.style.fontWeight = "600";
  aviso.style.padding = "12px 15px";
  aviso.style.borderRadius = "10px";
  aviso.style.textAlign = "center";
  aviso.style.marginBottom = "20px";
  aviso.style.borderLeft = "4px solid #ff7b00";
  aviso.style.boxShadow = "0 2px 6px rgba(0,0,0,0.1)";
  aviso.style.animation = "fadeIn 1s ease";

  const formulario = document.querySelector(".form-container");
  if (formulario) formulario.prepend(aviso);
}



