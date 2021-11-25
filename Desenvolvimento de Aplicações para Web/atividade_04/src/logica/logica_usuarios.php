<?php

include('/opt/lampp/htdocs/AW/src/logica/mail/envia_email.php');
include('/opt/lampp/htdocs/AW/src/logica/funcoes_db.php');

// FUNCTIONS

function salvarSessao($usuario) {
  session_start();
  $_SESSION['logado'] = true;
  $_SESSION['idUsuario'] = $usuario['idusuario'];
  $_SESSION['nome'] = $usuario['nome'];
  $_SESSION['email'] = $usuario['email'];
  $_SESSION['avatar'] = $usuario['foto'];
}

function cadastrarUsuario($array) {
  if (count($array) == 8) {
    $queryStr = "INSERT INTO usuarios (nome, email, senha, cep, logradouro, bairro, cidade, foto) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
  } else {
    $queryStr = "INSERT INTO usuarios (nome, email, senha, cep, logradouro, bairro, cidade) VALUES (?, ?, ?, ?, ?, ?, ?)";
  }

  $conexao = fazConexao();

  try {
    $query = $conexao -> prepare($queryStr);
    $resultado = $query -> execute($array);
            
    return $resultado;
  } catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
  }
}


function fazerLogin($array) {
  $conexao = fazConexao();
  try {
    $query = $conexao -> prepare("SELECT * FROM usuarios WHERE email = ?");
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

function verificarEmail($array) {
  $conexao = fazConexao();
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

function handleEmail($email, $nome) {
  $hash=md5($email);
  $link="<a href='http://localhost/AW/src/valida_email.php?token=".$hash."'> Clique aqui para confirmar seu cadastro </a>";
  $mensagem="<tr><td style='padding: 10px 0 10px 0;' align='center' bgcolor='#669999'>";

  $mensagem.="Email de Confirmação <br>".$link."</td></tr>";
  $assunto="Confirme seu cadastro";

  return enviarEmail($email, $nome, $mensagem, $assunto);
}


// FORM CONTROL

// Cadastrar usuario

if (isset($_POST['cadastrar'])) {
  session_start();

  $nome = $_POST['nome'];
  $email = $_POST['email'];
  $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

  $cep = $_POST['cep'];
  $logradouro = $_POST['logradouro'];
  $bairro = $_POST['bairro'];
  $cidade = $_POST['cidade'];

  $imagem = $_FILES['imagem'];

  if (!empty($imagem['name'])) {
    $nome_imagem = upload($imagem, 'usuarios');
    $array = array($nome, $email, $senha, $cep, $logradouro, $bairro, $cidade, $nome_imagem);
  } else {
    $array = array($nome, $email, $senha, $cep, $logradouro, $bairro, $cidade);
  }

  $emailArray = array($email);
  if (!verificarEmail($emailArray)) {
    cadastrarUsuario($array);
  }

  $retorno = handleEmail($email, $nome);

  if ($retorno) $_SESSION['msg'] = 'Um email foi enviado para confirmar seu cadastro';

  $query ='SELECT * FROM usuarios WHERE idusuario = ?';
  $usuario = select($query, array($_SESSION['idusuario']));
  $_SESSION['idusuario'] = $usuario['idusuario'];

  header('location: ../login.php');


  // if ($usuario) {
  //   salvarSessao($usuario);
  //   header('location: ../login.php');
  // } else {
  //   header('location: ../cadastro.php');
  // }
}

# Fazer login

if (isset($_POST['entrar'])) {
  $email = $_POST['email'];
  $senha = $_POST['senha'];
  $array = array($email);
  $usuario = fazerLogin($array);

  if ($usuario) {
    if (!$usuario['status']) {
      session_start();
      $_SESSION['erro'] = true;
      header('location: ../login.php?erro=naoverificado');
    } else if (!password_verify($senha, $usuario['senha'])) {
      session_start();
      $_SESSION['erro'] = true;
      header('location: ../login.php?erro=dadosincorretos');
    } else {
      $_SESSION['erro'] = false;
      salvarSessao($usuario);
      header('location: ../index.php');
    }
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