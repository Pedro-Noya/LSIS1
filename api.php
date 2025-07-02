<?php
// api.php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Configuração da base de dados
$host = "localhost";
$dbname = "tlantic";     // ⚠️ Muda aqui
$user = "root";             // ⚠️ Muda aqui
$password = "";           // ⚠️ Muda aqui

// Conectar ao MySQL
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo json_encode(["success" => false, "error" => "Erro de ligação: " . $e->getMessage()]);
    exit;
}

// Receber o JSON
$json = file_get_contents("php://input");
$data = json_decode($json, true);

// Verificar se veio algo
if (!$data) {
    echo json_encode(["success" => false, "error" => "Nenhum dado recebido"]);
    exit;
}

// Validar campos essenciais
if (empty($data["utilizador"]["email"]) || empty($data["utilizador"]["nome"])) {
    echo json_encode(["success" => false, "error" => "O email e nome são obrigatórios"]);
    exit;
}

$email = $data["utilizador"]["email"];
$nomeCompleto = $data["utilizador"]["nome"];

// 1️⃣ Upsert na tabela utilizador
$stmt = $pdo->prepare("SELECT email FROM Utilizador WHERE email = ?");
$stmt->execute([$email]);

if ($stmt->rowCount()) {
    $update = $pdo->prepare("UPDATE Utilizador SET nome = ? WHERE email = ?");
    $update->execute([$nomeCompleto, $email]);
    $acao = "updated";
} else {
    $insert = $pdo->prepare("INSERT INTO Utilizador (email, nome) VALUES (?, ?)");
    $insert->execute([$email, $nomeCompleto]);
    $acao = "inserted";
}

// 2️⃣ Upsert nas outras tabelas

function upsert($pdo, $tabela, $campos, $email) {
    $stmt = $pdo->prepare("SELECT email FROM $tabela WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->rowCount()) {
        // Atualizar
        $set = [];
        $values = [];
        foreach ($campos as $k => $v) {
            $set[] = "$k = ?";
            $values[] = $v;
        }
        $values[] = $email;
        $sql = "UPDATE $tabela SET " . implode(", ", $set) . " WHERE email = ?";
        $up = $pdo->prepare($sql);
        $up->execute($values);
    } else {
        // Inserir
        $columns = implode(",", array_merge(["email"], array_keys($campos)));
        $placeholders = implode(",", array_fill(0, count($campos) + 1, "?"));
        $values = array_merge([$email], array_values($campos));
        $sql = "INSERT INTO $tabela ($columns) VALUES ($placeholders)";
        $in = $pdo->prepare($sql);
        $in->execute($values);
    }
}

// 2a - dadospessoaiscolaborador
upsert($pdo, "dadospessoaiscolaborador", $data["dadosPessoais"], $email);

// 2b - dadosfinanceiroscolaborador
upsert($pdo, "dadosfinanceiroscolaborador", $data["dadosFinanceiros"], $email);

// 2c - dadoscontratocolaborador
upsert($pdo, "dadoscontratocolaborador", $data["dadosContrato"], $email);

// 2d - dadosextrascolaborador
upsert($pdo, "dadosextrascolaborador", $data["dadosExtras"], $email);

// 2e - dadoshabilitacoescolaborador
upsert($pdo, "dadoshabilitacoescolaborador", $data["dadosHabilitacoes"], $email);

echo json_encode([
    "success" => true,
    "action" => $acao
]);
?>