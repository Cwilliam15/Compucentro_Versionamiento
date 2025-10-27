const modal = document.getElementById("modal");
const btnAgregar = document.getElementById("btnAgregar");
const closeModal = document.getElementById("closeModal");

btnAgregar.onclick = () => modal.style.display = "block";
closeModal.onclick = () => modal.style.display = "none";
window.onclick = (e) => { if (e.target === modal) modal.style.display = "none"; }
