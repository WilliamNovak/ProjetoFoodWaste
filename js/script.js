function openMenu() {
    document.getElementById("userMenu").style.display = "block";
}

window.onclick = function(event) {
    if (!event.target.matches('.btnMenu') && document.getElementById("userMenu").style.display == "block") {
        document.getElementById("userMenu").style.display = "none";
    }
}

// function validaCadastro(){
//     var pw1 = document.getElementById("pw1").value;
//     var pw2 = document.getElementById("pw2").value;
//     var errPw1 = document.getElementById("errPw1");
//     var errPw2 = document.getElementById("errPw2");

//     if(pw1 != pw2){
//         errPw1.innerHTML = 'As senhas não são compatíveis.';
//         errPw2.innerHTML = 'As senhas não são compatíveis.';
//         return false;
//     }
//     else{
//         return true;
//     }
// }

var data_form;
const url = window.location.protocol + '//' + window.location.host + '/cadastro/';

$(document).ready(function() {
    $('#btnSubmit').click(function() {
        var inputs = document.getElementsByClassName('inputs');
        var errors = 0;
        for (var i = 0; i < inputs.length; i++) {
            if (inputs[i].value === '') {
                toggle_erro(1, inputs[i].id);
                errors++;
            } else {
                toggle_erro(2, inputs[i].id);
            }
        }

        if (!validation_cnpj($('#cnjp').val())) {
            toggle_erro(1, 'cnpj');
            $('#error_cpnj').show();
            errors++;
        } else {
            $('#error_cpnj').hide();
            toggle_erro(2, 'cnpj');
        }

        if (errors === 0) {
            data_form = {
                'username': $('#username').val(),
                'password': $('#pw1').val(),
                'confirmPassword': $('#pw2').val(),
                'fantasyName': $('#fantasyName').val(),
                'reason': $('#reason').val(),
                'email': $('#email').val(),
                'tel': $('#tel').val(),
                'cnpj': $('#cnpj').val(),
                'cep': $('#cep').val(),
                'state': $('#state').val(),
                'city': $('#city').val(),
                'address': $('#address').val(),
                'num': $('#num').val(),
            }
        } else {
            $('#msg_erro').fadeIn(800);
            setTimeout(function() {
                $('#msg_erro').fadeOut(800);
            }, 3000);
        }
    });
})

function toggle_erro(type, id) {
    if (type == 1) {
        $('#' + id).css({ 'border-color': ' #f65959' });
    } else if (type == 2) {
        $('#' + id).css({ 'border-color': ' #ced4da' });
    }
}

function validation_cnpj(cnpj) {

    cnpj = cnpj.replace(/[^\d]+/g,'');

    if(cnpj == '') return false;
        
    if (cnpj.length != 14)
        return false;

    // Elimina CNPJs invalidos conhecidos
    if (cnpj == "00000000000000" || 
        cnpj == "11111111111111" || 
        cnpj == "22222222222222" || 
        cnpj == "33333333333333" || 
        cnpj == "44444444444444" || 
        cnpj == "55555555555555" || 
        cnpj == "66666666666666" || 
        cnpj == "77777777777777" || 
        cnpj == "88888888888888" || 
        cnpj == "99999999999999")
        return false;
            
    // Valida DVs
    tamanho = cnpj.length - 2
    numeros = cnpj.substring(0,tamanho);
    digitos = cnpj.substring(tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(0))
        return false;
            
    tamanho = tamanho + 1;
    numeros = cnpj.substring(0,tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(1))
            return false;
            
    return true;

}