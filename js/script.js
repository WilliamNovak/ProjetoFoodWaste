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
    var errPw1 = document.getElementById("errPw1");
    var errPw2 = document.getElementById("errPw2");

    if(pw1 != pw2){
        errPw1.innerHTML = 'As senhas não são compatíveis.';
        errPw2.innerHTML = 'As senhas não são compatíveis.';
        return false;
    }
    else{
        return true;
    }
}