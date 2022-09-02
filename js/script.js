function openMenu() {
    document.getElementById("userMenu").style.display = "block";
}

window.onclick = function(event) {
    if (!event.target.matches('.btnMenu') && document.getElementById("userMenu").style.display == "block") {
        document.getElementById("userMenu").style.display = "none";
    }
  }