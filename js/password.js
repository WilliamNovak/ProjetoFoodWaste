function validaEnvioEmail() {
    var email = $('#email').val();

    $.ajax({
        url: 'enviaEmail.php',
        method: 'POST',
        data: {email: email},
        dataType: 'json'
    }).done(function(data) {
        if(data){
            $('#donateModal').modal('hide');

            if (data.errors != 0){
                
                document.getElementById("alertMsg").innerHTML = data.msg;

                alert();

            } else {
                window.location = "localhost/ProjetoFoodWaste/tokenSenha.php";
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