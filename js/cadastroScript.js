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

})

function validaForm() {
    var inputs = document.getElementsByClassName('inputs');
    var errors = 0;
    const pw1 = $('#pw1').val();
    const pw2 = $('#pw2').val();
    const cnpj = $('#cnpj').val();
    const username = $('#username').val();
    const tel = $('#tel').val();
    const email = $('#email').val();

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
            showError(2,'pw1');
            showError(2,'pw2');
            $('#pwError').hide();
        }
    }

    if (email != ''){
        if (!validateEmail(email)) {
            showError(1,'email');
            $('#email_error').show();
            errors++;
        } else {
            showError(2,'email');
            $('#email_error').hide();
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

    $.ajax({
        url: 'validaCadastro.php',
        method: 'POST',
        data: {username: username, tel: tel, email: email, cnpj: cnpj},
        dataType: 'json'
    }).done(function(data) {
        if (data.errors > 0){
            errors++;

            if (data.userError > 0) {
                showError(1,'username');
                $('#user_error').show();
            } else {
                showError(2,'username');
                $('#user_error').hide();
            }

            if (data.telError > 0) {
                showError(1,'tel');
                $('#tel_error').show();
            } else {
                showError(2,'tel');
                $('#tel_error').hide();
            }

            if (data.emailError > 0) {
                showError(1,'email');
                $('#email_error').show();
            } else {
                showError(2,'email');
                $('#email_error').hide();
            }

            if (data.cnpjError > 0) {
                showError(1,'cnpj');
                $('#error_cnpj').show();
            }

            if (data.databaseError != ""){
                document.getElementById("alertMsg").innerHTML = data.databaseError;

                $("#errorAlert").fadeIn("fast", function(){
                    $(this).show();
                });
                setTimeout(function(){
                    $("#errorAlert").fadeOut("slow", function(){
                        $(this).hide();
                    });
                }, 3000);
            }
        }

        if (errors == 0){
            $('#formCadastro').submit();
        }
    });
};

function showError(type, id) {
    var inputId = '#' + id;
    
    if (type == 1) {
        $(inputId).css({ 'border-color': ' #f65959' });
    } else if (type == 2) {
        $(inputId).css({ 'border-color': ' #ced4da' });
    }
}

function validateEmail(email) {
    const pattern = /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/;
    return pattern.test(email);
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

function clearCepForm() {
    document.getElementById('cep').value=("");
    document.getElementById('street').value=("");
    document.getElementById('district').value=("");
    document.getElementById('city').value=("");
    document.getElementById('state').value=("");
}

function my_callback(content) {

    if (!("erro" in content)) {
        document.getElementById('street').value=(content.logradouro);
        document.getElementById('district').value=(content.bairro);
        document.getElementById('city').value=(content.localidade);
        document.getElementById('state').value=(content.uf);
    } else {
        clearCepForm(cep);
        $('#error_cepI').hide();
        showError(1, 'cep');
        $('#error_cepE').show();

    }
}
    
function pesquisacep(valor) {

    var cep = valor.replace(/\D/g, '');

    if (cep != "") {

        var validacep = /^[0-9]{8}$/;
        
        if(validacep.test(cep)) {

            document.getElementById('street').value="...";
            document.getElementById('district').value="...";
            document.getElementById('city').value="...";
            document.getElementById('state').value="...";

            var script = document.createElement('script');

            script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=my_callback';

            document.body.appendChild(script);

            $('#error_cepE').hide();
            $('#error_cepI').hide();
            showError(2, 'cep');

        } else {
            clearCepForm();
            $('#error_cepE').hide();
            showError(1, 'cep');
            $('#error_cepI').show();

        }

    } else {
        clearCepForm();
    }
};

const cepInput = document.getElementById("cep");

cepInput.addEventListener("keyup", formatarCep);

function formatarCep(e){

    var v = e.target.value.replace(/\D/g,"")                

    v = v.replace(/^(\d{5})(\d)/,"$1-$2") 

    e.target.value = v;

}

function mascara(obj,fun){
    v_obj = obj
    v_fun = fun
    setTimeout("execmascara()",1)
}

function execmascara(){
    v_obj.value = v_fun(v_obj.value)
}

function mtel(v){
    v = v.replace(/\D/g,"");
    v = v.replace(/^(\d{2})(\d)/g,"($1) $2");
    v = v.replace(/(\d)(\d{4})$/,"$1-$2");
    return v;
}

function getElement( el ){
	return document.getElementById( el );
}
window.onload = function(){
	getElement('tel').onkeyup = function(){
		mascara( this, mtel );
	}
}