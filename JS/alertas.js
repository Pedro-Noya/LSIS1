document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.editar-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const card = btn.closest('.alerta-card');

      // Se já estiver em modo edição, não faz nada
      if (card.classList.contains('editando')) return;

      card.classList.add('editando');

      const tipo = card.querySelector('.tipo').textContent.trim();
      const descricao = card.querySelector('.descricao').textContent.trim();
      const periodicidadeText = card.querySelector('.periodicidade').textContent.trim();
      const emailText = card.querySelector('.email').textContent.trim();
      const periodicidade = periodicidadeText.match(/(\d+)/)[0];
      const email = emailText.replace(/^Email:\s*/, '');

      card.querySelector('.tipo').innerHTML = `
        <select name="tipo" style="width:100%">
          <option value="documentacao" ${tipo.toLowerCase() === 'documentação' ? 'selected' : ''}>Documentação</option>
          <!-- Adicione mais opções se quiser -->
        </select>
      `;

      card.querySelector('.descricao').innerHTML = `
        <textarea name="descricao" style="width:100%" rows="4">${descricao}</textarea>
      `;

      card.querySelector('.periodicidade').innerHTML = `
        <label>Periodicidade (dias):</label><br/>
        <input type="number" name="periodicidade" min="0" value="${periodicidade}" style="width:100%">
      `;

      card.querySelector('.email').innerHTML = `
        <input type="email" name="email" value="${email}" style="width:100%">
      `;

      // Muda o botão editar para salvar
      btn.textContent = 'Salvar';

      btn.onclick = () => {

        const novoTipo = card.querySelector('select[name="tipo"]').value;
        const novaDescricao = card.querySelector('textarea[name="descricao"]').value;
        const novaPeriodicidade = card.querySelector('input[name="periodicidade"]').value;
        const novoEmail = card.querySelector('input[name="email"]').value;

        card.querySelector('.tipo').textContent = novoTipo.charAt(0).toUpperCase() + novoTipo.slice(1);
        card.querySelector('.descricao').textContent = novaDescricao;
        card.querySelector('.periodicidade').textContent = `Periodicidade: ${novaPeriodicidade} dias`;
        card.querySelector('.email').textContent = `Email: ${novoEmail}`;

        btn.textContent = 'Editar';
        card.classList.remove('editando');

        btn.onclick = null;
      };
    });
  });
});
