<?php
include_once('/opt/lampp/htdocs/AW/src/conexao.php');

function criarCategoria($array) {
  $conexao = fazConexao();
  try {
    $query = $conexao->prepare("INSERT INTO categorias (nomecategoria) VALUES (?)");
    $resultado = $query->execute($array);
    return $resultado;
  } catch(PDOException $e) {
    echo 'Error: ' . $e->getMessage();
  }
}

function getCategorias() {
  $conexao = fazConexao();
  try {
    $query = $conexao->prepare("SELECT * FROM categorias");      
    $query->execute();
    $categorias = $query->fetchAll();
    return $categorias;
  } catch(PDOException $e) {
    echo 'Error: ' . $e->getMessage();
  }  
}

function getCategoriaId($array) {
  $conexao = fazConexao();
  try {
    $query = $conexao->prepare("SELECT * FROM categorias WHERE idcategoria = ?");
    
    if($query->execute($array)){
      $categoria = $query->fetch();
      return $categoria;
    } else return false;
  } catch(PDOException $e) {
    echo 'Error: ' . $e->getMessage();
  }  
}

# Cadastrar categoria

if(isset($_POST['cadastrar'])){
  $nome = $_POST['nome'];
 
  $array = array($nome);

  criarCategoria($array);
  header('location:../index.php');
}

?>