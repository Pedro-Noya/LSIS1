
function toggleDetalhes(id) {
    const modal = document.getElementById("modal");
    const detalhes = document.getElementById("detalhes-" + id);
    const container = document.getElementById("modal-detalhes");

    container.innerHTML = detalhes.innerHTML;
    modal.style.display = "flex";
}

function fecharModal() {
    document.getElementById("modal").style.display = "none";
}