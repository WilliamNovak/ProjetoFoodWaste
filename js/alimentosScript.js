const list = document.querySelector(".food-list");

const listarAlimentos = async (page) => {
    const data = await fetch("./listaAlimentos.php?page=" + page);
    const res = await data.text();
    list.innerHTML = res;
}

listarAlimentos(1);

var idExcluir;

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
            document.location.reload(true);
        }
    });
}

function novoAlimento(val, id) {
    if(val){
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