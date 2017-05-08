<?php
include_once "Conexao.class.php";
include_once "Funcoes.class.php";
class Menu {
    
    private $con;
    private $objfc;
    private $id;
    private $idSuperior;
    private $descricao;
    
    public function __construct(){
        $this->con = new Conexao();
        $this->objfc = new Funcoes();
    }
    
    public function __set($atributo, $valor){
        $this->$atributo = $valor;
    }
    public function __get($atributo){
        return $this->$atributo;
    }
    
    public function querySeleciona($dado){
        try{
            $this->id = $this->objfc->base64($dado, 2);
            $cst = $this->con->conectar()->prepare("SELECT `id`, `menu_id_superior`, `descricao` FROM `menus` WHERE `id` = :idFunc;");
            $cst->bindParam(":idFunc", $this->id, PDO::PARAM_INT);
            $cst->execute();
            return $cst->fetch();
        } catch (PDOException $ex) {
            return 'error '.$ex->getMessage();
        }
    }
    
    public function querySelect(){
        try{
            $cst = $this->con->conectar()->prepare("SELECT `id`, `menu_id_superior`, `descricao` FROM `menus`;");
            $cst->execute();
            return $cst->fetchAll();
        } catch (PDOException $ex) {
            return 'erro '.$ex->getMessage();
        }
    }

    public function querySelectPai(){
        try{
            $cst = $this->con->conectar()->prepare("SELECT `id`, `menu_id_superior`, `descricao` FROM `menus` WHERE `menu_id_superior` IS NULL;");
            $cst->execute();
            return $cst->fetchAll();
        } catch (PDOException $ex) {
            return 'erro '.$ex->getMessage();
        }
    }  

    public function querySelectFilho($dado){
        try{
            $cst = $this->con->conectar()->prepare("SELECT `id`, `menu_id_superior`, `descricao` FROM `menus` WHERE `menu_id_superior` = $dado;");
            $cst->execute();
            return $cst->fetchAll();
            
        } catch (PDOException $ex) {
            return 'erro '.$ex->getMessage();
        }
    }

    public function queryInsert($dados){
        try{
            $this->idSuperior = $dados['id'];
            $this->descricao = $this->objfc->tratarCaracter($dados['descricao'], 1);
            var_dump($dados);
            //break;
            $cst = $this->con->conectar()->prepare("INSERT INTO `menus` (`menu_id_superior`, `descricao`) VALUES (:idSuperior, :descricao);");
            $cst->bindParam(":idSuperior", $this->idSuperior, PDO::PARAM_INT);
            $cst->bindParam(":descricao", $this->descricao, PDO::PARAM_STR);
            if($cst->execute()){
                return 'ok';
            }else{
                return 'erro';
            }
        } catch (PDOException $ex) {
            return 'error '.$ex->getMessage();
        }
    }
    
    public function queryUpdate($dados){
        try{
            $this->id = $dados['func'];
            $this->idSuperior = $dados['idSuperior'];
            $this->descricao = $this->objfc->tratarCaracter($dados['descricao'], 1);
            $cst = $this->con->conectar()->prepare("UPDATE `menus` SET  `menu_id_superior` = :idSuperior, `descricao` = :descricao WHERE `id` = :idFunc;");
            $cst->bindParam(":idFunc", $this->id, PDO::PARAM_INT);
            $cst->bindParam(":idSuperior", $this->idSuperior, PDO::PARAM_INT);
            $cst->bindParam(":descricao", $this->descricao, PDO::PARAM_STR);
            if($cst->execute()){
                return 'ok';
            }else{
                return 'erro';
            }
        } catch (PDOException $ex) {
            return 'error '.$ex->getMessage();
        }
    }
    
    public function queryDelete($dado){
        try{
            $this->id = $dado;
            $cst = $this->con->conectar()->prepare("DELETE FROM `menus` WHERE `id` = :idFunc;");
            $cst->bindParam(":idFunc", $this->id, PDO::PARAM_INT);
            if($cst->execute()){
                return 'ok';
            }else{
                return 'erro';
            }
        } catch (PDOException $ex) {
            return 'error'.$ex->getMessage();
        }
    }
    
}
?>