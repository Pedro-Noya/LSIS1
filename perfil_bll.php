<?php
require_once __DIR__ . "/verificar_acesso.php";
verificarAcesso([1,2,3,4]);
require_once 'perfil_dal.php';


function obterDadosPerfil(){
    $dal=new DAL_Atualizar();
    //$dados=$dal->obterDadosUtilizador($_SESSION["email"]);
    $result=$dal->obterEstadoPapel($_SESSION["email"]);
    if($result["papel"]==1){
        if($result["estado"]==1){
            $dados=$dal->obterDadosPerfil($_SESSION["email"]);
            if($_POST){
                //Separação da Morada em Rua e Nº da Porta
                list($rua, $numPorta)=explode(", ", $_POST["morada"]);

                $dal->atualizarColaborador($_POST["nome"], $_POST["email"], $_POST["password"]);

                if (isset($_FILES['documentoMorada']) && $_FILES['documentoMorada']['error'] === UPLOAD_ERR_OK) {
                    $tipoDocumento="Mod99";
                    $fileTmpPath = $_FILES['documentoMorada']['tmp_name'];
                    $fileData = file_get_contents($fileTmpPath);
                    $dal->guardarDocumento($tipoDocumento, $fileData, 0);
                }
                $dal->atualizarDadosPessoais($_POST["numMec"], $_POST["email"], $_POST["nomeAbreviado"], $_POST["dataNascimento"],
                $_POST["designacaoDdiTelemovel"], $_POST["telemovel"], $_POST["sexo"], $numPorta, $rua,
                $_POST["codPostal"], $_POST["localidade"], $_POST["nacionalidade"], $_POST["designacaoDdiContacto"],
                $_POST["contacto"], $_POST["contactoEmergencia"], $_POST["grauRelacionamento"], $_POST["matricula"]);

                $dal->atualizarDadosHabilitacoes($_POST["email"], $_POST["habLiterarias"], $_POST["curso"],
                $_POST["frequencia"]);

                $dal->atualizarDadosFinanceiros($_POST["email"], $_POST["cc"], $_POST["nif"], $_POST["niss"],
                $_POST["situacaoIrs"], $_POST["numDependentes"], $_POST["iban"], $_POST["remuneracao"]);

                if(!(is_null($dadosColaborador["idVoucherNos"])) || $dadosColaborador["idVoucherNos"]!=""){
                    $dal->removerVoucher($dadosColaborador["idVoucherNos"]);
                }
                if($_POST["voucherNos"]!=""){
                    $dal->adicionarVoucher($_POST["voucherNos"]);
                }

                $dal->atualizarDadosExtras($_POST["email"], $_POST["cartaoContinente"], $_POST["idVoucherNos"]);

                $dal->atualizarDadosContrato($_POST["email"], $_POST["tipoContrato"], $_POST["regimeHorarioTrabalho"],
                $_POST["dataInicio"], $_POST["dataFim"]);

                //$dal->atualizarPedidos($_POST["email"], $rua, $numPorta);

                header("Location: index.php");
            }
            $controlo="readonly";
            $disabled="disabled";
            showFormAtualizar($dados, $controlo, $disabled);
        }
        else{
            $dadosBase=$dal->obterDadosUtilizador($_SESSION["email"]);
            if($_POST){
                //Separação da Morada em Rua e Nº da Porta
                list($rua, $numPorta)=explode(", ", $_POST["morada"]);

                $dal->atualizarColaborador($_POST["nome"], $_POST["email"], $_POST["password"]);

                $dal->registarDadosPessoais($_POST["numMec"], $_POST["email"], $_POST["nomeAbreviado"], $_POST["dataNascimento"],
                $_POST["designacaoDdiTelemovel"], $_POST["telemovel"], $_POST["sexo"], $numPorta, $rua,
                $_POST["codPostal"], $_POST["localidade"], $_POST["nacionalidade"], $_POST["designacaoDdiContacto"],
                $_POST["contacto"], $_POST["contactoEmergencia"], $_POST["grauRelacionamento"], $_POST["matricula"]);

                $dal->registarDadosHabilitacoes($_POST["email"], $_POST["habLiterarias"], $_POST["curso"],
                $_POST["frequencia"]);

                $dal->registarDadosFinanceiros($_POST["email"], $_POST["cc"], $_POST["nif"], $_POST["niss"],
                $_POST["situacaoIrs"], $_POST["numDependentes"], $_POST["iban"], $_POST["remuneracao"]);

                if($_POST["voucherNos"]!=""){
                    $dal->adicionarVoucher($_POST["voucherNos"]);
                }

                $dal->registarDadosExtras($_POST["email"], $_POST["cartaoContinente"], $_POST["idVoucherNos"]);

                $dal->registarDadosContrato($_POST["email"], $_POST["tipoContrato"], $_POST["regimeHorarioTrabalho"],
                $_POST["dataInicio"], $_POST["dataFim"]);

                $dal->atualizarEstadoColaborador($_POST["email"]);

                header("Location: index.php");
            }
            showFormRegistar($dadosBase);
        }
    }
    else if($result["papel"]==2 || $result["papel"]==3 || $result["papel"]==4){
        $dados=$dal->obterDadosPerfil($_SESSION["email"]);
        if($_POST){
            //Separação da Morada em Rua e Nº da Porta
            list($rua, $numPorta)=explode(", ", $_POST["morada"]);

            $dal->atualizarColaborador($_POST["nome"], $_POST["email"], $_POST["password"]);

            $dal->atualizarDadosPessoais($_POST["numMec"], $_POST["email"], $_POST["nomeAbreviado"], $_POST["dataNascimento"],
            $_POST["designacaoDdiTelemovel"], $_POST["telemovel"], $_POST["sexo"], $numPorta, $rua,
            $_POST["codPostal"], $_POST["localidade"], $_POST["nacionalidade"], $_POST["designacaoDdiContacto"],
            $_POST["contacto"], $_POST["contactoEmergencia"], $_POST["grauRelacionamento"], $_POST["matricula"]);

            $dal->atualizarDadosHabilitacoes($_POST["email"], $_POST["habLiterarias"], $_POST["curso"],
            $_POST["frequencia"]);

            $dal->atualizarDadosFinanceiros($_POST["email"], $_POST["cc"], $_POST["nif"], $_POST["niss"],
            $_POST["situacaoIrs"], $_POST["numDependentes"], $_POST["iban"], $_POST["remuneracao"]);

            $dal->atualizarDadosExtras($_POST["email"], $_POST["cartaoContinente"], $_POST["voucherNos"]);

            $dal->atualizarDadosContrato($_POST["email"], $_POST["tipoContrato"], $_POST["regimeHorarioTrabalho"],
            $_POST["dataInicio"], $_POST["dataFim"]);

            //$dal->atualizarPedidos($_POST["email"], $rua, $numPorta);

            header("Location: index.php");
        }
        $controlo="";
        $disabled="";
        showFormAtualizar($dados, $controlo, $disabled);
    }
}

