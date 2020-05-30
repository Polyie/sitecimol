<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./styles/style.css" />
    <title>Calculador de Salário Líquido</title>
</head>

<body>

<?php

if(isset($_POST['cadastrar'])):


    $nome = $_POST['nome_completo'];
    if(!is_string($nome)){ 
        echo "<h2>Nome preenchido errado!</h2>";      
    }

    $salario = $_POST['salario'];
    if(!is_numeric($salario)){
        echo "<h2>Salario Invalido!</h2>";       
    }

    if(is_numeric($salario) && is_string($nome)){
                $criarArquivo = fopen("cadastro.txt", "a+");

                $info = "$nome |";
                $info .= "$salario|\n";

                $escrever = fwrite($criarArquivo,$info);
                echo "<h2>Envio realizado com sucesso!</h2>";
                echo "<h2>Desça a pagina para ver o salario</h2>";

                fclose($criarArquivo);
            }
        
endif;
?>

<h1 id="topo">Cadastro de Salário</h1>


<form id="cadastro" method="POST" enctype="multipart/form-data">

<label class="titulos" for="nomeCompleto">Nome:</label><br>
<input class="campos" type="text" required="required" name="nome_completo" pattern="^[^-\s][a-zA-ZÀ-ú ]*"><br>

<label class="titulos" for="salarioBruto">Salário Bruto:</label><br>
<input class="campos" type="number" required="required" name="salario" step="any" min="0" ><br>

    <div id="botao">
<input class="envio"type="submit" name="cadastrar">
    </div>
</form>



<div id="registro" >
<table  id="tabela">
<tr class="tabelinha">
    <td class="bloco">Nome Completo</td>
    <td class="bloco">Salário Bruto</td>
    <td class="bloco">Desconto de INSS</td>
    <td class="bloco">Desconto do IRRF</td>
    <td class="bloco">Salário Líquido</td>
</tr>

<?php
    if(!file_exists('cadastro.txt')){  
        }
    else{
        $arquivo = fopen('cadastro.txt', 'r+');
        while(!feof($arquivo)){
            $user = fgets($arquivo, 1024);
            if ($user==null) break;

             $dado = explode("|",$user);

        $nome = $dado["0"];
        $salario = $dado["1"];
       // echo "$salario<br>";
       // echo $nome;
        


        
        if($salario <= 1045 ){
            $inss = $salario * 0.075;
        }
        else if($salario >= 1045.01 && $salario <=2089.60 ){
            $inss = ($salario * 0.09) - 15.67;
        }
        else if($salario >= 2089.61 && $salario <=3134.40 ){
            $inss = ($salario * 0.12) - 78.36;
        }
        else if($salario >= 3134.41 && $salario <=6101.06 ){
            $inss = ($salario * 0.14) - 141.05;
        }
        else{
            $inss = 713.10;
        }

        $salarioinss = $salario - $inss;

        if($salarioinss  <= 1903.98 ){
            $descontoirrf = 0;
        }
        else if($salarioinss >= 1903.99 && $salarioinss  <=2826.65 ){
            $descontoirrf = ($salarioinss * 0.075) - 142.80;
        }
        else if($salarioinss  >= 2826.66 && $salarioinss  <=3751.05 ){
            $descontoirrf = ($salarioinss  * 0.15) - 354.80;
        }
        else if($salarioinss  >= 3751.06 && $salarioinss  <=4664.68 ){
            $descontoirrf = ($salarioinss  * 0.225) - 636.13;
        }
        else{
            $descontoirrf = ($salarioinss  * 0.275) - 869.36;
        }

        // ARREDONDAR VARIÁVEIS //
        $salario = number_format($salario, 2, ',', '');
        $salarioLiq = $salarioinss - $descontoirrf;
        $salarioLiq = number_format($salarioLiq, 2, ',', '');
        $inss = number_format($inss, 2, ',', '');
        $descontoirrf = number_format($descontoirrf, 2, ',', '');

        echo "<tr class='tabelinha'>
        <td class='bloco'>". $nome ."</td>
        <td class='bloco'> R$ ". $salario ."</td>
        <td class='bloco'> R$ ". $inss ."</td>
        <td class='bloco'> R$ ". $descontoirrf ."</td>
        <td class='bloco'> R$ ". $salarioLiq ."</td>
        </tr>";

        }
        
        fclose($arquivo);
    }
        



?>
</table>
</div>

</body>
</html>


