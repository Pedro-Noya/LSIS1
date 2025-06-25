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
        Nome Completo: <input type="text" name="nome" placeholder="Nome Completo" value="',$dados["nome"],'" readonly><br>
        Nome Abreviado: <input type="text" name="nomeAbreviado" placeholder="ex: António Silva" value="',$dados["nomeAbreviado"],'"readonly><br>
        Data de Nascimento: <input type="date" name="dataNascimento" value="',$dados["dataNascimento"],'" readonly><br>
        Número de Identificação Fiscal: <input type="text" name="nif" placeholder="NIF" value="',$dados["nif"],'" readonly><br>
        Número de Segurança Social: <input type="text" name="niss" placeholder="NISS" value="',$dados["niss"],'" readonly><br>
        Número Cartão de Cidadão: <input type="text" name="cc" placeholder="CC" value="',$dados["cc"],'" readonly><br>';

        $genero_array=["M","F"];
        #É correr o array genero_array e ver em qual indice o valor do genero é igual ao genero do colaborador em questão.
        echo 'Sexo: <select name="genero>"';
        foreach ($genero_array as $genero){
            if($genero==$dados["genero"]){
                echo '<option value="',$genero,'" selected>',$genero,'</option>';
            }
            echo '<option value="',$genero,'">',$genero,'</option>';
        }
        echo '</select><br>';
        echo 'Nacionalidade: <input type="text" name="nacionalidade" placeholder="Nacionalidade" value="',$dados["nacionalidade"],'" readonly><br>
        Situação IRS: <select name="situacaoIrs"><option value="',$dados["situacaoIrs"],'">',$dados["situacaoIrs"],'</option></select><br>
        Dependentes: <input type="text" name="numDependentes" placeholder="Número de Dependentes" value="',$dados["numDependentes"],'"><br>
        IRS Jovem: O que é isto?<br>
        Primeiro ano de descontos (independente): O que é isto?<br>
        Morada: <input type="text" name="morada" placeholer="Morada, i.e. Rua, Nº da Porta" value="',$dados["rua"],', ',$dados["numPorta"],'"><br>
        Localidade: <input type="text" name="localidade" placeholder="Localidade" value="', $dados["localidade"],'"><br>
        Código Postal: <input type="text" name="codPostal" placeholder="Código Postal (ex: 4320-350)" value="', $dados["codPost"],'"><br>
        Telemóvel: <input type="text" name="contacto" placeholder="Telemóvel" value="', $dados["contacto"],'"><br>
        Email: <input type="text" name="email" placeholder="email" value="',$dados["email"],'" readonly><br>
        IBAN: <input type="text" name="iban" placeholder="IBAN" value="',$dados["iban"],'"><br>
        Contacto de Emergência: <input type="text" name="contactoEmergencia" placeholder="Nome" value="',$dados["contactoEmergencia"],'"><br>
        Grau de Relacionamento: <input type="text" name="grauRelacionamento" placeholder="Grau de Parentesco" value="',$dados["grauRelacionamento"],'"><br>

        <button type="submit">Login</button>
        </form>';
    }
}