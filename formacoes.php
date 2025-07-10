<?php
require_once __DIR__ . "/verificar_acesso.php";
verificarAcesso([1,2,3,4]);
require_once "BLL/Formacoes_BLL.php";
$formacoesBLL = new Formacoes_BLL();
$formacoes = $formacoesBLL->obterFormacoes();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Portal do Colaborador - Formações</title>
  <link rel="stylesheet" href="CSS/formacoes.css">
</head>
<body>
  
  <?php include "cabecalho.php"; ?>

  <div class="formacoes-header">
    <h1>Formações Disponíveis</h1>
  </div>
  <div class="formacoes-wrapper">
    <?php if ($_SESSION['papel'] == 3): ?>
      <div class="criar-formacao-box">
        <button class="btn-criar-formacao" onclick="window.location.href='criar_formacao.php'">➕ Criar nova formação</button>
      </div>
    <?php endif; ?>

    <div class="formacoes-container">
      <?php if (empty($formacoes)): ?>
        <p>Nenhuma formação disponível no momento.</p>
      <?php else: ?>
        <?php foreach ($formacoes as $f): ?>
          <div class="formacao-box">
            <h3><?= htmlspecialchars($f['titulo']) ?></h3>
            <img src="<?= htmlspecialchars($f['imagem']) ?>" alt="<?= htmlspecialchars($f['titulo']) ?>">
            <p>
              <strong>Nível:</strong> <?= $f['nivelEnsino'] ?><br>
              <strong>Duração:</strong> <?= $f['duracao'] ?> horas<br>
              <strong>Localização:</strong> <?= $f['localizacao'] ?><br>
              <strong>Horário:</strong> <?= $f['horario'] ?>
            </p>
            <button class="btn-vermais"
              onclick="abrirModal('<?= htmlspecialchars($f['titulo']) ?>', `<?= nl2br(htmlspecialchars($f['descricao'])) ?>`)">
              Ver Mais
            </button>

            <?php if ($_SESSION['papel'] == 3): ?>
              <button class="btn-gerir-inscricoes" onclick="abrirModalInscricoes(<?= $f['idFormacao'] ?>)">👥 Gerir Inscrições</button>
            <?php endif; ?>
            <?php if ($_SESSION['papel'] == 1 || $_SESSION['papel'] == 2): ?>
              <?php
                $inscrito = $formacoesBLL->verificarInscricao($_SESSION['email'], $f['idFormacao']);
              ?>
              <?php if ($inscrito): ?>
                <?php $estado = $formacoesBLL->obterEstadoInscricao($_SESSION['email'], $f['idFormacao']); ?>
                <?php if ($estado == 1): ?>
                  <button class="btn-inscrito" disabled>Inscrito</button>
                <?php elseif ($estado == 2): ?>
                  <button class="btn-inscrito" disabled>Completo</button>
                <?php else: ?>
                  <button class="btn-inscrito" disabled>Pedido enviado</button>
                <?php endif; ?>
              <?php else: ?>
                <form method="POST" action="API/inscrever_formacao.php">
                  <input type="hidden" name="idFormacao" value="<?= $f['idFormacao'] ?>">
                  <button type="submit" class="btn-inscrever">Inscrever-se</button>
                </form>
              <?php endif; ?>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>

      <div id="modalDescricao" class="modal">
        <div class="modal-content">
          <span class="close-modal">&times;</span>
          <h3 id="modalTitulo"></h3>
          <p id="modalDescricaoTexto"></p>
        </div>
      </div>
      <div id="modalInscricoes" class="modal">
        <div class="modal-content">
          <span class="close-modal-inscricoes">&times;</span>
          <h3>Inscrições nesta Formação</h3>
          <div id="lista-inscricoes"></div>
        </div>
      </div>
    </div>
  </div>
  <script src="JS/formacoes.js"></script>
</body>
</html>
