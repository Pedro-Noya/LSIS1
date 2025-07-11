<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal do Colaborador</title>
    <link rel="stylesheet" href="/PortalColaborador/CSS/global.css">
    <link rel="stylesheet" href="/PortalColaborador/CSS/cabecalho.css">
</head>
<body>

    <?php include __DIR__ . "/BLL/cabecalho_bll.php"; ?>

    <div class="topbar">
        <div class="topnav">
            <a href="index.php" style="color: white; text-decoration: none;">
                <div class="logo">tlantic</div>
            </a>
            <nav>
                <?php mostrarItens(); ?>
            </nav>
        </div>
        <div class="titulo-top">
            <h1>Portal do Colaborador</h1>
        </div>
    </div>
    <script src="/PortalColaborador/JS/cabecalho.js"></script>
</body>
</html>
