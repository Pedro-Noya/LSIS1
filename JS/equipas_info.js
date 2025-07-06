addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".equipa-card").forEach((btn) => {
        btn.addEventListener("click", () => {
            const equipa = btn.closest(".equipa-card");
            const nomeEquipa = equipa.querySelector(".nome-equipa")
            console.log("nomeEquipa:", nomeEquipa);

            /*window.location.href = '/equipas_info.php?nomeEquipa=' + encodeURIComponent(nomeEquipa);*/
        });
    });
});

