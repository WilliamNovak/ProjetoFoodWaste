var idExcluir;

function setUnit(val) {
    switch (val){
        case '1':
        case '2':
        case '5':
        case '9':
            $('#unit').val('Kg');
            break;
        case '3':
        case '4':
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

function novoAlimento(val) {
    if(val){
        $('#addButton').show();
        $('#saveButton').hide();
    } else {
        $('#addButton').hide();
        $('#saveButton').show();
    }
}