<?php
session_start();
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Content-Type: text/html; charset=iso-8859-1"); 
ini_set("default_charset", "iso-8859-1");
setlocale(LC_CTYPE, "pt_BR");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// incluindo os arquivos de conexao ao banco de dados
require_once("config.php");
require_once("dbConnect.php");
require_once("bibliotecas/security_token/index.php");
$token = new token();

include("credencialcorporativo/Credencial.php");
if(!empty($_GET['c'])){
	$aux = $_GET['c'];
	$credencial = new Credencial($aux);
	$result = $credencial->authenticate();

	$_POST['Credencial'] = $result;
}

// configura��o do smarty
require 'bibliotecas/smarty/libs/Smarty.class.php';
$smarty = new Smarty;

function smarty_block_dynamic($param, $content, &$smarty) {
    return $content;
}

$smarty->compile_dir = "./html/tmp";
$smarty->caching = false;
$smarty->cache_lifetime = 86400;
$smarty->allow_php_tag = true;
$smarty->allow_php_templates = true;
$smarty->clear_all_cache();
$smarty->register_block('dynamic', 'smarty_block_dynamic', false);

$smarty->template_dir = dirname(__FILE__) . '/html/'.isset($cf["html"]).'/';

// Buscando o seq do usu�rio
//$seq_usuario	= $_SESSION['seq_usuario'.$_POST['dsc_sistema_sigla']];

// criando as variaveis, atribuindo $_GET para uma $var apenas para nao ficar usando o $_GET toda hora
$d = isset($_REQUEST["d"])?$_REQUEST["d"]:$_POST["d"];
$a = isset($_REQUEST["a"])?$_REQUEST["a"]:$_POST["a"];
$f = isset($_REQUEST["f"])?$_REQUEST["f"]:$_POST["f"];

// adicionando as variaveis globais para usar nos templates
$smarty->assign('globals',$GLOBALS);

// se nao estiver com as variaveis requeridas, ele redireciona
if(!$d && !$a && !$f){
	require_once('redirect.php');//die("<script>document.location.href='?d=usuario&a=usuario&f=formLogar';</script>");
}

// incluindo o arquivo que contem a classe/negocio
require dirname(__FILE__) . '/php/'.$d.'/'.$a.'.php';

// arquivo de template possui o seguinte formato: arquivo_funcao.html e fica em: visao/$cf["html"]/diretorio($d)/arquivo($a)_funcao($f).html
$template = $d."/".$a."_".$f.".html";

// instanciando a classe, o $template eh utilizado apenas pelo prototype
$instancia = new $a($db, $smarty, $template);

// chamando a funcao
$funcao = $instancia->$f($db, $smarty);

// atribuindo dados para serem utilizados no smarty
$smarty->assign('funcao',$funcao);
$smarty->assign('d',$d);
$smarty->assign('a',$a);
$smarty->assign('f',$f);
$smarty->assign('template',$template);

//Modelo de utiliza��o do modelo padr�o para templates dos sitemas do CNJ
//Inclui o caminho do arquivo "librarycnj/libs/bootstrap/modelo1/html/head.php"
include("bootstrap/modelo1/ModeloControle.php");
$documento = new ModeloControle();

//Define os atributos do template padr�o
$documento->setAtributo('titulo','Cadastro de Ju�zes Amea�ados');
$documento->setAtributo('usuarioLogado', $_SESSION['usuarioAcesso']['nomUsuario']);
$documento->setAtributo('orgaoLogado',$_SESSION['usuarioAcesso']['orgao']);
$documento->setAtributo('sair','wiOpen(\'?d=index&a=index&f=sair\')');
$documento->setCss('html/js/jquery/themes/base/jquery.ui.all.css');
$documento->setCss('html/css/estilos.css');
$documento->setJs('html/js/page.js');
$documento->setJs('html/js/script.js');
$documento->setJs('html/js/mascaraGenerica.js');
$documento->setJs('html/js/jquery/jquery.dataTables.js');
$documento->setJs('html/js/multifile-master/jquery.MultiFile.js');

$documento->setAtributo('montaJSHead',false);

$documento->dispatchCabecalho();

include("html/menu/menu.php");
$documento->dispatchMenu($menu, 'default');

$smarty->display('padrao.html');

$documento->dispatchRodape();

// Funcoes de seguranca do sistema
function limpaSessao(){	
	session_unset();
	session_destroy();
}

function permissao($x){
	if(isset($x['token']) || isset($x['security_token']) == isset($_SESSION['token'])){
		if(isset($_REQUEST['a']) && isset($_REQUEST['d']) && isset($_REQUEST['f']) && isset($_SESSION['usuarioAcesso'])){			
			session_cache_expire(120);
		}else{
			limpaSessao();
			require_once('redirect.php');
			exit;
		}
	}else{
		limpaSessao();		
		require_once('redirect.php');
		exit;
	}
}
?>