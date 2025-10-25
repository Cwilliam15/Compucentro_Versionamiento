// --- Detectar curso desde la URL y mostrar aviso ---
const params = new URLSearchParams(window.location.search);
const cursoUrl = params.get("curso");

// --- Llenar select de cursos y jornadas dinámicamente ---
document.addEventListener("DOMContentLoaded", async () => {
  const selectCurso = document.getElementById("curso_preferencia");
  const selectJornada = document.getElementById("jornada");

  try {
    const response = await fetch("../../Backend/admin/src/api_listar_ofertas.php");
    const data = await response.json();

    if (Array.isArray(data) && data.length > 0) {
      const cursosUnicos = {};

      // Agrupar cursos por nombre
      data.forEach(oferta => {
        if (!cursosUnicos[oferta.curso]) cursosUnicos[oferta.curso] = [];
        cursosUnicos[oferta.curso].push(oferta);
      });

      // Llenar el select de cursos
      selectCurso.innerHTML = '<option value="" disabled selected hidden>Selecciona un curso...</option>';
      Object.keys(cursosUnicos).forEach(nombre => {
        const option = document.createElement("option");
        option.value = nombre;
        option.textContent = nombre;
        selectCurso.appendChild(option);
      });

      // Si el curso vino desde la URL (por el botón "Preinscríbete")
      if (cursoUrl && cursosUnicos[decodeURIComponent(cursoUrl)]) {
        selectCurso.value = decodeURIComponent(cursoUrl);
        selectCurso.disabled = true;
        const jornadas = cursosUnicos[decodeURIComponent(cursoUrl)];

        // Llenar jornadas con su id_oferta como value
        selectJornada.innerHTML = '<option value="" disabled selected hidden>Selecciona una jornada...</option>';
        jornadas.forEach(j => {
          const option = document.createElement("option");
          option.value = j.id_oferta; // 🔹 este valor se envía al backend
          option.textContent = j.jornada;
          selectJornada.appendChild(option);
        });

        if (jornadas.length === 1) {
          selectJornada.value = jornadas[0].id_oferta;
        }
      }

      // Cuando el usuario cambia el curso manualmente
      selectCurso.addEventListener("change", () => {
        const cursoSeleccionado = selectCurso.value;
        const jornadas = cursosUnicos[cursoSeleccionado] || [];

        selectJornada.innerHTML = '<option value="" disabled selected hidden>Selecciona una jornada...</option>';
        jornadas.forEach(j => {
          const option = document.createElement("option");
          option.value = j.id_oferta;
          option.textContent = j.jornada;
          selectJornada.appendChild(option);
        });

        if (jornadas.length === 1) {
          selectJornada.value = jornadas[0].id_oferta;
        }
      });

    } else {
      selectCurso.innerHTML = '<option disabled>No hay cursos disponibles</option>';
    }

  } catch (err) {
    console.error("Error de conexión:", err);
    selectCurso.innerHTML = '<option disabled>Error al cargar cursos</option>';
  }
});

// --- Mostrar aviso visual si se llegó desde un curso específico ---
if (cursoUrl) {
  const aviso = document.createElement("div");
  aviso.innerHTML = `
    <i class="fa-solid fa-circle-info" style="color:#083B70; margin-right:8px;"></i>
    Estás preinscribiéndote al curso: <b>${decodeURIComponent(cursoUrl)}</b>
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

  const formContainer = document.querySelector(".form-container");
  if (formContainer) formContainer.prepend(aviso);
}