function isThisACallback(){
    if($_POST){ //Acrescentar mais validações que possam ser necessárias
        return true;
    }
    return false;
}
  
function showFormAtualizar($dados, $controlo, $disabled){
    $dal=new DAL_Atualizar();
    if($dados){
        $controlo="";
        $select="";
        if($dados["papel"]==1){
            $controlo="readonly";
            $select="disabled";
        }
        echo '<form action="perfil.php" method="POST" enctype="multipart/form-data">
            <div class="containerAtualizar">
            <label>Nº Mecanográfico:</label><br> <input type="text" name="numMec" placeholder="Nº Mecanográfico" value="',$dados["numMec"],'" ',$controlo,' required><br><br>
            <label>Nome Completo:</label><br> <input type="text" name="nome" placeholder="Nome Completo" value="',$dados["nome"],'" ',$controlo,' required><br><br>
            <label>Nome Abreviado:</label><br> <input type="text" name="nomeAbreviado" placeholder="ex: António Silva" value="',$dados["nomeAbreviado"],'" ',$controlo,' required>
            </div>
            <div class="containerAtualizar">
            <label>Data de Nascimento:</label><br> <input type="date" name="dataNascimento" value="',$dados["dataNascimento"],'" ',$controlo,' required><br>
            </div>
            <div class="caixa2">
                <span>
                <label>Número de Identificação Fiscal:</label>
                <br>
                <input type="text" name="nif" placeholder="NIF" value="',$dados["nif"],'" ',$controlo,' required>
                </span>
                <span>
                <label>Número de Segurança Social:</label>
                <br>
                <input type="text" name="niss" placeholder="NISS" value="',$dados["niss"],'" ',$controlo,' required>
                </span>
                <span>
                <label>Número Cartão de Cidadão:</label>
                <br>
                <input type="text" name="cc" placeholder="CC" value="',$dados["cc"],'" ',$controlo,' required>
                </span>
            </div>';

        $sexo_result_array=$dal->obterSexo();
        #É correr o array sexo_array e ver em qual indice o valor do sexo é igual ao sexo do colaborador em questão.
        echo '<div class="caixa2">
        <span>
        <label>Sexo:</label><br> <select name="sexo" required>';
        foreach($sexo_result_array as $element){
            if($dados["sexo"]==$element["sexo"]){
                echo '<option value="',$element["sexo"],'" selected>',$element["designacao"],'</option>';
            } else{
                echo '<option value="',$element["sexo"],'">',$element["designacao"],'</option>';
            }
            
        }
        echo '</select><br>';
        echo '</span>';
        echo '<span>
        <label>Nacionalidade:</label><br>
        <select name="nacionalidade" ',$disabled,' required>';
        $nacionalidade_array=$dal->obterNacionalidade();
        foreach($nacionalidade_array as $nacionalidade){
            if($nacionalidade["nacionalidade"]==$dados["nacionalidade"]){
                echo '<option value="',$nacionalidade["nacionalidade"],'" selected>',$nacionalidade["nacionalidade"],'</option>';
            } else{
                echo '<option value="',$nacionalidade["nacionalidade"],'">',$nacionalidade["nacionalidade"],'</option>';
            }
        }
        echo '</select>';
        if($disabled!=""){
            echo '<input type="text" value="',$dados["nacionalidade"],'" name="nacionalidade" hidden>';
        }
        echo '</span>
        </div>';

        $situacaoIrs_array=$dal->obterSituacaoIrs();

        echo '<div class="caixa3">
        <span>
        <label>Situação IRS:</label><br> <select name="situacaoIrs" required>';
        foreach($situacaoIrs_array as $situacaoIrs){
            if($situacaoIrs["situacaoIrs"]==$dados["situacaoIrs"]){
                echo '<option value="',$situacaoIrs["situacaoIrs"],'" selected>',$situacaoIrs["situacaoIrs"],'</option>';
            } else{
                echo '<option value="',$situacaoIrs["situacaoIrs"],'">',$situacaoIrs["situacaoIrs"],'</option>';
            }
        }
        echo '</select><br>
        </span>';
        
        
        echo '<span>
        <label>Nº de Dependentes:</label><br> <input type="text" name="numDependentes" placeholder="Número de Dependentes" value="',$dados["numDependentes"],'" required></span>
        </div>
        <div class="containerAtualizar">
        <label>Morada:</label> <input type="text" name="morada" placeholder="Rua, Nº da Porta" value="',$dados["rua"],', ',$dados["numPorta"],'" required>
        <div class="input-file-wrapper">
        <label for="ficheiroMorada" class="input-file-label">Escolher comprovativo de morada</label>
        <br>
        <input type="file" id="ficheiroMorada" name="documentoMorada"/>
        </div><br>
        <label>Localidade:</label> <input type="text" name="localidade" placeholder="Localidade" value="', $dados["localidade"],'" required><br>
        <label>Código Postal:</label> <input type="text" name="codPostal" placeholder="Código Postal (ex: 4320-350)" value="', $dados["codPost"],'" required><br>
        </div>';


        echo '<div class="caixa3">
        <span>';
        
        echo'<label>Telemóvel:</label><br>
        <select name="designacaoDdiTelemovel" id="ddiTelemovel" required>';
        $ddi_array=$dal->obterDDIs();
        foreach($ddi_array as $ddi){
            if($ddi["designacao"]==$dados["designacaoDdiTelemovel"]){
                echo '<option value="',$ddi["designacao"],'" selected>+',$ddi["ddi"],' - (',$ddi["designacao"],')</option>';
            } else{
                echo '<option value="',$ddi["designacao"],'">+',$ddi["ddi"],' - (',$ddi["designacao"],')</option>';
            }
        }
        echo '</select>
        <input type="text" name="telemovel" placeholder="Telemóvel" value="', $dados["telemovel"],'" required>
        </span>
        <span>
        <label>Email:</label><br><input type="text" name="email" placeholder="email" value="',$dados["email"],'" readonly required>
        </span>
        <span>
        <label>Password:</label><br><input type="password" name="password" placeholder="Nova Palavra-Passe (Opcional)"">
        </span>
        </div>
        <div class="containerAtualizar">
        <label>IBAN:</label> <input type="text" name="iban" placeholder="IBAN" value="',$dados["iban"],'" required>
        </div>
        <div class="containerAtualizar">
        <label>Contacto de Emergência:</label><input type="text" name="contactoEmergencia" placeholder="Nome" value="',$dados["contactoEmergencia"],'" required><br>
        <label>Grau de Relacionamento:</label><input type="text" name="grauRelacionamento" placeholder="Grau de Parentesco" value="',$dados["grauRelacionamento"],'" required><br>
        <label>Contacto:</label>';
        echo '<select name="designacaoDdiContacto" id="ddiContacto" required>';
        foreach($ddi_array as $ddi){
            if($ddi["designacao"]==$dados["designacaoDdiContacto"]){
                echo '<option value="',$ddi["designacao"],'" selected>+',$ddi["ddi"],' - (',$ddi["designacao"],')</option>';
            } else{
                echo '<option value="',$ddi["designacao"],'">+',$ddi["ddi"],' - (',$ddi["designacao"],')</option>';
            }
        }
        echo '</select>
        <input type="text" name="contacto" placeholder=""9********" value="',$dados["contacto"],'" required><br>
        </div>

        <div class="caixa3">
        <span>
        <label>Matrícula do Carro</label><input type="text" name="matricula" placeholer="Matrícula" value="',$dados["matricula"],'" required>
        </span>
        <span>
        <label>Continente</label><input type="text" name="cartaoContinente" placeholer="Nº Cartão Continente" value="',$dados["cartaoContinente"],'" required>
        </span>
        <span>
        <label>Voucher NOS</label>';

        $resultado=$dal->obterDataVoucherNos($dados["email"]);

        if($dados["idVoucherNos"]!=null){
            echo '<select name="voucherNos" ',$disabled,'>
            <option value="',$dados["idVoucherNos"],'">',$resultado["voucherNos"],'</option>
            </select>
            <input type="date" name="idVoucherNos" value="',$dados["idVoucherNos"],'" ',$controlo,' hidden/>';
        } else{
            echo '<select name="voucherNos" ',$disabled,'>
            <option value="',null,'">Não tem Voucher NOS</option>
            </select>
            <input type="date" name="idVoucherNos" value="',null,'" ',$controlo,' hidden/>';
        }

        echo '</span>
        </div>
        <div class="containerAtualizar">
        <label>Habilitações Literárias</label>
        <select name="habLiterarias" required>';
        $habLiterarias_array=$dal->obterHabilitacoesLiterarias();

        foreach($habLiterarias_array as $habLiterarias){
            if($habLiterarias["habLiterarias"]==$dados["habLiterarias"]){
                echo '<option value="',$habLiterarias["habLiterarias"],'" selected>',$habLiterarias["habLiterarias"],'</option>';
            } else{
                echo '<option value="',$habLiterarias["habLiterarias"],'">',$habLiterarias["habLiterarias"],'</option>';
            }
        }

        echo '</select><br>
        <label>Curso</label><input type="text" value="',$dados["curso"],'" name="curso" placeholder="Curso" required/><br>
        <label>Frequência</label><input type="text" value="',$dados["frequencia"],'" name="frequencia" placeholder="Indique \'Concluído\' ou \'Em curso\'" required/>
        </div>

        <div class="caixa2">
        <span>
        <label>Tipo de Contrato:</label>
        <select name="tipoContrato" ',$disabled,' required>';
        $tipoContrato_array=$dal->obterTipoContrato();

        foreach($tipoContrato_array as $tipoContrato){
            if($tipoContrato["tipoContrato"]==$dados["tipoContrato"]){
                echo '<option value="',$tipoContrato["tipoContrato"],'" selected>',$tipoContrato["tipoContrato"],'</option>';
            } else{
                echo '<option value="',$tipoContrato["tipoContrato"],'">',$tipoContrato["tipoContrato"],'</option>';
            }
        }

        if($disabled!=""){
            echo '<input type="text" value="',$dados["tipoContrato"],'" name="tipoContrato" hidden>';
        }
        echo '</select>
        </span>
        <span>
        <label>Data de Início</label><input type="date" name="dataInicio" value="',$dados["dataInicio"],'" ',$controlo,' required/>
        </span>
        <span>
        <label>Data de Fim</label><input type="date" name="dataFim"value="',$dados["dataFim"],'" ',$controlo,' required/>
        </span>
        <span>
        <label>Remuneração:</label>
        <select name="remuneracao" ',$disabled,' required>';
        $remuneracao_array=$dal->obterRemuneracao();
        foreach($remuneracao_array as $remuneracao){
            if($remuneracao["remuneracao"]==$dados["remuneracao"]){
                echo '<option value="',$remuneracao["remuneracao"],'" selected>',$remuneracao["remuneracao"],'</option>';
            } else{
                echo '<option value="',$remuneracao["remuneracao"],'">',$remuneracao["remuneracao"],'</option>';
            }
        }
        if($disabled!=""){
            echo '<input type="text" value="',$dados["remuneracao"],'" name="remuneracao" hidden>';
        }
        echo '</select>
        </span>
        <span>
        <label>Regime de Horário de Trabalho</label>
        <select name="regimeHorarioTrabalho" ',$disabled,' required>';
        $regimeHorarioTrabalho_array=$dal->obterRegimesHorarioTrabalho();

        foreach($regimeHorarioTrabalho_array as $regimeHorarioTrabalho){
            if($regimeHorarioTrabalho["regimeHorarioTrabalho"]==$dados["regimeHorarioTrabalho"]){
                echo '<option value="',$regimeHorarioTrabalho["regimeHorarioTrabalho"],'" selected>',$regimeHorarioTrabalho["regimeHorarioTrabalho"],'</option>';
            } else{
                echo '<option value="',$regimeHorarioTrabalho["regimeHorarioTrabalho"],'">',$regimeHorarioTrabalho["regimeHorarioTrabalho"],'</option>';
            }
        }
        if($disabled!=""){
            echo '<input type="text" value="',$dados["regimeHorarioTrabalho"],'" name="regimeHorarioTrabalho" hidden>';
        }
        echo '</select>
        </span>
        </div>
        <div class="containerAtualizar_button">
        <input type="submit" value="Atualizar Informações / Registar">
        </div>
        </form>';
    }
}

