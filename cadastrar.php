<?php
require_once 'classes/Menu.class.php';
require_once 'classes/Funcoes.class.php';

$objFcn = new Menu();
$objFcs = new Funcoes();

if(isset($_POST['btCadastrar'])){
    if($objFcn->queryInsert($_POST) == 'ok'){
        header('location: /codingtest/cadastrar.php');
    }else{
        echo '<script type="text/javascript">alert("Erro em cadastrar");</script>';
    }
}
if(isset($_POST['btAlterar'])){
    if($objFcn->queryUpdate($_POST) == 'ok'){
        header('location: ?acao=edit&func='.$objFcs->base64($_POST['func'],1));
    }else{
        echo '<script type="text/javascript">alert("Erro em alterar");</script>';
    }
}
if(isset($_GET['acao'])){
    switch($_GET['acao']){
        case 'edit': $func = $objFcn->querySeleciona($_GET['func']); break;
        case 'delet':
            if($objFcn->queryDelete($_GET['func']) == 'ok'){
                header('location: /codingtest/cadastrar.php');
            }else{
                echo '<script type="text/javascript">alert("Erro em deletar");</script>';
            }
                break;
    }
} 
?>
<!DOCTYPE HTML>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<title>Cadastro de Categorias</title>
	<link href="css/estilo.css" rel="stylesheet" type="text/css" media="all">
        
</head>
<body>

    <p>
        <a class="btn btn-lg btn-primary" href="index.php" role="button"> Home</a> |
        <a class="btn btn-lg btn-primary" href="cadastrar.php" role="button"> Cadastrar </a>
    </p>
<div id="lista">
    <?php foreach($objFcn->querySelect() as $rst){ ?>
    <div class="funcionario">
        <div class="nome"><?=$objFcs->tratarCaracter($rst['descricao'], 2)?></div>
        <div class="editar"><a href="?acao=edit&func=<?=$objFcs->base64($rst['id'], 1)?>" title="Editar dados"><img src="img/ico-editar.png" width="16" height="16" alt="Editar"></a></div>
        <div class="excluir"><a href="?acao=delet&func=<?=$rst['id']?>" title="Excluir esse dado"><img src="img/ico-excluir.png" width="16" height="16" alt="Excluir"></a></div>
    </div>
    </br>
    <?php } ?>
</div>

<div id="formulario">
    <form name="formCad" action="" method="post">
        <label>Descrição: </label><br> 
        <input type="text" name="descricao" class="form-control" placeholder="Categoria" required="required" value="<?=$objFcs->tratarCaracter((isset($func['descricao']))?($func['descricao']):(''), 2)?>"><br>
        <br>
        <label>Categoria Pai: </label><br>
        <select class="form-control" name="id">
            <option value="">-- Selecionar --</option>
            <?php foreach($objFcn->querySelectPai() as $rst){ ?>            
            <option value="<?=$rst['id']?>"><?=$objFcs->tratarCaracter($rst['descricao'], 2)?></option>
            <?php } ?>
        </select>        
        <br><br>
        <input type="submit" name="<?=(isset($_GET['acao']) == 'edit')?('btAlterar'):('btCadastrar')?>" value="<?=(isset($_GET['acao']) == 'edit')?('Alterar'):('Cadastrar')?>">
        <input type="hidden" name="func" value="<?=(isset($func['id']))?($func['id']):('')?>">            
    </form>
</div>
    
 
 
</body>
</html>