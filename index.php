<?php
    // index.php
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Buttons</title>
</head>
<body>
    <?php include "cabecalho.php"; ?>

    <?php
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
            echo '<h3>Bem-vindo, ' . htmlspecialchars($_SESSION['email']) . '!</h3>';
            echo '<h5>Papel: ' . htmlspecialchars($_SESSION['papel']) . '</h5><br/>';
            echo '<button onclick="location.href=\'logout.php\'">Logout</button>';
            if (isset($_SESSION['papel'])) {
                if ($_SESSION['papel'] >= 1) {
                    echo '<button onclick="location.href=\'dashboard.php\'">Dashboard</button>';
                }
                if ($_SESSION['papel'] === 2) {
                    echo '<button onclick="location.href=\'Equipas/equipas.php\'">Criar Equipa</button>';
                    echo '<button onclick="location.href=\'Equipas/equipasElementos.php\'">Gerir Equipas</button>';
                }
            }
        } else {
            echo '<button onclick="location.href=\'login.php\'">Login</button>';
        }
    ?>
    <button onclick="location.href='registar.php'">Registar</button>
    <button onclick="location.href='InformacoesColaborador.php'">Atualizar</button>

</body>
</html>
