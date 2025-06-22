const tipoContratoSelect = document.getElementById("tipoContrato");
const camposExtras = document.getElementById("camposContratoExtras");

document.addEventListener("DOMContentLoaded", function () {
    tipoContratoSelect.addEventListener("change", function () {
        const contrato = this.value;

        if (["Termo certo", "Termo incerto", "Estágio"].includes(contrato)) {
        camposExtras.style.display = "block";
        } else {
        camposExtras.style.display = "none";
        }
    });
});