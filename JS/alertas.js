document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.editar-btn').forEach(btn => {
    btn.addEventListener('click', async () => {
      const card = btn.closest('.alerta-card');

      // Se já estiver em modo edição, não faz nada
      if (card.classList.contains('editando')) return;

      card.classList.add('editando');

      const tipo = card.querySelector('.tipo').textContent.trim().replace(/^Tipo:\s*/, '').toLowerCase();
      const descricao = card.querySelector('.descricao').textContent.trim().replace(/^Descrição:\s*/, '');
      const periodicidadeText = card.querySelector('.periodicidade').textContent.trim();
      const emailText = card.querySelector('.email').textContent.trim();
      const periodicidade = periodicidadeText.match(/(\d+)/)[0];
      const email = emailText.replace(/^Email:\s*/, '');

      const idAlerta = await obter_alerta(tipo, descricao, periodicidade, email);

      if (!idAlerta) {
        alert('Erro: alerta não encontrado.');
        return;
      }

      card.querySelector('.tipo').innerHTML = `
        <strong>Tipo:</strong><br/>
        <select name="tipo" style="width:100%">
          <option value="documentacao" ${tipo.toLowerCase() === 'documentação' ? 'selected' : ''}>Documentação</option>
        </select>
      `;

      card.querySelector('.descricao').innerHTML = `
        <strong>Descrição:</strong><br/>
        <textarea name="descricao" style="width:100%" rows="4">${descricao}</textarea>
      `;

      card.querySelector('.periodicidade').innerHTML = `
        <strong>Periodicidade:</strong><br/>
        <input type="number" name="periodicidade" min="0" value="${periodicidade}" style="width:100%">
      `;

      card.querySelector('.email').innerHTML = `
        <strong>Email:</strong><br/>
        <input type="email" name="email" value="${email}" style="width:100%">
      `;

      // Muda o botão editar para salvar
      btn.textContent = 'Salvar';

      btn.onclick = () => {

        const novoTipo = card.querySelector('select[name="tipo"]').value;
        const novaDescricao = card.querySelector('textarea[name="descricao"]').value;
        const novaPeriodicidade = card.querySelector('input[name="periodicidade"]').value;
        const novoEmail = card.querySelector('input[name="email"]').value;

        form = new FormData();
        form.append('tipo', novoTipo);
        form.append('descricao', novaDescricao);
        form.append('periodicidade', novaPeriodicidade);
        form.append('email', novoEmail);
        form.append('idAlerta', idAlerta);
        fetch('alertas.php', {
          method: 'POST',
          body: form
        }).then(response => response.json())
          .then(data => {
            if (data.success) {

              alert('Alerta atualizado com sucesso!');
            } else {
              console.log('Erro ao atualizar alerta: ' + JSON.stringify(data));
            }
          })
          .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao atualizar alerta.');
          });

        card.querySelector('.tipo').innerHTML = `<strong>Tipo: </strong>${novoTipo.charAt(0).toUpperCase() + novoTipo.slice(1)}`;
        card.querySelector('.descricao').innerHTML = `<strong>Descrição: </strong>${novaDescricao}`;
        card.querySelector('.periodicidade').innerHTML = `<strong>Periodicidade:</strong> ${novaPeriodicidade} dias`;
        card.querySelector('.email').innerHTML = `<strong>Email: </strong> ${novoEmail}`;


        btn.textContent = 'Editar';
        card.classList.remove('editando');

        btn.onclick = null;
      };
    });
  });

  document.querySelectorAll('.eliminar-btn').forEach(btn => {
    btn.addEventListener('click', async () => {
      const card = btn.closest('.alerta-card');

      const tipo = card.querySelector('.tipo').textContent.trim().replace(/^Tipo:\s*/, '').toLowerCase();
      const descricao = card.querySelector('.descricao').textContent.trim().replace(/^Descrição:\s*/, '');
      const periodicidadeText = card.querySelector('.periodicidade').textContent.trim();
      const emailText = card.querySelector('.email').textContent.trim();
      const periodicidade = periodicidadeText.match(/(\d+)/)[0];
      const email = emailText.replace(/^Email:\s*/, '');

      const idAlerta = await obter_alerta(tipo, descricao, periodicidade, email);

      if (!idAlerta) {
        alert('Erro: alerta não encontrado.');
        return;
      }

      if (confirm('Tem certeza que deseja eliminar este alerta?')) {
        fetch('API/eliminar_alerta.php', {
          method: 'POST',
          headers: {'Content-type': 'application/x-www-form-urlencoded'},
          body: 'idAlerta=' + encodeURIComponent(idAlerta)
        }).then(response => response.json())
          .then(data => {
            if (data.success) {
              alert('Alerta eliminado com sucesso!');
              card.remove();
            } else {
              alert('Erro ao eliminar alerta: ' + JSON.stringify(data));
            }
          })
          .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao eliminar alerta.');
          });
      }
    });
  });
});

async function obter_alerta(tipo, descricao, periodicidade, email) {
  try {
    const response = await fetch('API/obter_alerta.php', {
      method: 'POST',
      headers: {'Content-type': 'application/x-www-form-urlencoded'},
      body: `tipo=${encodeURIComponent(tipo)}&descricao=${encodeURIComponent(descricao)}&periodicidade=${encodeURIComponent(periodicidade)}&email=${encodeURIComponent(email)}`
    });

    const data = await response.json();

    if (data.success) {
      return data.idAlerta;
    } else {
      return null;
    }
  } catch (error) {
    console.error('Erro ao obter alerta:', error);
    return null;
  }
}

