<?php
require_once 'BLL/Listar_Trabalhadores_BLL.php';

session_start();

$converterPapel = [
    1 => 'Colaborador',
    2 => 'Coordenador',
    3 => 'Recursos Humanos',
    4 => 'Administrador'
];

$bll = new Listar_Trabalhadores_BLL();
$trabalhadores = $bll->listarTrabalhadores();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Portal do Colaborador - Login</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="CSS/global.css" />
  <link rel="stylesheet" href="CSS/login.css">
</head>
<body>

  <!-- Cabeçalho completo -->
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

  <!-- Subtítulo -->
  <div class="section-title">Listar Trabalhadores</div>

    <div class="container">
        <h2>Trabalhadores</h2>

        <label for="categoria">Selecionar categoria:</label>
        <select id="categoria" onchange="mostrarCategoria()">
            <option value="" selected disabled>Categoria</option>
            <option value="colaboradores">Colaboradores</option>
            <option value="coordenadores">Coordenadores</option>
            <option value="recursosHumanos">Recursos Humanos</option>
            <option value="administradores">Administradores</option>
            <option value="equipas">Equipas</option>
        </select>

        <div id="colaboradores" class="categoria" style="display:none">
        <h3>Colaboradores</h3>
        <?php foreach ($trabalhadores['colaboradores'] as $colaborador): ?>
            <div style="margin-bottom: 10px;">
            <?= htmlspecialchars($colaborador['nome']) ?> (<?= htmlspecialchars($colaborador['email']) ?>)
            
            <!-- Botão Atualizar Perfil -->
            <button onclick="atualizarPerfil('<?= htmlspecialchars($colaborador['email']) ?>')">Atualizar Perfil</button>
            
            <!-- Dropdown Papel -->
            <h3>Cargo</h3>
            <select id="papel-<?= htmlspecialchars($colaborador['email']) ?>">
                <?php foreach ($converterPapel as $valor => $nome): ?>
                <option value="<?= $valor ?>" <?= ($colaborador['papel'] == $valor) ? 'selected' : '' ?>>
                    <?= $nome ?>
                </option>
                <?php endforeach; ?>
            </select>
            <button onclick="definirPapel('<?= htmlspecialchars($colaborador['email']) ?>')">Definir</button>
            </div>
        <?php endforeach; ?>
        </div>

        <div id="coordenadores" class="categoria" style="display:none">
        <h3>Coordenadores</h3>
        <?php foreach ($trabalhadores['coordenadores'] as $coordenador): ?>
            <div style="margin-bottom: 10px;">
            <?= htmlspecialchars($coordenador['nome']) ?> (<?= htmlspecialchars($coordenador['email']) ?>)

            <label for="nivel-<?= htmlspecialchars($coordenador['email']) ?>">Nível:</label>
            <input 
                type="number" 
                id="nivel-<?= htmlspecialchars($coordenador['email']) ?>" 
                min="1"
                placeholder="Novo nível"
                value="<?= htmlspecialchars($bll->getNivel($coordenador['email'])) ?>"
            >
            <button onclick="definirNivel('<?= htmlspecialchars($coordenador['email']) ?>')">Definir</button>

            <h3>Cargo</h3>
            <select id="papel-<?= htmlspecialchars($coordenador['email']) ?>">
                <?php foreach ($converterPapel as $valor => $nome): ?>
                <option value="<?= $valor ?>" <?= ($coordenador['papel'] == $valor) ? 'selected' : '' ?>>
                    <?= $nome ?>
                </option>
                <?php endforeach; ?>
            </select>
            <button onclick="definirPapel('<?= htmlspecialchars($coordenador['email']) ?>')">Definir</button>
            </div>
        <?php endforeach; ?>
        </div>

        <div id="recursosHumanos" class="categoria" style="display:none">
        <h3>Recursos Humanos</h3>
        <?php foreach ($trabalhadores['recursosHumanos'] as $rh): ?>
            <div style="margin-bottom: 10px;">
            <?= htmlspecialchars($rh['nome']) ?> (<?= htmlspecialchars($rh['email']) ?>)
            <h3>Cargo</h3>
            <select id="papel-<?= htmlspecialchars($rh['email']) ?>">
                <?php foreach ($converterPapel as $valor => $nome): ?>
                <option value="<?= $valor ?>" <?= ($rh['papel'] == $valor) ? 'selected' : '' ?>>
                    <?= $nome ?>
                </option>
                <?php endforeach; ?>
            </select>
            <button onclick="definirPapel('<?= htmlspecialchars($rh['email']) ?>')">Definir</button>
            </div>
        <?php endforeach; ?>
        </div>

        <div id="administradores" class="categoria" style="display:none">
        <h3>Administradores</h3>
        <?php foreach ($trabalhadores['administradores'] as $admin): ?>
            <div style="margin-bottom: 10px;">
            <?= htmlspecialchars($admin['nome']) ?> (<?= htmlspecialchars($admin['email']) ?>)
            <h3>Cargo</h3>
            <select id="papel-<?= htmlspecialchars($admin['email']) ?>">
                <?php foreach ($converterPapel as $valor => $nome): ?>
                <option value="<?= $valor ?>" <?= ($admin['papel'] == $valor) ? 'selected' : '' ?>>
                    <?= $nome ?>
                </option>
                <?php endforeach; ?>
            </select>
            <button onclick="definirPapel('<?= htmlspecialchars($admin['email']) ?>')">Definir</button>
            </div>
        <?php endforeach; ?>
        </div>

        <div id="equipas" class="categoria" style="display:none">
        <h3>Equipas</h3>
        <?php foreach ($trabalhadores['equipasArray'] as $nomeEquipa => $elementos): ?>
            <strong><?= htmlspecialchars($nomeEquipa) ?></strong><br/>
            <?php foreach ($elementos as $elemento): ?>
            - <?= htmlspecialchars($elemento['nome']) ?> (<?= htmlspecialchars($elemento['email']) ?>) (<?= $converterPapel[$elemento['papel']] ?? 'Desconhecido' ?>)<br/>
            <?php endforeach; ?>
        <?php endforeach; ?>
        </div>

  </div>

<script src="js/listar_trabalhadores.js"></script>
</body>
</html>
