

addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.enviar-btn').forEach(btn => {
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

        await fetch('API/enviar_alerta.php', {
        method: 'POST',
        headers: {'Content-type': 'application/x-www-form-urlencoded'},
        body: 'idAlerta=' + encodeURIComponent(idAlerta) + '&email=' + encodeURIComponent(email) + '&tipo=' + encodeURIComponent(tipo) + '&descricao=' + encodeURIComponent(descricao)
        })
        .then(async response => {
        const text = await response.text();

        try {
            const data = JSON.parse(text);

            if (data.success) {
            alert('Alerta enviado com sucesso!');
            card.remove();
            } else {
            alert('Erro ao enviar alerta: ' + JSON.stringify(data));
            }
        } catch (e) {
            console.error('Erro no JSON:', e);
            console.log('Resposta completa do servidor:', text);
            alert('Erro: Ver consola');
        }
        })
        .catch(error => {
        console.error('Erro:', error);
        alert('Erro ao enviar alerta.');
        });

    });
  });
  document.querySelectorAll('.descartar-btn').forEach(btn => {
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

      if (confirm('Tem certeza que deseja descartar este alerta?')) {
        fetch('API/descartar_alerta.php', {
          method: 'POST',
          headers: {'Content-type': 'application/x-www-form-urlencoded'},
          body: 'idAlerta=' + encodeURIComponent(idAlerta)
        }).then(response => response.json())
          .then(data => {
            if (data.success) {
              card.remove();
            } else {
              alert('Erro ao descartar alerta: ' + JSON.stringify(data));
            }
          })
          .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao descartar alerta.');
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