const list = document.querySelector(".donations-list");
var currentPage = 1;

const listarDoacoes = async (page) => {
    const data = await fetch("./listaDoacoesReceptor.php?page=" + page);
    const res = await data.text();
    list.innerHTML = res;
    currentPage = page;
}

listarDoacoes(currentPage);