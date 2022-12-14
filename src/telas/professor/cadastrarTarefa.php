<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel='stylesheet' href='/site/public/styles/cadastro.css'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>

<?php
    include "../../conexao/conexao.php";

    session_start();

    $id = $_SESSION["id"];

    $comandoTurma = "select id, nome from turma";
    $resulTurma = mysqli_query($con, $comandoTurma);

    while ($dadosTurma = mysqli_fetch_assoc($resulTurma)) {
        $turmas[$dadosTurma["id"]] = $dadosTurma["nome"];
    }

    $comandoTurmaProf = "select Tp.id_turma from professor as P
                    inner join turma_professor as Tp on P.id = Tp.id_professor
                    inner join turma as T on T.id = Tp.id_turma
                    where P.id = $id";

    $resulTurmaProf = mysqli_query($con, $comandoTurmaProf);

    while ($dadosTurmaProf = mysqli_fetch_assoc($resulTurmaProf)) {
        $turmaProf[] = $dadosTurmaProf["id_turma"];
    }

    $comandoMateria = "select id, nome from materia";
    $resulMateria = mysqli_query($con, $comandoMateria);

    while ($dadosMateria = mysqli_fetch_assoc($resulMateria)) {
        $materias[$dadosMateria["id"]] = $dadosMateria["nome"];
    }

    $comandoMateriaProf = "select Mp.id_materia from professor as P
                    inner join materia_professor as Mp on P.id = Mp.id_professor
                    inner join materia as M on M.id = Mp.id_materia
                    where P.id = $id";

    $resulMateriaProf = mysqli_query($con, $comandoMateriaProf);

    while ($dadosMateriaProf = mysqli_fetch_assoc($resulMateriaProf)) {
        $materiaProf[] = $dadosMateriaProf["id_materia"];
    }

    $dia_mes = date('d');
    $mes = date('m');
    $ano = date('Y');

    $data_atual = "$ano-$mes-$dia_mes";
?>

    <center>
    <img src="/site/public/arquivos/img/logo.png">
    <br>
    <h1>Cadastro de Tarefas</h1>
    <center>
<div class="login">

<form name="fcadastro" id="fcadastro" action="/site/src/conexao/cadastroTarefa.php?data=<?=$data_atual?>" method="POST" enctype="multipart/form-data">

    <label for="user">Nome da Tarefa</label>
    <input class="btn btn-light" type="text" name="user" id="user">

    <br><br>

    <label for="descricao">Descri????o</label>
    <textarea class="form-control" aria-label="With textarea" type="text" name="descricao" id="descricao" style="resize: none"></textarea>

    <br>
    
    <label for="inputArquivo">Arquivo</label>
    <div class="botaoArquivo btn btn-light">Selecionar arquivo...</div>
    <input type="file" id="inputArquivo" name="inputArquivo">

    <br><br>

    <label for="dataF">Data Finaliza????o</label>
    <input class="btn btn-light" type="date" name="dataF" id="dataF">

    <br><br>

    <label id="labelTurma">Turma</label>
    <select class="btn btn-light" style="width:207px;" name="turma" id="turma">
        <?php 
        foreach($turmas as $id => $turma){
            if(in_array($id, $turmaProf)){
                echo "<option value='$id'>$turma</option>";
            }
        }
        ?>
    </select>

    <br><br>

    <label id="labelGrade">grade Curricular</label>
    <select class="btn btn-light" style="width:207px;" name="grade" id="grade">
    <?php 
        foreach($materias as $id => $materia){
            if(in_array($id, $materiaProf)){
                echo "<option value='$id'>$materia</option>";
            }
        }
    ?>
    </select>      
    
    <br><br>

    <input class="btn btn-info" type="submit" value="Cadastrar">

</form> 

<script type="text/javascript">
    var div = document.getElementsByClassName("botaoArquivo")[0];
    var input = document.getElementById("inputArquivo");

    div.addEventListener("click", function(){
        input.click();
    });
    input.addEventListener("change", function(){
        var nome = "N??o h?? arquivo selecionado. Selecionar arquivo...";
        if(input.files.length > 0) nome = input.files[0].name;
        div.innerHTML = nome;
    });
</script>

</div>
    
</body>
</html>