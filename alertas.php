<?php
// alertas.php

require_once 'BLL/Alertas_BLL.php';
require_once 'BLL/Logger_BLL.php';
require_once __DIR__ . "/verificar_acesso.php";
verificarAcesso([4]);

$mensagemErro = '';

$bll = new Alertas_BLL();
$loggerBLL = new LoggerBLL();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tipo'])) {
    if ($_POST['periodicidade'] == 0) {
        $resultado = $bll->enviarAlerta(
            $_POST['tipo'] ?? 'Documentação',
            $_POST['descricao'],
            $_POST['email']
        );
        if (!$resultado) {
            $mensagemErro = 'Erro ao enviar alerta único.';
        } else {
            $loggerBLL->registarLog($_SESSION['email'], "Enviou um alerta único do tipo: " . $_POST['tipo'], "Destinatário: " . $_POST["email"] ."\nDescrição: ". $_POST['descricao']);
            header('Location: alertas.php?sucesso=1');
            exit();
        }
    } else {
        $idAlerta = $_POST['idAlerta'] ?? null;
        if ($idAlerta)
        {
            header('Content-Type: application/json');
            $resultado = $bll->atualizarAlerta(
                (int)$idAlerta,
                $_POST['tipo'],
                $_POST['descricao'],
                (int)$_POST['periodicidade'],
                $_POST['email']
            );
            $loggerBLL->registarLog($_SESSION['email'], "Atualizou o alerta de ID: $idAlerta", "Tipo: " . $_POST['tipo'] . "\nDescrição: " . $_POST['descricao'] . "\nPeriodicidade: " . $_POST['periodicidade'] . " dias\nEmail: " . $_POST['email']);
            echo json_encode(['success' => $resultado]);
            exit();
        } else {
            $resultado = $bll->cadastrarAlerta(
                $_POST['tipo'],
                $_POST['descricao'],
                (int)$_POST['periodicidade'],
                $_POST['email'],
                date('Y-m-d')
            );
            if (!$resultado) {
                $mensagemErro = 'Erro ao cadastrar alerta: ' . $resultado;
            } else {
                $loggerBLL->registarLog($_SESSION['email'], "Cadastrou um alerta períodico do tipo: " . $_POST['tipo'], "Destinatário: " . $_POST["email"] . "\nPeríodicidade: " . $_POST["periodicidade"] . " dias\nDescrição: ". $_POST['descricao']);
                header('Location: alertas.php?sucesso=1');
                exit();
            }
        }
    }


    if (!$resultado) {
        $mensagemErro = $resultado;
    }
}

?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Alertas - Portal do Colaborador</title>
    <link rel="stylesheet" href="CSS/alertas.css">
</head>
<body>
    <?php include 'cabecalho.php'; ?>

    <div class="section-title">Alertas | Criar Alertas</div>

    <br/>

    <?php if (!empty($mensagemErro)): ?>
        <div class="erro"><?= htmlspecialchars($mensagemErro) ?></div>
    <?php endif; ?>

    <div class="containers-row">
        <div class="container">
            <h1>Alertas</h1>

            <?php if (isset($_GET['sucesso'])): ?>
                <div class="alerta-card" style="background:#d4edda;color:#155724;">Alerta cadastrado com sucesso!</div>
            <?php endif; ?>

            <div class="novo-alerta">
                <h2>Novo Alerta</h2>
                <form method="post">
                    <label>Tipo:</label><br/>
                    <select name="tipo" required style="width:100%;">
                        <option value="" selected disabled>Tipo de Alerta</option>
                        <option value="documentacao">Documentação</option>
                    </select>
                    <br/><br/>
                    <label>Corpo do email:</label><br/>
                        <textarea name="descricao" required style="width:100%;"></textarea>
                    <br/><br/>
                    <label>Periodicidade (dias):</label><br/>
                        <input type="number" name="periodicidade" min="0" placeholder="Definir como 0 para alerta único!" required style="width:100%;">
                    <br/><br/>
                    <label>Email para envio:</label><br/>
                        <input type="email" name="email" required style="width:100%;">
                    <br/><br/>
                    <button class="btn" type="submit">Cadastrar Alerta</button>
                </form>
            </div>
        </div>

        <div class="container">
            <h2>Alertas Existentes</h2>
            <?php
                foreach ($bll->listarAlertas() as $alerta) {
                    echo '<div class="alerta-card" data-id="' . htmlspecialchars($alerta['idAlerta']) . '">';
                    echo '<p class="tipo"><strong>Tipo: </strong>' . htmlspecialchars($alerta['tipo']) . '</p>';
                    echo '<p class="descricao"><strong>Descrição: </strong>' . htmlspecialchars($alerta['descricao']) . '</p>';
                    echo '<p class="periodicidade"><strong>Periodicidade:</strong> ' . htmlspecialchars($alerta['periodicidade']) . ' dias</p>';
                    echo '<p class="email"><strong>Email:</strong> ' . htmlspecialchars($alerta['email']) . '</p>';
                    echo '<p class="dataEmissao"><strong>Data de Criação:</strong> ' . htmlspecialchars($alerta['dataEmissao']) . '</p>';
                    echo '<button class="btn editar-btn">Editar</button>';
                    echo '<button class="btn eliminar-btn">Eliminar</button>';
                    echo '</div>';
                }
            ?>
            
        </div>
    </div>
    <script src="JS/alertas.js"></script>
</body>
</html>