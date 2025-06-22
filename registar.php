<?php
require_once 'BLL/Registo_Utilizador_BLL.php';

$mensagemErro = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $nome = $_POST['nome'] ?? '';
  $email = $_POST['email'] ?? '';
  $password = $_POST['password'] ?? '';
  $confirmPassword = $_POST['confirmPassword'] ?? '';
  $role = $_POST['role'] ?? '';
  $sexo = $_POST['sexo'] ?? '';
  $nacionalidade = $_POST['nacionalidade'] ?? '';
  $dataNascimento = $_POST['dataNascimento'] ?? '';
  $tipoContrato = $_POST['tipoContrato'] ?? '';
  $dataInicio = $_POST['dataInicio'] ?? '';
  $dataFim = $_POST['dataFim'] ?? '';
  $regimeHorarioTrabalho = $_POST['regimeHorarioTrabalho'] ?? '';

  $bll = new Registo_Utilizador_BLL();
  $resultado = $bll->registarUtilizador(
    $nome,
    $email,
    $password,
    $confirmPassword,
    $role,
    $sexo,
    $nacionalidade,
    $dataNascimento,
    $tipoContrato,
    $dataInicio,
    $dataFim,
    $regimeHorarioTrabalho
  );

  if ($resultado === true) {
    header("Location: login.php");
    exit();
  } else {
    $mensagemErro = $resultado;
  }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8" />
  <title>Portal do Colaborador - Registo</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="CSS/registar.css" />
</head>
<body>
  <div class="topbar">
    <div class="topnav">
      <div class="logo">tlantic</div>
      <nav>
        <a href="#">sobre nós</a>
        <a href="#">soluções</a>
        <a href="#">setores</a>
        <a href="#">recursos</a>
        <a href="#">Pesquisar 🔍</a>
        <div class="pedido-demo-box">
          <span>🔔</span>
          <span>Pedir uma demo</span>
        </div>
        <a href="#" class="btn-experiment">Experimente agora</a>
        <a href="#">PT ▾</a>
      </nav>
    </div>
    <h1>Portal do Colaborador</h1>
  </div>

  <div class="section-title">Registar Utilizador no Portal</div>

  <div class="container">
    <form method="POST" action="">
      <input type="text" name="nome" placeholder="Nome Completo" required /><br />
      <input type="email" name="email" placeholder="Email" required /><br />
      <input type="password" name="password" placeholder="Palavra-Passe" required /><br />
      <input type="password" name="confirmPassword" placeholder="Confirmar Palavra-Passe" required /><br />
      <div id="capsLockSpacing" style="height: 16px;"></div>
      <div id="capsLockWarning">
        Caps-Lock Ativo
      </div><br/>
      
      <label for="tipoContrato">Tipo de Contrato:</label>
      <select id="tipoContrato" name="tipoContrato" required>
        <option value="" selected disabled>Escolher contrato</option>
        <option value="Sem termo">Sem termo</option>
        <option value="Termo certo">Termo certo</option>
        <option value="Termo incerto">Termo incerto</option>
        <option value="Estágio">Estágio</option>
      </select><br />

      <div id="camposContratoExtras" style="display: none;">
        <label for="dataInicio">Data de Início:</label>
        <input type="date" name="dataInicio" id="dataInicio" /><br />
        <br />
        
        <label for="dataFim">Data de Fim:</label>
        <input type="date" name="dataFim" id="dataFim" /><br />
        <br />

        <label for="regimeHorarioTrabalho">Regime de Horário:</label>
        <select id="regimeHorarioTrabalho" name="regimeHorarioTrabalho">
          <option value="" selected disabled>Escolher regime</option>
          <option value="Full-time">Full-time</option>
          <option value="Part-time">Part-time</option>
          <option value="Flexível">Flexível</option>
        </select><br />
      </div>


      <label for="role">Papel:</label>
      <select id="role" name="role" required>
        <option value="" selected disabled>Papel</option>
        <option value="Colaborador">Colaborador</option>
        <option value="Coordinator">Coordenador</option>
        <option value="HR">Recursos Humanos</option>
        <option value="Admin">Administrador</option>
      </select><br/>

      <div class="colaboradorOptions">
        <label for="sexo">Sexo:</label>
        <select id="sexo" name="sexo">
          <option value="" selected disabled>Sexo</option>
          <option value="Masculino">Masculino</option>
          <option value="Feminino">Feminino</option>
        </select><br />

        <input type="text" name="nacionalidade" placeholder="Nacionalidade"/><br />
        <br />

        <label for="dataNascimento">Data de Nascimento:</label>
        <input type="date" id="dataNascimento" name="dataNascimento"/><br />
      </div>
      <br />
      <button type="submit">Registar</button>
    </form>

    <?php if (!empty($mensagemErro)): ?>
      <div class="erro"><?= htmlspecialchars($mensagemErro) ?></div>
    <?php endif; ?>
  </div>
  <script src="JS/capsLockWarning.js"></script>
  <script src="JS/Registo_Utilizador_Opcoes_Extra/Colaborador_Opcoes_Extra.js"></script>
  <script src="JS/Registo_Utilizador_Opcoes_Extra/registar.js"></script>
</body>
</html>
