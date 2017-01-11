<?php
/**
 * Classe Raiz do sistema
 */
class util
{
	/**
	 * Método construtor da classe
	 * @param object $db
	 * @param object $smarty
	 */
	public function util($smarty)
	{
		$this->smarty = $smarty;
	}
	
	/**
	 * Método tira os espaços caso tenha cido digitado erradamente.
	 * @param unknown_type $tela
	 * @param unknown_type $ehNumero
	 * @return string|unknown
	 */
	public function converterTelaBanco($tela) {
		if (trim($tela) == "") {
			return 'NULL';
		} else {
			if (is_numeric($tela)) {
				return $tela;
			} else {
				return "'".trim($tela)."'";
			}
		}
	}
	
	/**
	 * Método converte o cpf que foi digitado para o sql
	 * @param unknown_type $tela
	 * @return string
	 */
	function converterCpfBanco($tela)
	{
		if($tela){
			$quebra=explode(".", $tela);
			$quebra2=explode("-", $quebra[2]);
			return $quebra[0].$quebra[1].$quebra2[0].$quebra2[1];
		}else{
			return 'NULL';
		}
	}
	
	/**
	 * Método converte o telefone que foi digitado para o sql
	 * @param unknown_type $tela
	 * @return string
	 */
	public function coverterTelefoneBanco($tela)
	{
		if($tela){
			$quebra=explode("(", $tela);
			$quebra2=explode(")", $quebra[1]);
			$quebra3=explode("-", trim($quebra2[1]));
			return $quebra2[0].$quebra3[0].$quebra3[1];
		}else{
			return 'NULL';
		}
	}
	
	/**
	 * Método converte a data que foi digitada para o sql
	 * @param unknown_type $tela
	 */
	public function converterDataParaBanco($tela)
	{
		if($tela){
			$data = implode("-",array_reverse(explode("/",$tela)));
			return "'".trim($data)."'";
		}else{
			return 'NULL';
		}
	}
	
	/**
	 * Método converte o cep que foi digitada para o sql
	 * @param unknown_type $tela
	 */
	public function converterCepParaBanco($tela)
	{
		if($tela){
			$quebra1 = explode(".", $tela);
			$quebra2 = explode("-", $quebra1[1]);
			return "'".$quebra1[0].$quebra2[0].$quebra2[1]."'";
		}else{
			return 'NULL';
		}
	}
	
	/**
	 * Mètodo retorna o tipo do arquivo.
	 * @param unknown $nomeArquivo
	 * @return string
	 */
	public function retornarTipoDocumento($nomeArquivo)
	{
		$tipo = explode(".",$nomeArquivo);
		$tipo = $tipo[(sizeof($tipo)-1)];
		return $tipo;
	}
	
	/**
	 * Método para montar os dados do membro.
	 * @param unknown $param
	 */
	public function montarMembro($param)
	{
		if(!empty($param['NOM_PESSOA']) && !empty($param['NOM_PESSOA']) && !empty($param['NOM_PESSOA'])){
			foreach ($param['NOM_PESSOA'] as $key => $value) {
				$membro[$key]['NOM_PESSOA'] = $value;
			}
			
			foreach ($param['NUM_TELEFONE_PESSOA'] as $key => $value) {
				$membro[$key]['NUM_TELEFONE_PESSOA'] = $value;
			}
			
			foreach ($param['DSC_EMAIL_PESSOA'] as $key => $value) {
				$membro[$key]['DSC_EMAIL_PESSOA'] = $value;
			}
			return $membro;
		}else{
			return NULL;
		}
	}
	
	/**
	 * Método para montar os dados do agressor.
	 * @param unknown $param
	 */
	public function montarAgressor($param)
	{
		if(!empty($param['SEQ_AGRESSOR'])){
			foreach ($param['SEQ_AGRESSOR'] as $key => $value) {
				$agressor[$key]['SEQ_AGRESSOR'] = $value;
			}
		}
			
		foreach ($param['NUM_CPF_AGRESSOR'] as $key => $value) {
			$agressor[$key]['NUM_CPF_AGRESSOR'] = $value;
		}
		
		foreach ($param['NOM_AGRESSOR'] as $key => $value) {
			$agressor[$key]['NOM_AGRESSOR'] = $value;
		}
		
		foreach ($param['DAT_NASCIMENTO_AGRESSOR'] as $key => $value) {
			$agressor[$key]['DAT_NASCIMENTO_AGRESSOR'] = $value;
		}
		
		foreach ($param['NOM_MAE_AGRESSOR'] as $key => $value) {
			$agressor[$key]['NOM_MAE_AGRESSOR'] = $value;
		}
		
		foreach ($param['DSC_ENDERECO'] as $key => $value) {
			$agressor[$key]['DSC_ENDERECO'] = $value;
		}
		
		foreach ($param['DSC_COMPLEMENTO_ENDERECO'] as $key => $value) {
			$agressor[$key]['DSC_COMPLEMENTO_ENDERECO'] = $value;
		}
		
		foreach ($param['DSC_BAIRRO_ENDERECO'] as $key => $value) {
			$agressor[$key]['DSC_BAIRRO_ENDERECO'] = $value;
		}
		
		foreach ($param['NUM_TELEFONE_AGRESSOR'] as $key => $value) {
			$agressor[$key]['NUM_TELEFONE_AGRESSOR'] = $value;
		}
		
		foreach ($param['NUM_CEP'] as $key => $value) {
			$agressor[$key]['NUM_CEP'] = $value;
		}
		
		foreach ($param['SEQ_CIDADE'] as $key => $value) {
			$agressor[$key]['SEQ_CIDADE'] = $value;
		}
		
		foreach ($param['DSC_ANTECEDENTES'] as $key => $value) {
			$agressor[$key]['DSC_ANTECEDENTES'] = $value;
		}
		
		foreach ($_FILES['DSC_URL_FOTO_AGRESSOR']['name'] as $value) {
			if(!empty($value)){
				$temArquivo = true;
			}
		}
		
		if(!empty($temArquivo)){
			foreach ($_FILES['DSC_URL_FOTO_AGRESSOR']['name'] as $key => $value) {
				$agressor[$key]['DSC_URL_FOTO_AGRESSOR']['name'] = $value;
			}
		}

		if(!empty($temArquivo)){
			foreach ($_FILES['DSC_URL_FOTO_AGRESSOR']['tmp_name'] as $key => $value) {
				$agressor[$key]['DSC_URL_FOTO_AGRESSOR']['tmp_name'] = $value;
			}
		}
		return $agressor;
	}
}
?>