<?php
session_start();
include "atualizar_perfil_dal.php";

echo "<br>Email do Utilizador logado: ", $_SESSION["email"];
echo "<br><br>Password do Utilizador logado: ", $_SESSION["password"];



function obterDadosPerfil(){
    $dal=new DAL_Atualizar();
    $dados=$dal->obterDadosPerfil($_SESSION["email"], $_SESSION["password"]);

    showForm($dados);
}

function isThisACallback(){
    if($_POST){ //Acrescentar mais validações que possam ser necessárias
        return true;
    }
    return false;
}
//Dados de escrita: Morada; Género; Situação IRS; Nº Dependentes; IBAN; Hab. Literárias; Curso; Frequência; Contacto de Emergência;
//Matrícula; Cartão Continente; Grau de Relacionamento; Contacto;  
function showForm($dados){
    if($dados){
    echo '<form action="atualizar_perfil.php" method="POST">
        <div class="container">
        <label>Nome Completo:</label><br> <input type="text" name="nome" placeholder="Nome Completo" value="',$dados["nome"],'" readonly required><br><br>
        <label>Nome Abreviado:</label><br> <input type="text" name="nomeAbreviado" placeholder="ex: António Silva" value="',$dados["nomeAbreviado"],'"readonly required>
        </div>
        <div class="container">
        <label>Data de Nascimento:</label><br> <input type="date" name="dataNascimento" value="',$dados["dataNascimento"],'" readonly required><br>
        </div>
        <div class="caixa2">
            <span>
            <label>Número de Identificação Fiscal:</label>
            <br>
            <input type="text" name="nif" placeholder="NIF" value="',$dados["nif"],'" readonly required>
            </span>
            <span>
            <label>Número de Segurança Social:</label>
            <br>
            <input type="text" name="niss" placeholder="NISS" value="',$dados["niss"],'" readonly required>
            </span>
            <span>
            <label>Número Cartão de Cidadão:</label>
            <br>
            <input type="text" name="cc" placeholder="CC" value="',$dados["cc"],'" readonly required>
            </span>
        </div>';

        $sexo_array=["M","F"];
        #É correr o array sexo_array e ver em qual indice o valor do sexo é igual ao sexo do colaborador em questão.
        echo '<div class="caixa2">
        <span>
        <label>Sexo:</label><br> <select name="sexo" required>';
       
        echo '</select><br>';
        echo '</span>';
        echo '<span>
        <label>Nacionalidade:</label><br> <input type="text" name="nacionalidade" placeholder="Nacionalidade" value="',$dados["nacionalidade"],'" readonly required><br>
        </span>
        </div>';
        $situacaoIrs_array=["Declaração de IRS recepcionada","Declaração certa","Liquidação processada","Reembolso Emitido","Pagamento Confirmado","Liquidada com nota de cobrança emitida","Notificação emitida","Liquidada com Saldo Nulo Emitido"];

        echo '<div class="caixa3">
        <span>'
        
        echo '</select><br>
        </span>';
        
        
        echo '<span>
        <label>Dependentes:</label><br> <input type="text" name="numDependentes" placeholder="Número de Dependentes" value="',$dados["numDependentes"],'" required></span>
        <span>
        <label>IRS Jovem:</label> O que é isto?
        </span>
        <span><label>Primeiro ano de descontos (independente):</label> O que é isto?</span>
        </div>
        <div class="container">
        <label>Morada:</label> <input type="text" name="morada" placeholder="Morada, i.e. Rua, Nº da Porta" value="',$dados["rua"],', ',$dados["numPorta"],'" required><br>
        <label>Localidade:</label> <input type="text" name="localidade" placeholder="Localidade" value="', $dados["localidade"],'" required><br>
        <label>Código Postal:</label> <input type="text" name="codPostal" placeholder="Código Postal (ex: 4320-350)" value="', $dados["codPost"],'" required><br>
        </div>';


        echo '<div class="caixa3">
        <span>
        <label>Telemóvel:</label><br><input type="text" name="contacto" placeholder="Telemóvel" value="', $dados["contacto"],'" required>
        </span>
        <span>
        <label>Email:</label><br><input type="text" name="email" placeholder="email" value="',$dados["email"],'" readonly required>
        </span>
        </div>
        <div class="container">
        <label>IBAN:</label> <input type="text" name="iban" placeholder="IBAN" value="',$dados["iban"],'" required>
        </div>
        <div class="container">
        <label>Contacto de Emergência:</label><input type="text" name="contactoEmergencia" placeholder="Nome" value="',$dados["contactoEmergencia"],'" required><br>
        <label>Grau de Relacionamento:</label><input type="text" name="grauRelacionamento" placeholder="Grau de Parentesco" value="',$dados["grauRelacionamento"],'" required><br>
        <label>Contacto:</label><input type="text" name="contacto" placeholder=""9********" value="',$dados["contacto"],'" required><br>
        </div>

        <div class="caixa3">
        <span>
        <label>Matrícula do Carro</label><input type="text" name="matricula" placeholer="Matrícula" value="',$dados["matricula"],'" required>
        </span>
        <span>
        <label>Continente</label><input type="text" name="cartaoContinente" placeholer="Nº Cartão Continente" value="',$dados["cartaoContinente"],'" required>
        </span>
        </div>
        <div class="container_button">
        <input type="submit" value="Atualizar Informações / Registar">
        </div>
        </form>';
    }

    function showUI(){
        if(!isThisACallback()){
            showForm();
        }
        else {
            
        }
    }
}