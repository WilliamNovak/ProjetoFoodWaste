const list = document.querySelector(".receiver-list");
var currentPage = 1;

const listarDoacoesEspera = async (page) => {
    const data = await fetch("./listaDoacoesEspera.php?page=" + page);
    const res = await data.text();
    list.innerHTML = res;
    currentPage = page;
}

listarDoacoesEspera(currentPage);