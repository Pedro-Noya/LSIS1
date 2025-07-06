<?php
require_once __DIR__ . '/../BLL/Equipas_BLL.php';

$bll = new Equipa_BLL();

$equipas = $bll->obterEquipas();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipas</title>
    <link rel="stylesheet" href="../CSS/equipas.css">
</head>
<body>
    <?php include __DIR__ . '/../cabecalho.php'; ?>

    <div class="container">
        <h1>Selecione a Equipa</h1>
        <div class="equipas-lista">
            <?php if (empty($equipas)): ?>
                <p>Nenhuma equipa encontrada.</p>
            <?php else: ?>
                <?php foreach ($equipas as $equipa): ?>
                    <div class="equipa-card">
                        <div class="nome-equipa">
                            <h2><?= htmlspecialchars($equipa['nomeEquipa']) ?></h2>
                        </div>
                        <p><strong>Localização:</strong> <?= htmlspecialchars($equipa['localizacao']) ?></p>
                        <p><strong>Data de Criação:</strong> <?= htmlspecialchars($equipa['dataCriacao']) ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <script src="../JS/equipas_info.js"></script>
</body>
</html>