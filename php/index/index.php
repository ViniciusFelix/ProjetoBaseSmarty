<?php
class index{
   	
	function index($db, $smarty){	
        $this->db = $db;
		$this->smarty = $smarty;
		
		include_once("bibliotecas/security_token/index.php");
		$this->token = new token();
		
		include_once("sql/index/bdindex.php");
		$this->sql = new bdindex($db);		
	}
	
	function logado()
	{		
		$_SESSION['usuarioAcesso']['seqUsuario']  = $_POST['Credencial']->usuario->getSeqUsuario();
		$_SESSION['usuarioAcesso']['nomUsuario']  = $_POST['Credencial']->usuario->getNomUsuario();
		$orgao 	  								  = $this->sql->retornaOragaoUsuario($_POST['Credencial']->usuario->getSeqOrgao());
		$_SESSION['usuarioAcesso']['orgao']		  = $orgao['dsc_orgao'];
		
		$parametros['a'] = 'processo';
		$parametros['d'] = 'processo';
		$parametros['f'] = 'pesquisarProcesso';
		$parametros['token'] = $_SESSION['token'];
		$this->token->redirect($parametros);
	}
	
	function formPrincipal()
	{
		permissao($_POST);
	}
	
	function sair()
	{
		session_unset();
		session_destroy();
		die ("<script>document.location.href='//titaniod01.cnj.jus.br/corporativo/index.php'</script>");
	}
}
?>
