<meta charset="UTF-8">
<?php
$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['ficheiro']) && $_FILES['ficheiro']['error'] === UPLOAD_ERR_OK) {
        $ficheiroTmp = $_FILES['ficheiro']['tmp_name'];

        $conteudo = file_get_contents($ficheiroTmp);

        // Tenta converter para UTF-8, assumindo que o CSV possa estar em ISO-8859-1 ou Windows-1252
        $conteudo = mb_convert_encoding($conteudo, 'UTF-8', 'ISO-8859-1, Windows-1252, UTF-8');

        // Grava conteúdo temporariamente num ficheiro convertido
        $tmpUtf8 = tmpfile();
        fwrite($tmpUtf8, $conteudo);
        rewind($tmpUtf8);

        // Agora sim, usa fgetcsv() com segurança
        if (($handle = $tmpUtf8) !== false) {
            $conn = new mysqli('localhost', 'root', '', 'tlantic');
            $conn->set_charset("utf8mb4");
            if ($conn->connect_error) {
                die("Erro na ligação à base de dados: " . $conn->connect_error);
            }

            $primeiraLinha = true;
            while (($linha = fgetcsv($handle, 1000, ",")) !== false) {
                if ($primeiraLinha) {
                    $primeiraLinha = false; // ignora cabeçalhos
                    continue;
                }

                // Exemplo com campos base. Ajusta conforme a tua estrutura:
                list($email, $nome, $password_hash, $dataCriacao, $numMec, $nomeAbreviado, $dataNascimento, $designacaoDdiTelemovel, $telemovel,
                     $sexo, $numPorta, $rua, $codPost, $localidade, $nacionalidade, $ddiContacto, $contacto,
                     $contactoEmergencia, $grauRelacionamento, $matricula, $habLiterarias, $curso, $frequencia,
                     $cc, $nif, $niss, $situacaoIrs, $numDependentes, $iban, $remuneracao, $cartaoContinente,
                     $voucherNos, $tipoContrato, $regimeHorarioTrabalho, $dataInicio, $dataFim) = $linha;

                //Encriptar a password
                $password_hash=password_hash($password_hash, PASSWORD_DEFAULT);

                // Inserir ou atualizar Utilizador
                $stmt = $conn->prepare("INSERT INTO Utilizador (email, nome, password_hash, dataCriacao, papel, estado) VALUES (?, ?, ?, ?, 1, 1)
                                        ON DUPLICATE KEY UPDATE email=VALUES(email),
                                        nome = VALUES(nome),
                                        password_hash = VALUES(password_hash),
                                        dataCriacao = VALUES(dataCriacao),
                                        papel = VALUES(papel),
                                        estado = VALUES(estado)");
                $stmt->bind_param("ssss", $email, $nome, $password_hash, $dataCriacao);
                $stmt->execute();

                // Inserir Dados Pessoais
                $stmt = $conn->prepare("INSERT INTO DadosPessoaisColaborador 
                    (email, numMec, nomeAbreviado, dataNascimento, designacaoDdiTelemovel, telemovel, sexo, 
                     numPorta, rua, codPost, localidade, nacionalidade, designacaoDdiContacto, contacto, 
                     contactoEmergencia, grauRelacionamento, matricula)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                    ON DUPLICATE KEY UPDATE email = VALUES(email),
                    numMec = VALUES(numMec),
                    nomeAbreviado = VALUES(nomeAbreviado),
                    dataNascimento = VALUES(dataNascimento),
                    designacaoDdiTelemovel = VALUES(designacaoDdiTelemovel),
                    telemovel = VALUES(telemovel),
                    sexo = VALUES(sexo),
                    numPorta = VALUES(numPorta),
                    rua = VALUES(rua),
                    codPost = VALUES(codPost),
                    localidade = VALUES(localidade),
                    nacionalidade = VALUES(nacionalidade),
                    designacaoDdiContacto = VALUES(designacaoDdiContacto),
                    contacto = VALUES(contacto),
                    contactoEmergencia = VALUES(contactoEmergencia),
                    grauRelacionamento = VALUES(grauRelacionamento),
                    matricula = VALUES(matricula)");
                    

                $stmt->bind_param("sssssssssssssssss", $email, $numMec, $nomeAbreviado, $dataNascimento,
                    $designacaoDdiTelemovel, $telemovel, $sexo, $numPorta, $rua, $codPost, $localidade,
                    $nacionalidade, $ddiContacto, $contacto, $contactoEmergencia, $grauRelacionamento, $matricula);
                $stmt->execute();

                // Dados Habilitações
                $stmt = $conn->prepare("INSERT INTO DadosHabilitacoesColaborador (email, habLiterarias, curso, frequencia)
                                        VALUES (?, ?, ?, ?)
                                        ON DUPLICATE KEY UPDATE email=VALUES(email),
                                        habLiterarias = VALUES(habLiterarias),
                                        curso = VALUES(curso),
                                        frequencia = VALUES(frequencia)");
                $stmt->bind_param("ssss", $email, $habLiterarias, $curso, $frequencia);
                $stmt->execute();

                // Dados Financeiros
                $stmt = $conn->prepare("INSERT INTO DadosFinanceirosColaborador (email, cc, nif, niss, situacaoIrs, numDependentes, iban, remuneracao)
                                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                                        ON DUPLICATE KEY UPDATE email = VALUES(email),
                                        cc = VALUES(cc),
                                        nif = VALUES(nif),
                                        niss = VALUES(niss),
                                        situacaoIrs = VALUES(situacaoIrs),
                                        numDependentes = VALUES(numDependentes),
                                        iban = VALUES(iban),
                                        remuneracao = VALUES(remuneracao)");
                $stmt->bind_param("ssssssss", $email, $cc, $nif, $niss, $situacaoIrs, $numDependentes, $iban, $remuneracao);
                $stmt->execute();

                // Voucher NOS (supondo que queres usar data como string simples por agora)
                if (isset($voucherNos) && !empty($voucherNos) && strtolower($voucherNos) !== "null") {
                    // Inserir ou buscar ID
                    $stmt = $conn->prepare("INSERT INTO VoucherNos (voucherNos, estado) VALUES (?, 1)
                                            ON DUPLICATE KEY UPDATE voucherNos = VALUES(voucherNos)");
                    $stmt->bind_param("s", $voucherNos);
                    $stmt->execute();

                    $idVoucher = $conn->insert_id ?: $conn->query("SELECT idVoucherNos FROM VoucherNos WHERE voucherNos = '$voucherNos'")->fetch_assoc()['idVoucherNos'];

                    $stmt = $conn->prepare("INSERT INTO DadosExtrasColaborador (email, cartaoContinente, idVoucherNos)
                                            VALUES (?, ?, ?)
                                            ON DUPLICATE KEY UPDATE cartaoContinente = VALUES(cartaoContinente)");
                    $stmt->bind_param("ssi", $email, $cartaoContinente, $idVoucher);
                    $stmt->execute();
                } else{
                    $stmt = $conn->prepare("INSERT INTO DadosExtrasColaborador (email, cartaoContinente, idVoucherNos)
                                            VALUES (?, ?, null)
                                            ON DUPLICATE KEY UPDATE cartaoContinente = VALUES(cartaoContinente),
                                            idVoucherNos = VALUES(idVoucherNos)");
                    $stmt->bind_param("ss", $email, $cartaoContinente);
                    $stmt->execute();
                }



                // Dados Contratuais
                $stmt = $conn->prepare("INSERT INTO DadosContratoColaborador (email, tipoContrato, regimeHorarioTrabalho, dataInicio, dataFim)
                                        VALUES (?, ?, ?, ?, ?)
                                        ON DUPLICATE KEY UPDATE tipoContrato = VALUES(tipoContrato),
                                        regimeHorarioTrabalho = VALUES(regimeHorarioTrabalho),
                                        dataInicio = VALUES(dataInicio),
                                        dataFim = VALUES(dataFim)");
                $stmt->bind_param("sssss", $email, $tipoContrato, $regimeHorarioTrabalho, $dataInicio, $dataFim);
                $stmt->execute();
            }

            fclose($handle);
            $mensagem = "Importação concluída com sucesso!";
        } else {
            $mensagem = "Erro ao abrir o ficheiro.";
        }
    } else {
        $mensagem = "Erro no upload do ficheiro.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Importar Colaboradores</title>
</head>
<body>
    <h1>Importar Colaboradores via CSV</h1>

    <?php if ($mensagem): ?>
        <p><strong><?= htmlspecialchars($mensagem) ?></strong></p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <label for="ficheiro">Escolha o ficheiro CSV:</label>
        <input type="file" name="ficheiro" accept=".csv" required>
        <br><br>
        <button type="submit">Importar</button>
    </form>
</body>
</html>
