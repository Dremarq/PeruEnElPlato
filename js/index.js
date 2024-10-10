document.addEventListener("DOMContentLoaded", function() {
    const menuButton = document.querySelector("a[href='#menu-anchor']");
    menuButton.addEventListener("click", function(event) {
      event.preventDefault();
      const menuSection = document.getElementById("menu-anchor");
      window.scrollTo({ top: menuSection.offsetTop, behavior: "smooth" });
    });
  });