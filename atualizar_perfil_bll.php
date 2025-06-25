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
        <div class="container">
        <span class="caixa2">
            <label>Número de Identificação Fiscal:</label>
            <br>
            <input class="caixa2" type="text" name="nif" placeholder="NIF" value="',$dados["nif"],'" readonly required>
        </span>
        
        <span class="caixa2">
            <label>Número de Segurança Social:</label>
            <br>
            <input class="caixa2" type="text" name="niss" placeholder="NISS" value="',$dados["niss"],'" readonly required>
        </span>
        <span class="caixa2">
            <label>Número Cartão de Cidadão:</label>
            <br>
            <input class="caixa2" type="text" name="cc" placeholder="CC" value="',$dados["cc"],'" readonly required>
        </span>
        </div>';

        $sexo_array=["M","F"];
        #É correr o array sexo_array e ver em qual indice o valor do sexo é igual ao sexo do colaborador em questão.
        echo '<div class="container">
        Sexo: <select name="sexo" required>';
        foreach ($sexo_array as $sexo){
            if($sexo==$dados["sexo"]){
                echo '<option value="',$sexo,'" selected>',$sexo,'</option>';
            } else{
                echo '<option value="',$sexo,'">',$sexo,'</option>';
            }            
        }
        echo '</select><br>';
        echo 'Nacionalidade: <input type="text" name="nacionalidade" placeholder="Nacionalidade" value="',$dados["nacionalidade"],'" readonly required><br>
        </div>';
        $situacaoIrs_array=["Declaração de IRS recepcionada","Declaração certa","Liquidação processada","Reembolso Emitido","Pagamento Confirmado","Liquidada com nota de cobrança emitida","Notificação emitida","Liquidada com Saldo Nulo Emitido"];

        echo '<div class="container">
        Situação IRS: <select name="situacaoIrs" required>';
        foreach($situacaoIrs_array as $situacaoIrs){
            if($situacaoIrs==$dados["situacaoIrs"]){
                echo '<option value="',$situacaoIrs,'" selected>',$situacaoIrs,'</option>';
            } else{
                echo '<option value="',$situacaoIrs,'">',$situacaoIrs,'</option>';
            }
        }
        echo '</select><br>';
        
        echo 'Dependentes: <input type="text" name="numDependentes" placeholder="Número de Dependentes" value="',$dados["numDependentes"],'" required><br>
        IRS Jovem: O que é isto?<br>
        Primeiro ano de descontos (independente): O que é isto?<br></div>
        <div class="container">
        Morada: <input type="text" name="morada" placeholder="Morada, i.e. Rua, Nº da Porta" value="',$dados["rua"],', ',$dados["numPorta"],'" required><br>
        Localidade: <input type="text" name="localidade" placeholder="Localidade" value="', $dados["localidade"],'" required><br>
        Código Postal: <input type="text" name="codPostal" placeholder="Código Postal (ex: 4320-350)" value="', $dados["codPost"],'" required><br>
        </div>';
        echo '<div class="container">Telemóvel: <input type="text" name="contacto" placeholder="Telemóvel" value="', $dados["contacto"],'" required><br>';
        
        
        echo 'Email: <input type="text" name="email" placeholder="email" value="',$dados["email"],'" readonly required></div>
        <div class="container">IBAN: <input type="text" name="iban" placeholder="IBAN" value="',$dados["iban"],'" required></div><br>
        <div class="container">Contacto de Emergência: <input type="text" name="contactoEmergencia" placeholder="Nome" value="',$dados["contactoEmergencia"],'" required><br>
        Grau de Relacionamento: <input type="text" name="grauRelacionamento" placeholder="Grau de Parentesco" value="',$dados["grauRelacionamento"],'" required><br>
        Contacto: <select
        </div>
        <button type="submit">Login</button>
        </form>';
    }
}