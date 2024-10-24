/*Movimiento al menu*/
document.addEventListener("DOMContentLoaded", function() {
    const menuButton = document.querySelector("a[href='#menu-anchor']");
    menuButton.addEventListener("click", function(event) {
      event.preventDefault();
      const menuSection = document.getElementById("menu-anchor");
      window.scrollTo({ top: menuSection.offsetTop, behavior: "smooth" });
    });
  });
  /*contenedor de mensaje*/
  const textarea = document.getElementById('mensaje');
  const contador = document.getElementById('caracteres');

  textarea.addEventListener('input', () => {
    const caracteres = textarea.value.length;
    contador.textContent = `${caracteres}/500`;
  });
  /*Para el telefono */
  const telefonoInput = document.getElementById('telefono');

  telefonoInput.addEventListener('keydown', (e) => {
    if (!/\d/.test(e.key) && e.key !== 'Delete' && e.key !== 'Backspace') {
      e.preventDefault();
    }
  });
  /*Para el DNI */
  const dniInput = document.getElementById('dni');

  dniInput.addEventListener('keydown', (e) => {
    if (!/\d/.test(e.key) && e.key !== 'Delete' && e.key !== 'Backspace') {
      e.preventDefault();
    }
  });
  /*Movimiento a la reserva*/
document.addEventListener("DOMContentLoaded", function() {
  const reservaButton = document.querySelector("a[href='reserva-anchor']");
  reservaButton.addEventListener("click", function(event) {
    event.preventDefault();
    const reservaSection = document.getElementById("reserva-anchor");
    window.scrollTo({ top: reservaSection.offsetTop, behavior: "smooth" });
  });
});
  /*Movimiento a contactanos*/
  document.addEventListener("DOMContentLoaded", function() {
    const contactButton = document.querySelector("a[href='contact-anchor']");
    reservaButton.addEventListener("click", function(event) {
      event.preventDefault();
      const contactSection = document.getElementById("contact-anchor");
      window.scrollTo({ top: reservaSection.offsetTop, behavior: "smooth" });
    });
  });