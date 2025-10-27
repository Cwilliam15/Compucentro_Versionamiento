document.addEventListener("DOMContentLoaded", () => {

  const selectCurso = document.getElementById("curso_preferencia");
  const selectJornada = document.getElementById("jornada");

  // 1) Cargar cursos
  fetch("../../Backend/src/PHP/obtener_cursos.php")
    .then(res => res.json())
    .then(data => {
      selectCurso.innerHTML = `<option value="" disabled selected hidden></option>`;
      data.forEach(c => {
        selectCurso.innerHTML += `<option value="${c.id_curso}">${c.nombre}</option>`;
      });
    });

  // 2) Cuando el usuario elige un curso → cargar jornadas
  selectCurso.addEventListener("change", () => {
    const idCurso = selectCurso.value;

    fetch(`../../Backend/src/PHP/obtener_jornadas.php?curso=${idCurso}`)
      .then(res => res.json())
      .then(data => {
        selectJornada.innerHTML = `<option value="" disabled selected hidden></option>`;
        data.forEach(j => {
          selectJornada.innerHTML += `<option value="${j.id_jornada}">${j.nombre}</option>`;
        });
      });
  });

});
