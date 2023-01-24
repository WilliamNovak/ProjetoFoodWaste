const list = document.querySelector(".donation-list");
var currentPage = 1;

const listarDoacoes = async (page) => {
    const data = await fetch("./listaDoacoes.php?page=" + page);
    const res = await data.text();
    list.innerHTML = res;
    currentPage = page;
}

listarDoacoes(currentPage);