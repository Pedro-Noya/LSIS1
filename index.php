<?php
session_start();

$papel = null;
if (isset($_SESSION["email"])) {
    $funcao = $_SESSION["email"];
    $papel = $_SESSION["papel"];
}

?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Início - Portal do Colaborador</title>
    <link rel="stylesheet" href="CSS/inicial.css">
</head>
<body>
    <?php include "cabecalho.php"; ?>

    <div class="titulo-pagina">
        <h1>Navegar</h1>
    </div>

    <br/>
    <div class="container">
        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>

            <div class="botoes">
                <?php if ($papel === 1): ?>
                    <button onclick="location.href='pedidos.php'">Pedidos</button>
                    <button onclick="location.href='Equipas/equipasInfo.php'">Equipas</button>

                <?php elseif ($papel === 2): ?>
                    <button onclick="location.href='pedidos.php'">Pedidos</button>
                    <button onclick="location.href='dashboard.php'">Dashboard</button>
                    <button onclick="location.href='Equipas/equipasInfo.php'">Equipas</button>

                <?php elseif ($papel === 3): ?>
                    <button onclick="location.href='registar.php'">Registar Utilizador</button>
                    <button onclick="location.href='Equipas/equipas.php'">Criar Equipa</button>
                    <button onclick="location.href='Equipas/equipaselementos.php'">Gerir Equipas</button>
                    <button onclick="location.href='Equipas/equipasinfo.php'">Ver Equipas</button>
                    <button onclick="location.href='emitir_alertas.php'">Emitir Alertas</button>
                    <button onclick="location.href='dashboard.php'">Dashboard</button>
                    <button onclick="location.href='listar_trabalhadores.php'">Trabalhadores</button>
                    <button onclick="location.href='voucher.php'">Vouchers</button>
                    <button onclick="location.href='listar_pedidos.php'">Pedidos</button>

                <?php elseif ($papel === 4): ?>
                    <button onclick="location.href='listar_logs.php'">Logs</button>
                    <button onclick="location.href='alertas.php'">Alertas</button>
                    <button onclick="location.href='Equipas/equipasInfo.php'">Equipas</button>

                <?php endif; ?>

                <button onclick="location.href='formacoes.php'">Formações</button>
                <button onclick="location.href='perfil.php'">Perfil</button>
                <button onclick="location.href='logout.php'" class="vermelho">Logout</button>
            </div>
        <?php else: ?>
            <p class="texto">Bem-vindo ao Portal do Colaborador</p>
            <div class="botoes">
                <button onclick="location.href='login.php'">Login</button>
                <button onclick="location.href='registar.php'">Registar</button>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
