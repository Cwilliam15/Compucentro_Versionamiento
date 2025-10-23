document.getElementById("form-contacto").addEventListener("submit", async function(e) {
  e.preventDefault();

  const formData = new FormData(this);

  try {
    const response = await fetch(this.action, {
      method: "POST",
      body: formData
    });

    if (response.ok) {
      alert("✅ ¡Tu mensaje se envió correctamente!");
      this.reset();
    } else {
      alert("❌ Hubo un error al enviar el mensaje. Intenta de nuevo.");
    }
  } catch (error) {
    alert("⚠️ No se pudo conectar con el servidor.");
  }
});
