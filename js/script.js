function openMenu() {
    document.getElementById("userMenu").style.display = "block";
}

window.onclick = function(event) {
    if (!event.target.matches('.btnMenu') && document.getElementById("userMenu").style.display == "block") {
        document.getElementById("userMenu").style.display = "none";
    }
}

function validaCadastro(){
    var pw1 = document.getElementById("pw1").value;
    var pw2 = document.getElementById("pw2").value;

    console.log(pw1 + " - " + pw2);

    if(pw1 != pw2){
        return false;
    }
    else{
        return true;
    }
}