function showFormRegistar($dadosBase){  
    $dal=new DAL_Atualizar();
        echo '<form action="perfil.php" method="POST">
            <div class="containerAtualizar">
            <label>Nº Mecanográfico:</label><br> <input type="text" name="numMec" placeholder="Nº Mecanográfico" readonly required><br><br>
            <label>Nome Completo:</label><br> <input type="text" name="nome" placeholder="Nome Completo" value="',$dadosBase["nome"],'"required><br><br>
            <label>Nome Abreviado:</label><br> <input type="text" name="nomeAbreviado" placeholder="ex: António Silva" required>
            </div>
            <div class="containerAtualizar">
            <label>Data de Nascimento:</label><br> <input type="date" name="dataNascimento" required><br>
            </div>
            <div class="caixa2">
                <span>
                <label>Número de Identificação Fiscal:</label>
                <br>
                <input type="text" name="nif" placeholder="NIF" required>
                </span>
                <span>
                <label>Número de Segurança Social:</label>
                <br>
                <input type="text" name="niss" placeholder="NISS" required>
                </span>
                <span>
                <label>Número Cartão de Cidadão:</label>
                <br>
                <input type="text" name="cc" placeholder="CC" required>
                </span>
            </div>';

        $sexo_result_array=$dal->obterSexo();
        #É correr o array sexo_array e ver em qual indice o valor do sexo é igual ao sexo do colaborador em questão.
        echo '<div class="caixa2">
        <span>
        <label>Sexo:</label><br> <select name="sexo" required>';
        foreach($sexo_result_array as $element){
            echo '<option value="',$element["sexo"],'">',$element["designacao"],'</option>';
        }
        echo '</select><br>';
        echo '</span>';
        echo '<span>
        <label>Nacionalidade:</label><br>
        <select name="nacionalidade" required>';
        $nacionalidade_array=$dal->obterNacionalidade();
        foreach($nacionalidade_array as $nacionalidade){
            if($nacionalidade["nacionalidade"]==$dados["nacionalidade"]){
                echo '<option value="',$nacionalidade["nacionalidade"],'" selected>',$nacionalidade["nacionalidade"],'</option>';
            } else{
                echo '<option value="',$nacionalidade["nacionalidade"],'">',$nacionalidade["nacionalidade"],'</option>';
            }
        }
        echo '</select>
        </span>
        </div>';
        $situacaoIrs_array=$dal->obterSituacaoIrs();

        echo '<div class="caixa3">
        <span>
        <label>Situação IRS:</label><br> <select name="situacaoIrs" required>';
        foreach($situacaoIrs_array as $situacaoIrs){
            echo '<option value="',$situacaoIrs["situacaoIrs"],'">',$situacaoIrs["situacaoIrs"],'</option>';
        }
        echo '</select><br>
        </span>';
        
        
        echo '<span>
        <label>Nº de Dependentes:</label><br> <input type="text" name="numDependentes" placeholder="Número de Dependentes" required></span>
        </div>
        <div class="containerAtualizar">
        <label>Morada:</label> <input type="text" name="morada" placeholder="Rua, Nº da Porta" required><br>
        <label>Localidade:</label> <input type="text" name="localidade" placeholder="Localidade" required><br>
        <label>Código Postal:</label> <input type="text" name="codPostal" placeholder="Código Postal (ex: 4320-350)" required><br>
        </div>';


        echo '<div class="caixa3">
        <span>';
        
        echo'<label>Telemóvel:</label><br>
        <select name="designacaoDdiTelemovel" id="ddiTelemovel" required>';
        $ddi_array=$dal->obterDDIs();
        foreach($ddi_array as $ddi){
            echo '<option value="',$ddi["designacao"],'">+',$ddi["ddi"],' - (',$ddi["designacao"],')</option>';
        }
        echo '</select>
        <input type="text" name="telemovel" placeholder="Telemóvel" required>
        </span>
        <span>
        <label>Email:</label><br><input type="text" name="email" value="',$_SESSION["email"],'" placeholder="email" readonly required>
        </span>
        <span>
        <label>Password:</label><br><input type="password" name="password" placeholder="Nova Palavra-Passe (Opcional)"">
        </span>
        </div>
        <div class="containerAtualizar">
        <label>IBAN:</label> <input type="text" name="iban" placeholder="IBAN" required>
        </div>
        <div class="containerAtualizar">
        <label>Contacto de Emergência:</label><input type="text" name="contactoEmergencia" placeholder="Nome" required><br>
        <label>Grau de Relacionamento:</label><input type="text" name="grauRelacionamento" placeholder="Grau de Parentesco" required><br>
        <label>Contacto:</label>';
        echo '<select name="designacaoDdiContacto" id="ddiContacto" required>';
        foreach($ddi_array as $ddi){
            echo '<option value="',$ddi["designacao"],'">+',$ddi["ddi"],' - (',$ddi["designacao"],')</option>';
        }
        echo '</select>
        <input type="text" name="contacto" placeholder="9********" required><br>
        </div>

        <div class="caixa3">
        <span>
        <label>Matrícula do Carro</label><input type="text" name="matricula" placeholer="Matrícula" required>
        </span>
        <span>
        <label>Continente</label><input type="text" name="cartaoContinente" placeholer="Nº Cartão Continente" required>
        </span>
        <span>';

        $voucherNos_array=$dal->obterVoucherNos();
        #É correr o array sexo_array e ver em qual indice o valor do sexo é igual ao sexo do colaborador em questão.

        echo '<label>Voucher NOS:</label><br> <select name="idVoucherNos">
        <option value="',null,'" selected>Indique uma data VoucherNOS</option>';
        foreach($voucherNos_array as $resultado){
            echo '<option value="',$resultado["idVoucherNos"],'">',$resultado["voucherNos"],'</option>';
        }
        echo '</select><br>
        </span>
        </div>
        <div class="containerAtualizar">
        <label>Habilitações Literárias</label>
        <select name="habLiterarias" required>';
        $habLiterarias_array=$dal->obterHabilitacoesLiterarias();

        foreach($habLiterarias_array as $habLiterarias){
            echo '<option value="',$habLiterarias["habLiterarias"],'">',$habLiterarias["habLiterarias"],'</option>';
        }

        echo '</select><br>
        <label>Curso</label><input type="text" name="curso" placeholder="Curso" required/><br>
        <label>Frequência</label><input type="text" name="frequencia" placeholder="Indique \'Concluído\' ou \'Em curso\'" required/>
        </div>

        <div class="caixa2">
        <span>
        <label>Tipo de Contrato:</label>
        <select name="tipoContrato" required>';
        $tipoContrato_array=$dal->obterTipoContrato();

        foreach($tipoContrato_array as $tipoContrato){
            echo '<option value="',$tipoContrato["tipoContrato"],'">',$tipoContrato["tipoContrato"],'</option>';
        }

        echo '</select>
        </span>
        <span>
        <label>Data de Início</label><input type="date" name="dataInicio" required/>
        </span>
        <span>
        <label>Data de Fim</label><input type="date" name="dataFim" required/>
        </span>
        <span>
        <label>Remuneração:</label>
        <select name="remuneracao" required>';
        $remuneracao_array=$dal->obterRemuneracao();
        foreach($remuneracao_array as $remuneracao){
            if($remuneracao["remuneracao"]==$dados["remuneracao"]){
                echo '<option value="',$remuneracao["remuneracao"],'" selected>',$remuneracao["remuneracao"],'</option>';
            } else{
                echo '<option value="',$remuneracao["remuneracao"],'">',$remuneracao["remuneracao"],'</option>';
            }
        }
        echo '</select>
        </span>
        <span>
        <label>Regime de Horário de Trabalho</label>
        <select name="regimeHorarioTrabalho" required>';
        $regimeHorarioTrabalho_array=$dal->obterRegimesHorarioTrabalho();

        foreach($regimeHorarioTrabalho_array as $regimeHorarioTrabalho){
            echo '<option value="',$regimeHorarioTrabalho["regimeHorarioTrabalho"],'">',$regimeHorarioTrabalho["regimeHorarioTrabalho"],'</option>';
        }
        echo '</select>
        </span>
        </div>
        <div class="containerAtualizar_button">
        <input type="submit" value="Atualizar Informações / Registar">
        </div>
        </form>';
}