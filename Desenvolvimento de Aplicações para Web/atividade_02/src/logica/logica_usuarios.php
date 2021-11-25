<?php

require_once('../conexao.php');

function salvarSessao($usuario) {
  session_start();
  $_SESSION['logado'] = true;
  $_SESSION['idUsuario'] = $usuario['idusuario'];
  $_SESSION['nome'] = $usuario['nome'];
  $_SESSION['email'] = $usuario['email'];
  $_SESSION['avatar'] = $usuario['foto'];
}

function cadastrarUsuario($conexao,$array) {
  if (count($array) == 4) {
    $queryStr = "INSERT INTO usuarios (nome, email, senha, foto) VALUES (?, ?, ?, ?)";
  } else {
    $queryStr = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
  }

  try {
    $query = $conexao -> prepare($queryStr);
    $resultado = $query -> execute($array);
            
    return $resultado;
  } catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
  }
}

function fazerLogin($conexao, $array) {
  try {
    $query = $conexao -> prepare("SELECT * FROM usuarios WHERE email = ? AND senha = ?");
    if ($query -> execute($array)) {
      $usuario = $query -> fetch();
      if ($usuario) return $usuario;
      else return false;
    } 
    else return false;
  } catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
  }  
}

function upload($imagem, $caminho) {
  $error = array();
  
  // Verificação se é uma imagem
  if (!preg_match('/^image\/(pjpeg|jpeg|png|gif|bmp)$/', $imagem['type'])) {
    $error[1] = 'Isso não é uma imagem.';
  }
      
  if (count($error) == 0) {
  // Pega extensão da imagem
    preg_match('/\.(gif|bmp|png|jpg|jpeg){1}$/i', $imagem['name'], $ext);
          
    // Gera um nome para a imagem
    $nome_imagem = md5(uniqid(time())) . '.' . $ext[1];
          
    // Caminho da imagem
    $caminho_imagem =  '/opt/lampp/htdocs/AW/src/img/'.$caminho.'/' . $nome_imagem;
          
    // Faz o upload da imagem para seu respectivo caminho
    move_uploaded_file($imagem['tmp_name'], $caminho_imagem);
    return $nome_imagem;
  }
}

function verificarEmail($conexao, $array) {
  try {
    $query = $conexao->prepare("SELECT * FROM usuarios WHERE email = ?");
    if ($query -> execute($array)) {
      $usuario = $query -> fetch();
      if ($usuario) return $usuario;
      else return false;
    } else return false;
  }catch(PDOException $e) {
    echo 'Error: ' . $e->getMessage();
  }
}

// Cadastrar usuario

if (isset($_POST['cadastrar'])) {
  $nome = $_POST['nome'];
  $email = $_POST['email'];
  $senha = $_POST['senha'];
  $imagem = $_FILES['imagem'];

  if (!empty($imagem['name'])) {
    $nome_imagem = upload($imagem, 'usuarios');
    $array = array($nome, $email, $senha, $nome_imagem);
  } else {
    $array = array($nome, $email, $senha);
  }

  $emailArray = array($email);
  if (!verificarEmail($conexao, $emailArray)) {
    cadastrarUsuario($conexao, $array);
  }

  $arrayLogin = array($email, $senha);
  $usuario = fazerLogin($conexao, $arrayLogin);

  if ($usuario) {
    salvarSessao($usuario);
    header('location: ../index.php');
  } else {
    header('location: ../cadastro.php');
  }
}

# Fazer login

if (isset($_POST['entrar'])) {
  $email = $_POST['email'];
  $senha = $_POST['senha'];
  $array = array($email, $senha);
  $usuario = fazerLogin($conexao, $array);

  if ($usuario) {
    $_SESSION['erro'] = false;
    salvarSessao($usuario);
    header('location: ../index.php');
  } else {
    session_start();
    $_SESSION['erro'] = true;
    header('location: ../login.php?erro=dadosincorretos');
  }
}

# Encerrar sessão

if (isset($_POST['sair'])) {
  session_start();
  session_destroy();
  header('location:../login.php');
}

?>