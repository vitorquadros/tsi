<?php
include_once('../conexao.php');

function cadastrarProduto($conexao, $array) {
  try {
    $query = $conexao->prepare("INSERT INTO produtos (nome, descricao, quantidade, idcategoria) VALUES (?, ?, ?, ?)");
    $resultado = $query->execute($array);
    return $resultado;
  } catch(PDOException $e) {
    echo 'Error: ' . $e->getMessage();
  }
}

function pesquisarProdutosComCategoria($conexao, $array) {
  try {
    $query = $conexao->prepare("SELECT * FROM produtos INNER JOIN categorias
    ON produtos.idcategoria = categorias.idcategoria WHERE nome LIKE ?");
 
    if ($query->execute($array)) {
      $produtos = $query->fetchAll();
      return $produtos;
    } else return false;
  } catch(PDOException $e) {
    echo 'Error: ' . $e->getMessage();
  }
}

function getProdutosComCategoria($conexao) {
  try {
    $query = $conexao->prepare("SELECT * FROM produtos INNER JOIN categorias
    ON produtos.idcategoria = categorias.idcategoria");
 
    if ($query->execute($array)) {
      $produtos = $query->fetchAll();
      return $produtos;
    } else return false;
  } catch(PDOException $e) {
    echo 'Error: ' . $e->getMessage();
  }
}

if (isset($_POST['cadastrar'])) {
  $nome = $_POST['nome'];
  $descricao = $_POST['descricao'];
  $quantidade = $_POST['quantidade'];
  $idCategoria = $_POST['idcategoria'];

  $array = array($nome, $descricao, $quantidade, $idCategoria);

  cadastrarProduto($conexao, $array);
  header('location:../index.php');
}

if (isset($_GET['pesquisar'])) {
  session_start();
  $nome = $_GET['nome'];
  $_SESSION['nomeProdutoPesquisar'] = '%'.$nome.'%';
  header('location:../index.php');
}

?>