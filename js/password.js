function validaEnvioEmail() {
    var email = $('#email').val();

    $.ajax({
        url: 'enviaEmail.php',
        method: 'POST',
        data: {email: email},
        dataType: 'json'
    }).done(function(data) {
        if(data){
            if (data.errors != 0){
                
                document.getElementById("alertMsg").innerHTML = data.msg;

                alert();

            } else {
                window.location = "tokenSenha.php";
            }
        }
    });
}

function validaPw(token) {
    var pw1 = $('#pw1').val();
    var pw2 = $('#pw2').val();

    $.ajax({
        url: 'atualizaSenha.php',
        method: 'POST',
        data: {token: token, password: pw1, confirmPassword: pw2},
        dataType: 'json'
    }).done(function(data) {
        if(data){
            if (data.errors != 0){
                
                document.getElementById("alertMsg").innerHTML = data.msg;

                alert();

            } else {
                window.location = "login.php?pwMsg="+data.msg;
            }
        }
    });
}

function alert(){
    $("#errorAlert").fadeIn("fast", function(){
        $(this).show();
    });
    setTimeout(function(){
        $("#errorAlert").fadeOut("slow", function(){
            $(this).hide();
        });
    }, 3000);
}