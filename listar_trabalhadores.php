<?php
require_once 'BLL/Listar_Trabalhadores_BLL.php';
require_once __DIR__ . "/verificar_acesso.php";
verificarAcesso([3]);

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
  <title>Portal do Colaborador - Listar Trabalhadores</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="CSS/listar_trabalhadores.css">
</head>
<body>

    <?php include "cabecalho.php"; ?>

    <div class="titulo-pagina">
        <h1>Listar Trabalhadores</h1>
    </div>

    <br/>

    <div class="container">
        <form action="importar_colaboradores.php" method="GET" style="margin-bottom: 10px;">
            <button class="btn-importar" type="submit">Importar Colaboradores via CSV</button>
        </form>
        <button class="btn-exportar" onclick="exportarDadosTodos()">Exportar informação para Excel</button>

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

        <!-- Colaboradores -->
        <div id="colaboradores" class="categoria" style="display:none">
        <h3>Colaboradores</h3>
        <?php foreach ($trabalhadores['colaboradores'] as $colaborador): ?>
            <div>
                <?= htmlspecialchars($colaborador['nome']) ?> (<?= htmlspecialchars($colaborador['email']) ?>)
                <br/>
                <button class="btn-atualizar" onclick="atualizarPerfil('<?= htmlspecialchars($colaborador['email']) ?>')">Atualizar Perfil</button>
                <button class="btn-exportar" onclick="exportarDados('<?= htmlspecialchars($colaborador['email']) ?>')">Exportar Dados</button>
                <h3>Cargo</h3>
                <select id="papel-<?= htmlspecialchars($colaborador['email']) ?>">
                    <?php foreach ($converterPapel as $valor => $nome): ?>
                        <option value="<?= $valor ?>" <?= ($colaborador['papel'] == $valor) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($nome) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button class="btn-definir" onclick="definirPapel('<?= htmlspecialchars($colaborador['email']) ?>')">Definir</button>
            </div>
        <?php endforeach; ?>
        </div>

        <!-- Coordenadores -->
        <div id="coordenadores" class="categoria" style="display:none">
        <h3>Coordenadores</h3>
        <?php foreach ($trabalhadores['coordenadores'] as $coordenador): ?>
            <div>
                <?= htmlspecialchars($coordenador['nome']) ?> (<?= htmlspecialchars($coordenador['email']) ?>)
                <br/>
                <label for="nivel-<?= htmlspecialchars($coordenador['email']) ?>">Nível:</label>
                <input 
                    type="number" 
                    id="nivel-<?= htmlspecialchars($coordenador['email']) ?>" 
                    min="1"
                    placeholder="Novo nível"
                    value="<?= htmlspecialchars($bll->getNivel($coordenador['email'])) ?>"
                >
                <button class="btn-definir" onclick="definirNivel('<?= htmlspecialchars($coordenador['email']) ?>')">Definir</button>

                <h3>Cargo</h3>
                <select id="papel-<?= htmlspecialchars($coordenador['email']) ?>">
                    <?php foreach ($converterPapel as $valor => $nome): ?>
                        <option value="<?= $valor ?>" <?= ($coordenador['papel'] == $valor) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($nome) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button class="btn-definir" onclick="definirPapel('<?= htmlspecialchars($coordenador['email']) ?>')">Definir</button>
            </div>
        <?php endforeach; ?>
        </div>

        <!-- Recursos Humanos -->
        <div id="recursosHumanos" class="categoria" style="display:none">
        <h3>Recursos Humanos</h3>
        <?php foreach ($trabalhadores['recursosHumanos'] as $rh): ?>
            <div>
                <?= htmlspecialchars($rh['nome']) ?> (<?= htmlspecialchars($rh['email']) ?>)
                <h3>Cargo</h3>
                <select id="papel-<?= htmlspecialchars($rh['email']) ?>">
                    <?php foreach ($converterPapel as $valor => $nome): ?>
                        <option value="<?= $valor ?>" <?= ($rh['papel'] == $valor) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($nome) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button class="btn-definir" onclick="definirPapel('<?= htmlspecialchars($rh['email']) ?>')">Definir</button>
            </div>
        <?php endforeach; ?>
        </div>

        <!-- Administradores -->
        <div id="administradores" class="categoria" style="display:none">
        <h3>Administradores</h3>
        <?php foreach ($trabalhadores['administradores'] as $admin): ?>
            <div>
                <?= htmlspecialchars($admin['nome']) ?> (<?= htmlspecialchars($admin['email']) ?>)
                <h3>Cargo</h3>
                <select id="papel-<?= htmlspecialchars($admin['email']) ?>">
                    <?php foreach ($converterPapel as $valor => $nome): ?>
                        <option value="<?= $valor ?>" <?= ($admin['papel'] == $valor) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($nome) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button class="btn-definir" onclick="definirPapel('<?= htmlspecialchars($admin['email']) ?>')">Definir</button>
            </div>
        <?php endforeach; ?>
        </div>

        <!-- Equipas -->
        <div id="equipas" class="categoria" style="display:none">
        <h3>Equipas</h3>
        <?php if (!empty($trabalhadores['equipasArray']) && is_array($trabalhadores['equipasArray'])): ?>
            <?php foreach ($trabalhadores['equipasArray'] as $nomeEquipa => $elementos): ?>
                <div class="equipa-card">
                    <strong><?= htmlspecialchars($nomeEquipa) ?></strong>
                    <button class="btn-ver-equipa" onclick="window.location.href='/PortalColaborador/Equipas/equipasInfo.php?nome=<?= urlencode($nomeEquipa) ?>'">
                        Ver detalhes
                    </button>
                    <ul>
                        <?php if ($elementos): ?>
                            <?php foreach ($elementos as $elemento): ?>
                                <li><?= htmlspecialchars($elemento['nome']) ?> (<?= htmlspecialchars($elemento['email']) ?>) - <?= htmlspecialchars($converterPapel[$elemento['papel']] ?? 'Desconhecido') ?></li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li>Nenhum elemento na equipa</li>
                        <?php endif; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Nenhuma equipa registada.</p>
        <?php endif; ?>
        </div>
    </div>

    <script src="js/listar_trabalhadores.js"></script>
</body>
</html>
