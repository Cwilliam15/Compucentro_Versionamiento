document.addEventListener("DOMContentLoaded", () => {
  const ctx = document.getElementById("chartCursos");
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Ofimática', 'Excel Avanzado', 'Reparación PC', 'Diseño Gráfico', 'Programación'],
      datasets: [{
        label: 'Interesados por curso',
        data: [12, 19, 8, 15, 10],
        backgroundColor: '#FF6A03'
      }]
    },
    options: {
      scales: {
        y: { beginAtZero: true }
      }
    }
  });
});
