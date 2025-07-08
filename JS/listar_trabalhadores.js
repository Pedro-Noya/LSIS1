const converterPapel = {
    1: 'Colaborador',
    2: 'Coordenador',
    3: 'Recursos Humanos',
    4: 'Administrador'
};

function atualizarPerfil(email) {
    window.location.href = 'InformacoesColaborador.php?email=' + encodeURIComponent(email);
}

function mostrarCategoria() {
  const categorias = document.querySelectorAll('.categoria');
  categorias.forEach(div => div.style.display = 'none');

  const selecionada = document.getElementById('categoria').value;
  if (selecionada) {
    document.getElementById(selecionada).style.display = 'block';
  }
}

function definirPapel(email) {
    const select = document.getElementById('papel-' + email);
    const papel = select.value;

    if (!papel) {
        alert("Por favor selecione um papel válido.");
        return;
    }

    fetch('definir_papel.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'email=' + encodeURIComponent(email) + '&papel=' + encodeURIComponent(papel)
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert("Papel de " + email + " definido para " + papel);
            window.location.reload(); // or update table dynamically
        } else {
            alert("Erro ao atualizar papel.");
        }
    })
    .catch(() => alert("Erro de rede ou servidor."));
}


function definirNivel(email) {
    const select = document.getElementById('nivel-' + email);
    const nivel = select.value;

    fetch('definir_nivel.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'email=' + encodeURIComponent(email) + '&nivel=' + encodeURIComponent(nivel)
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert("Nível de " + email + " atualizado para " + nivel);
        } else {
            alert("Erro ao atualizar nível.");
        }
    })
}

function exportarDados(email){
    window.location.href="exportarColaboradores.php?email="+encodeURIComponent(email);
}

function exportarDadosTodos(){
    window.location.href="exportarColaboradores.php";
}
window.definirPapel = definirPapel;
window.definirNivel = definirNivel;
window.exportarDados = exportarDados;
