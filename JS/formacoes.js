function abrirModal(titulo, descricao) {
  document.getElementById('modalTitulo').innerText = titulo;
  document.getElementById('modalDescricaoTexto').innerHTML = descricao;
  document.getElementById('modalDescricao').style.display = 'flex';
}

function abrirModalInscricoes(idFormacao) {
  fetch('API/obter_inscritos.php?id=' + idFormacao)
    .then(res => res.json())
    .then(data => {
      const lista = document.getElementById('lista-inscricoes');
      lista.innerHTML = '';

      if (data.length === 0) {
        lista.innerHTML = '<p>Nenhum colaborador inscrito.</p>';
        return;
      }
    
      data.forEach(inscrito => {
        const div = document.createElement('div');
        div.className = 'linha-inscricao';
        div.innerHTML = `
            <br/>
            <strong>${inscrito.nome} (${inscrito.email})</strong><br>
            <select data-email="${inscrito.email}" data-id="${inscrito.idFormacao}">
                <option value="0" ${inscrito.estado == 0 ? 'selected' : ''}>Não iniciado</option>
                <option value="1" ${inscrito.estado == 1 ? 'selected' : ''}>Em curso</option>
                <option value="2" ${inscrito.estado == 2 ? 'selected' : ''}>Concluído</option>
            </select>
        `;
        lista.appendChild(div);
      });

      document.querySelectorAll('#lista-inscricoes select').forEach(select => {
        select.addEventListener('change', () => {
          const email = select.dataset.email;
          const idFormacao = select.dataset.id;
          const estado = select.value;

          fetch('API/atualizar_estado_formacao.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `email=${encodeURIComponent(email)}&idFormacao=${idFormacao}&estado=${estado}`
          });
        });
      });

      document.getElementById('modalInscricoes').style.display = 'flex';
    });
}

// Configuração dos modais ao carregar a página
document.addEventListener('DOMContentLoaded', () => {
  const modalDescricao = document.getElementById('modalDescricao');
  const closeDescricao = document.querySelector('.close-modal');
  if (closeDescricao) {
    closeDescricao.onclick = () => modalDescricao.style.display = 'none';
  }

  const modalInscricoes = document.getElementById('modalInscricoes');
  const closeInscricoes = document.querySelector('.close-modal-inscricoes');
  if (closeInscricoes) {
    closeInscricoes.onclick = () => modalInscricoes.style.display = 'none';
  }

  window.onclick = e => {
    if (e.target === modalDescricao) modalDescricao.style.display = 'none';
    if (e.target === modalInscricoes) modalInscricoes.style.display = 'none';
  };
});
