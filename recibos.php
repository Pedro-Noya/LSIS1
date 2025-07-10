<?php
session_start();
include "BLL/recibos_bll.php";

$email = $_SESSION['email'];
$papel = obterFuncaoRecibos()['papel'];
$recibos = getRecibosFiltrados();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Recibos de Vencimento</title>
    <link href="CSS/recibos.css" rel="stylesheet">
</head>
<body>
    <?php include "cabecalho.php"; ?>

    <h1>Recibos de Vencimento</h1>

    <?php if ($papel == 3): ?>
        <!-- Filtro -->
        <form method="GET">
            <label for="filtroEmail">Filtrar por Colaborador:</label>
            <select name="filtroEmail" onchange="this.form.submit()">
                <option value="">Todos</option>
                <?php foreach (getTodosEmailsParaFiltro() as $user): ?>
                    <option value="<?= $user['email'] ?>" <?= (isset($_GET['filtroEmail']) && $_GET['filtroEmail'] == $user['email']) ? 'selected' : '' ?>>
                        <?= $user['email'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>

        <!-- Formulário de criação -->
        <h2>Adicionar Novo Recibo</h2>
        <form method="POST" action="recibos.php">
            <input type="text" name="nomeRecibo" placeholder="Nome do Recibo" required>
            <input type="text" name="vencimento" placeholder="Valor de Vencimento" required>
            <select name="email" required>
                <option value="">Selecionar Colaborador</option>
                <?php foreach (getTodosEmailsParaFiltro() as $user): ?>
                    <option value="<?= $user['email'] ?>"><?= $user['email'] ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" name="criar">Adicionar</button>
        </form>

        <?php if (isset($_POST['criar'])): ?>
            <?php 
                criarNovoRecibo($_POST['nomeRecibo'], $_POST['vencimento'], $_POST['email']); 
                echo "<p>✅ Recibo adicionado com sucesso!</p>";
                header( "Refresh:3; url=index.php");
            ?>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Lista de recibos -->
    <?php if (empty($recibos)): ?>
        <p style="margin: 20px; font-weight: bold;">Não existem recibos disponíveis para mostrar.</p>
    <?php else: ?>
        <h2>Lista de Recibos</h2>
        <table>
            <thead>
                <tr>
                    <th>Nome do Recibo</th>
                    <th>Vencimento</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recibos as $recibo): ?>
                    <tr>
                        <td><?= $recibo['nomeRecibo'] ?></td>
                        <td><?= $recibo['vencimento'] . "€" ?></td>
                        <td><?= $recibo['email'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
