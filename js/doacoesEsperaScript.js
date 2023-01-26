const list = document.querySelector(".receiver-list");
var currentPage = 1;
var donationId;

const listarDoacoesEspera = async (page) => {
    const data = await fetch("./listaDoacoesEspera.php?page=" + page);
    const res = await data.text();
    list.innerHTML = res;
    currentPage = page;
}

listarDoacoesEspera(currentPage);

function setDonationId(val) {
    donationId = val;
}

function refuseDonation(){

    $.ajax({
        url: 'doar.php',
        method: 'POST',
        data: {iddoacao: donationId},
        dataType: 'json'
    }).done(function(data) {
        if(data){
            $('#refuseModal').modal('hide');
            listarDoacoesEspera(currentPage);

            if (data.errors != 0){
                
                document.getElementById("alertMsg").innerHTML = data.msg;

                alert(2);

            } else {
                
                document.getElementById("successMsg").innerHTML = data.msg;

                alert(1);
            }
        }
    });
}

function acceptDonation(){
    $.ajax({
        url: 'aceitarDoacao.php',
        method: 'POST',
        data: {iddoacao: donationId},
        dataType: 'json'
    }).done(function(data) {
        if(data){
            $('#acceptModal').modal('hide');
            listarDoacoesEspera(currentPage);

            if (data.errors != 0){
                
                document.getElementById("alertMsg").innerHTML = data.msg;

                alert(2);

            } else {
                
                document.getElementById("successMsg").innerHTML = data.msg;

                alert(1);
            }
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