function openMenu() {
    document.getElementById("userMenu").style.display = "block";
}

window.onclick = function(event) {
    var menu = document.getElementById("userMenu");

    if (menu != null){
        if (!event.target.matches('.btnMenu') && document.getElementById("userMenu").style.display == "block") {
            document.getElementById("userMenu").style.display = "none";
        }
    }
}

function passwordValidation(pw1, pw2){

    if(pw1 != pw2){
        return false;
    }
    else{
        return true;
    }
}

var data_form;
const url = window.location.protocol + '//' + window.location.host + '/cadastro/';

$(document).ready(function() {
    
    document.getElementById('cnpj').addEventListener('input', function (e) {
        var x = e.target.value.replace(/\D/g, '').match(/(\d{0,2})(\d{0,3})(\d{0,3})(\d{0,4})(\d{0,2})/);
        e.target.value = !x[2] ? x[1] : x[1] + '.' + x[2] + '.' + x[3] + '/' + x[4] + (x[5] ? '-' + x[5] : '');
    });

    $('#formCadastro').submit(function(e) {
        var inputs = document.getElementsByClassName('inputs');
        var errors = 0;
        const pw1 = $('#pw1').val();
        const pw2 = $('#pw2').val();
        const cnpj = $('#cnpj').val();

        for (var i = 0; i < inputs.length; i++) {
            if (inputs[i].value === '') {
                showError(1, inputs[i].id);
                errors++;
            } else {
                showError(2, inputs[i].id);
            }
        }

        if (pw1 != '' || pw2 != ''){
            if(!passwordValidation(pw1,pw2)){
                showError(1,'pw1');
                showError(1,'pw2');
                $('#pwError').show();
                errors++;
            } else {
                showError(2,);
                $('#pwError').hide();
            }
        }

        if (cnpj != ''){
            if (!cnpjValidation(cnpj)) {
                showError(1, 'cnpj');
                $('#error_cnpj').show();
                errors++;
            } else {
                $('#error_cnpj').hide();
                showError(2, 'cnpj');
            }
        }
        
        if (errors > 0) {
            e.preventDefault();
        }
    });
})

function showError(type, id) {
    var inputId = '#' + id;
    
    if (type == 1) {
        $(inputId).css({ 'border-color': ' #f65959' });
    } else if (type == 2) {
        $(inputId).css({ 'border-color': ' #ced4da' });
    }
}

function cnpjValidation(cnpj) {

    cnpj = cnpj.replace(/[^\d]+/g,'');

    if(cnpj == '') return false;
        
    if (cnpj.length != 14){
        return false;
    }

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
        if (pos < 2){
            pos = 9;
        }
    }

    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;

    if (resultado != digitos.charAt(0)){
        return false;
    }
            
    tamanho = tamanho + 1;
    numeros = cnpj.substring(0,tamanho);
    soma = 0;
    pos = tamanho - 7;

    for (i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2){
            pos = 9;
        }
    }

    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;

    if (resultado != digitos.charAt(1)){
        return false;
    }
            
    return true;

}