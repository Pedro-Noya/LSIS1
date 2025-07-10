<?php
session_start();
require_once __DIR__ . '/../DAL/InformacoesColaborador_dal.php';

if($_GET){
    $_SESSION["emailColaborador"]=$_GET["email"];
}

function obterDadosPerfil(){
    $dal=new DAL_Atualizar();
    $dadosLogados=$dal->obterDadosUtilizador($_SESSION["email"]);
    if($dadosLogados["papel"]==3){
        $dados=$dal->obterDadosUtilizador($_SESSION["emailColaborador"]);
        $dadosColaborador=$dal->obterDadosPerfil($_SESSION["emailColaborador"]);
        if($dados["estado"]==0){
            if($_POST){
                list($rua, $numPorta)=explode(", ", $_POST["morada"]);

                $dal->atualizarEstado($_SESSION["emailColaborador"]);

                $dal->registarDadosPessoais($_POST["numMec"], $_POST["email"], $_POST["nomeAbreviado"], $_POST["dataNascimento"],
                $_POST["designacaoDdiTelemovel"], $_POST["telemovel"], $_POST["sexo"], $numPorta, $rua,
                $_POST["codPostal"], $_POST["localidade"], $_POST["nacionalidade"], $_POST["designacaoDdiContacto"],
                $_POST["contacto"], $_POST["contactoEmergencia"], $_POST["grauRelacionamento"], $_POST["matricula"]);

                $dal->registarDadosHabilitacoes($_POST["email"], $_POST["habLiterarias"], $_POST["curso"],
                $_POST["frequencia"]);

                $dal->registarDadosFinanceiros($_POST["email"], $_POST["cc"], $_POST["nif"], $_POST["niss"],
                $_POST["situacaoIrs"], $_POST["numDependentes"], $_POST["iban"], $_POST["remuneracao"]);

                //Aqui é importante ter em consideração 2 coisas:
                //1º Considere-se que o Colaborador tem um voucher NOS com a data 26-09-2025.
                //Contudo, o RH viu melhor e apercebeu-se que tinha atribuído o voucher errado!
                //Qual seria a solução para este problema? Óbivamente era "desassociar" o voucher atual desse colaborador
                //e associar o novo certo.
                //Como se faria uma coisa dessas? Uma solução é, antes de atualizar os dados extras do colaborador, vai-se
                //usar uma função para atualizar o estado do voucher antigo para 0 e o novo para 1 e depois sim atualizam-se os dados.
                //Vão ser usadas, então, duas funções para a atualização do estado do voucher antigo e do voucher novo.
                if($_POST["voucherNos"]!=""){
                    $dal->adicionarVoucher($_POST["voucherNos"]);
                }
                $dal->registarDadosExtras($_POST["email"], $_POST["cartaoContinente"], $_POST["voucherNos"]);
                $dal->registarDadosContrato($_POST["email"], $_POST["tipoContrato"], $_POST["regimeHorarioTrabalho"],
                $_POST["dataInicio"], $_POST["dataFim"]);

                header("Location: index.php");
            }
            showFormRegistar($dados);
        } else {
            if($_POST){
                list($rua, $numPorta)=explode(", ", $_POST["morada"]);

                $dal->atualizarDadosPessoais($_POST["numMec"], $_POST["email"], $_POST["nomeAbreviado"], $_POST["dataNascimento"],
                $_POST["designacaoDdiTelemovel"], $_POST["telemovel"], $_POST["sexo"], $numPorta, $rua,
                $_POST["codPostal"], $_POST["localidade"], $_POST["nacionalidade"], $_POST["designacaoDdiContacto"],
                $_POST["contacto"], $_POST["contactoEmergencia"], $_POST["grauRelacionamento"], $_POST["matricula"]);

                $dal->atualizarDadosHabilitacoes($_POST["email"], $_POST["habLiterarias"], $_POST["curso"],
                $_POST["frequencia"]);

                $dal->atualizarDadosFinanceiros($_POST["email"], $_POST["cc"], $_POST["nif"], $_POST["niss"],
                $_POST["situacaoIrs"], $_POST["numDependentes"], $_POST["iban"], $_POST["remuneracao"]);

                //Aqui é importante ter em consideração 2 coisas:
                //1º Considere-se que o Colaborador tem um voucher NOS com a data 26-09-2025.
                //Contudo, o RH viu melhor e apercebeu-se que tinha atribuído o voucher errado!
                //Qual seria a solução para este problema? Óbivamente era "desassociar" o voucher atual desse colaborador
                //e associar o novo certo.
                //Como se faria uma coisa dessas? Uma solução é, antes de atualizar os dados extras do colaborador, vai-se
                //usar uma função para atualizar o estado do voucher antigo para 0 e o novo para 1 e depois sim atualizam-se os dados.
                //Vão ser usadas, então, duas funções para a atualização do estado do voucher antigo e do voucher novo.
                if(!(is_null($dadosColaborador["idVoucherNos"])) || $dadosColaborador["idVoucherNos"]!=""){
                    $dal->removerVoucher($dadosColaborador["idVoucherNos"]);
                }
                if($_POST["voucherNos"]!=""){
                    $dal->adicionarVoucher($_POST["voucherNos"]);
                }
                $dal->atualizarDadosExtras($_POST["email"], $_POST["cartaoContinente"], $_POST["voucherNos"]);
                $dal->atualizarDadosContrato_RH($_POST["email"], $_POST["tipoContrato"], $_POST["regimeHorarioTrabalho"],
                $_POST["dataInicio"], $_POST["dataFim"]);

                header("Location: index.php");
            }
            showFormAtualizar($dadosColaborador);
        }
    }
    if($dadosLogados["papel"]==2){
        $email=$_GET["email"];
        $dadosColaborador=$dal->obterDadosPerfil($email);
        showFormCoordenador($dadosColaborador);
    }

    function isThisACallback(){
        if($_POST){
            return true;
        }
        return false;
    }
}
    function showFormAtualizar($dados){  
    $dal=new DAL_Atualizar();
    if($dados){
        echo '<form action="InformacoesColaborador.php" method="POST">
            <div class="containerAtualizar">
            <label>Nº Mecanográfico:</label><br> <input type="text" name="numMec" placeholder="Nº Mecanográfico" value="',$dados["numMec"],'" required><br><br>
            <label>Nome Completo:</label><br> <input type="text" name="nome" placeholder="Nome Completo" value="',$dados["nome"],'" required><br><br>
            <label>Nome Abreviado:</label><br> <input type="text" name="nomeAbreviado" placeholder="ex: António Silva" value="',$dados["nomeAbreviado"],'" required>
            </div>
            <div class="containerAtualizar">
            <label>Data de Nascimento:</label><br> <input type="date" name="dataNascimento" value="',$dados["dataNascimento"],'" required><br>
            </div>
            <div class="caixa2">
                <span>
                <label>Número de Identificação Fiscal:</label>
                <br>
                <input type="text" name="nif" placeholder="NIF" value="',$dados["nif"],'" required>
                </span>
                <span>
                <label>Número de Segurança Social:</label>
                <br>
                <input type="text" name="niss" placeholder="NISS" value="',$dados["niss"],'" required>
                </span>
                <span>
                <label>Número Cartão de Cidadão:</label>
                <br>
                <input type="text" name="cc" placeholder="CC" value="',$dados["cc"],'" required>
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
        <label>Morada:</label> <input type="text" name="morada" placeholder="Rua, Nº da Porta" value="',$dados["rua"],', ',$dados["numPorta"],'" required><br>
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
        <label>Email:</label><br><input type="text" name="email" placeholder="email" value="',$dados["email"],'" required>
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
        <label>Voucher NOS</label>
        <select name="voucherNos">
        <option value="',null,'">Selecione um voucher NOS</option>';
        $voucherNos_array=$dal->obterVoucherNos();
        if($dados["idVoucherNos"]!=null){
            $dataVoucherNosColaborador=$dal->obterDataVoucher($dados["idVoucherNos"]);
            echo '<option value="',$dados["idVoucherNos"],'" selected>',$dataVoucherNosColaborador["voucherNos"],'</option>';
        }
        foreach($voucherNos_array as $voucherNos){
            if($voucherNos["idVoucherNos"]==$dados["idVoucherNos"]){
                echo '<option value="',$voucherNos["idVoucherNos"],'" selected>',$voucherNos["voucherNos"],'</option>';
            } else{
                echo '<option value="',$voucherNos["idVoucherNos"],'">',$voucherNos["voucherNos"],'</option>';
            }
        }

        echo '</select>
        </span>
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
        <select name="tipoContrato" required>';
        $tipoContrato_array=$dal->obterTipoContrato();

        foreach($tipoContrato_array as $tipoContrato){
            if($tipoContrato["tipoContrato"]==$dados["tipoContrato"]){
                echo '<option value="',$tipoContrato["tipoContrato"],'" selected>',$tipoContrato["tipoContrato"],'</option>';
            } else{
                echo '<option value="',$tipoContrato["tipoContrato"],'">',$tipoContrato["tipoContrato"],'</option>';
            }
        }

        echo '</select>
        </span>
        <span>
        <label>Data de Início</label><input type="date" name="dataInicio" value="',$dados["dataInicio"],'" required/>
        </span>
        <span>
        <label>Data de Fim</label><input type="date" name="dataFim"value="',$dados["dataFim"],'" required/>
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
            if($regimeHorarioTrabalho["regimeHorarioTrabalho"]==$dados["regimeHorarioTrabalho"]){
                echo '<option value="',$regimeHorarioTrabalho["regimeHorarioTrabalho"],'" selected>',$regimeHorarioTrabalho["regimeHorarioTrabalho"],'</option>';
            } else{
                echo '<option value="',$regimeHorarioTrabalho["regimeHorarioTrabalho"],'">',$regimeHorarioTrabalho["regimeHorarioTrabalho"],'</option>';
            }
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

    function showFormRegistar($dados){
        $dal=new DAL_Atualizar();
            echo '<form action="InformacoesColaborador.php" method="POST">
                <div class="containerAtualizar">
                <label>Nº Mecanográfico:</label><br> <input type="text" name="numMec" placeholder="Nº Mecanográfico"><br><br>
                <label>Nome Completo:</label><br> <input type="text" name="nome" placeholder="Nome Completo" value="',$dados["nome"],'" required><br><br>
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
                echo '<option value="',$nacionalidade["nacionalidade"],'">',$nacionalidade["nacionalidade"],'</option>';
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
            <label>Email:</label><br><input type="text" name="email" placeholder="email" value="',$dados["email"],'" readonly required>
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
            <input type="text" name="contacto" placeholder=""9********" required><br>
            </div>

            <div class="caixa3">
            <span>
            <label>Matrícula do Carro</label><input type="text" name="matricula" placeholer="Matrícula" required>
            </span>
            <span>
            <label>Continente</label><input type="text" name="cartaoContinente" placeholer="Nº Cartão Continente" required>
            </span>
            <span>
            <label>Voucher NOS</label>
            <select name="voucherNos">
            <option value="',null,'" selected>Selecione um voucher NOS</option>';
            $voucherNos_array=$dal->obterVoucherNos();
            foreach($voucherNos_array as $voucherNos){
                echo '<option value="',$voucherNos["idVoucherNos"],'">',$voucherNos["voucherNos"],'</option>';
            }

            echo '</select>
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
                echo '<option value="',$remuneracao["remuneracao"],'">',$remuneracao["remuneracao"],'</option>';
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
    function showFormCoordenador($dados){  
    $dal=new DAL_Atualizar();
    if($dados){
        echo '<form action="atualizar_perfil.php" method="POST">
            <div class="containerAtualizar">
            <label>Nº Mecanográfico:</label><br> <input type="text" name="numMec" placeholder="Nº Mecanográfico" value="',$dados["numMec"],'" readonly required><br><br>
            <label>Nome Completo:</label><br> <input type="text" name="nome" placeholder="Nome Completo" value="',$dados["nome"],'" readonly required><br><br>
            <label>Nome Abreviado:</label><br> <input type="text" name="nomeAbreviado" placeholder="ex: António Silva" value="',$dados["nomeAbreviado"],'" readonly required>
            </div>
            <div class="containerAtualizar">
            <label>Data de Nascimento:</label><br> <input type="date" name="dataNascimento" value="',$dados["dataNascimento"],'" readonly required><br>
            </div>';

        $sexo_result_array=$dal->obterSexo();
        #É correr o array sexo_array e ver em qual indice o valor do sexo é igual ao sexo do colaborador em questão.
        echo '<div class="caixa2">
        <span>
        <label>Sexo:</label><br> <select name="sexo" disabled required>';
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
        <select name="nacionalidade" disabled required>';
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

        echo '<div class="containerAtualizar">
        <label>Morada:</label> <input type="text" name="morada" placeholder="Rua, Nº da Porta" value="',$dados["rua"],', ',$dados["numPorta"],'" readonly required><br>
        <label>Localidade:</label> <input type="text" name="localidade" placeholder="Localidade" value="', $dados["localidade"],'" readonly required><br>
        <label>Código Postal:</label> <input type="text" name="codPostal" placeholder="Código Postal (ex: 4320-350)" value="', $dados["codPost"],'" readonly required><br>
        </div>';


        echo '<div class="caixa3">
        <span>';
        
        echo'<label>Telemóvel:</label><br>
        <select name="designacaoDdiTelemovel" id="ddiTelemovel" disabled required>';
        $ddi_array=$dal->obterDDIs();
        foreach($ddi_array as $ddi){
            if($ddi["designacao"]==$dados["designacaoDdiTelemovel"]){
                echo '<option value="',$ddi["designacao"],'" selected>+',$ddi["ddi"],' - (',$ddi["designacao"],')</option>';
            } else{
                echo '<option value="',$ddi["designacao"],'">+',$ddi["ddi"],' - (',$ddi["designacao"],')</option>';
            }
        }
        echo '</select>
        <input type="text" name="telemovel" placeholder="Telemóvel" value="', $dados["telemovel"],'" readonly required>
        </span>
        <span>
        <label>Email:</label><br><input type="text" name="email" placeholder="email" value="',$dados["email"],'" readonly required>
        </span>
        </div>
        <div class="containerAtualizar">
        <label>Contacto de Emergência:</label><input type="text" name="contactoEmergencia" placeholder="Nome" value="',$dados["contactoEmergencia"],'" readonly required><br>
        <label>Grau de Relacionamento:</label><input type="text" name="grauRelacionamento" placeholder="Grau de Parentesco" value="',$dados["grauRelacionamento"],'" readonly required><br>
        <label>Contacto:</label>';
        echo '<select name="designacaoDdiContacto" id="ddiContacto" disabled required>';
        foreach($ddi_array as $ddi){
            if($ddi["designacao"]==$dados["designacaoDdiContacto"]){
                echo '<option value="',$ddi["designacao"],'" selected>+',$ddi["ddi"],' - (',$ddi["designacao"],')</option>';
            } else{
                echo '<option value="',$ddi["designacao"],'">+',$ddi["ddi"],' - (',$ddi["designacao"],')</option>';
            }
        }
        echo '</select>
        <input type="text" name="contacto" placeholder=""9********" value="',$dados["contacto"],'" readonly required><br>
        </div>
        <div class="containerAtualizar">
        <label>Habilitações Literárias</label>
        <select name="habLiterarias" disabled required>';
        $habLiterarias_array=$dal->obterHabilitacoesLiterarias();

        foreach($habLiterarias_array as $habLiterarias){
            if($habLiterarias["habLiterarias"]==$dados["habLiterarias"]){
                echo '<option value="',$habLiterarias["habLiterarias"],'" selected>',$habLiterarias["habLiterarias"],'</option>';
            } else{
                echo '<option value="',$habLiterarias["habLiterarias"],'">',$habLiterarias["habLiterarias"],'</option>';
            }
        }

        echo '</select><br>
        <label>Curso</label><input type="text" value="',$dados["curso"],'" name="curso" placeholder="Curso" readonly required/><br>
        <label>Frequência</label><input type="text" value="',$dados["frequencia"],'" name="frequencia" placeholder="Indique \'Concluído\' ou \'Em curso\'" readonly required/>
        </div>

        <div class="caixa2">
        <span>
        <label>Data de Início</label><input type="date" name="dataInicio" value="',$dados["dataInicio"],'" readonly required/>
        </span>
        <span>
        <label>Data de Fim</label><input type="date" name="dataFim"value="',$dados["dataFim"],'" readonly required/>
        </span>
        </div>
        </form>';
        }
    }