<?php
require_once 'classes/Menu.class.php';
require_once 'classes/Funcoes.class.php';

$objFcn = new Menu();
$objFcs = new Funcoes();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Menu dinâmico com submenus em PHP</title>

    <link href="css/estilo.css" rel="stylesheet" type="text/css" media="all">

</head>
<body>

<p><a class="btn btn-lg btn-primary" href="cadastrar.php" role="button">Cadastrar &raquo;</a></p> 
    
<div>
<ul id="menu">

    <?php foreach($objFcn->querySelectPai() as $rst){ ?>
    <li class="parent"><a href="#"><?=$objFcs->tratarCaracter($rst['descricao'], 2)?></a>
        <ul class="child">
            <?php foreach($objFcn->querySelectFilho($rst['id']) as $rst2){ ?>
            <li><a href="#"><?=$objFcs->tratarCaracter($rst2['descricao'], 2)?></a></li>                
            <?php } ?>       
        </ul>                
    </li>
    <?php } ?>

</ul>

</div>

</body>
</html>