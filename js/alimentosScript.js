const list = document.querySelector(".food-list");
var currentPage = 1;
var idExcluir;

const listarAlimentos = async (page) => {
    const data = await fetch("./listaAlimentos.php?page=" + page);
    const res = await data.text();
    list.innerHTML = res;
    currentPage = page;
}

listarAlimentos(currentPage);

function setUnit(val) {
    switch (val){
        case '1':
        case '2':
        case '4':
        case '5':
        case '9':
            $('#unit').val('Kg');
            break;
        case '3':
        case '6':
            $('#unit').val('Un');
            break;
        case '7':
        case '8':
        case '10':
            $('#unit').val('L');
            break;
    }
}

function atualizaAlimentos() {
    var id = $('#foodId').val();
    var food = $('#foodDesc').val();
    var type = $('#foodType').val();
    var amount = $('#amount').val();
    var unit = $('#unit').val();
    var validity = $('#validity').val();

    $.ajax({
        url: 'cadastroAlimentos.php',
        method: 'POST',
        data: {id: id, food: food, foodType: type, amount: amount, unit: unit, validity: validity},
        dataType: 'json'
    }).done(function(data) {
        $('#foodModal').modal('hide');

        listarAlimentos(currentPage);

        document.getElementById("successMsg").innerHTML = data;

        alert(1);
    });
}

function setaIdExcluir(val) {
    idExcluir = val;
}

function excluiAlimento(){
    $.ajax({
        url: 'excluirAlimento.php',
        method: 'POST',
        data: {id: idExcluir},
        dataType: 'json'
    }).done(function(data) {
        if(data){
            $('#deleteModal').modal('hide');

            if (data.errors != 0){
                
                document.getElementById("alertMsg").innerHTML = data.msg;

                alert(2);

            } else {
                listarAlimentos(currentPage);

                document.getElementById("successMsg").innerHTML = data.msg;

                alert(1);
            }
        }
    });
}

function novoAlimento(val, id) {
    if(val){
        document.getElementById('foodForm').reset();
        $('#addButton').show();
        $('#saveButton').hide();
    } else {
        $('#addButton').hide();
        $('#saveButton').show();

        $.ajax({
            url: 'buscaAlimento.php',
            method: 'POST',
            data: {id: id},
            dataType: 'json'
        }).done(function(data) {
            $('#foodId').val(id);
            $('#foodDesc').val(data.descricao);
            $('#foodType').val(data.tipo);
            $('#amount').val(data.quantidade);
            $('#unit').val(data.unidade);
            $('#validity').val(data.validade);
        });
    }
}

function setaDoacao(id){
    $.ajax({
        url: 'buscaAlimento.php',
        method: 'POST',
        data: {id: id},
        dataType: 'json'
    }).done(function(data) {
        $('#donateId').val(id);
        $('#donateDesc').val(data.descricao);
        $('#donateUnit').val(data.unidade);
        $('#donateAmount').val("");
    });
}

function doarAlimento() {
    var id = $('#donateId').val();
    var amount = $('#donateAmount').val();

    $.ajax({
        url: 'doar.php',
        method: 'POST',
        data: {id: id, amount: amount},
        dataType: 'json'
    }).done(function(data) {
        if(data){
            $('#donateModal').modal('hide');

            if (data.errors != 0){
                
                document.getElementById("alertMsg").innerHTML = data.msg;

                alert(2);

            } else {
                listarAlimentos(currentPage);

                document.getElementById("successMsg").innerHTML = data.msg;

                alert(1);
            }
            //console.log(data.id);
        }
    });
}

function alert(val){

    if(val == 1) {

        $("#successAlert").fadeIn("fast", function(){
            $(this).show();
        });
        setTimeout(function(){
            $("#successAlert").fadeOut("slow", function(){
                $(this).hide();
            });
        }, 3000);

    } else if (val == 2) {

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