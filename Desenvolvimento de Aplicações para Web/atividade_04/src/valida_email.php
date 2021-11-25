<?php

include('/opt/lampp/htdocs/AW/src/logica/funcoes_db.php');

if($_GET['token']) {
	session_start();

	$token=$_GET['token'];

	$array = array($token);

	$query ='SELECT * FROM usuarios WHERE md5(email) = ?';

	$usuario = select($query, $array);

	if ($usuario) {
		$array = array($usuario['idusuario']);

		$query ='UPDATE usuarios SET status=true WHERE idusuario = ?';

		$retorno = consulta($query, $array);
		
		if($retorno) {
      $_SESSION['msg'] = 'Cadastro Validado - Entre com seu email e senha';
		} else {
			$_SESSION['msg'] = 'Problema na validação';
		}
	} else {
		$_SESSION['msg'] = 'Problema na validação';
	}	

header('Location: login.php');
	
}
