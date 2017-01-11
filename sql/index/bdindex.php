<?php
class bdindex{
	
	function bdindex($db)
	{
        $this->db = $db;
	}
	
	/**
	 * Método retorna a uf do usuário logado.
	 * @param unknown $cpf
	 */
	public function retornaOragaoUsuario($seqOrgao)
	{
		$sql = "select org.dsc_orgao,
					   sg.DSC_SIGLA,
					   c.SIG_UF
				from corporativo.orgao org
				join corporativo.sigla_orgao sg on sg.SEQ_ORGAO = org.SEQ_ORGAO
				left join corporativo.cidade c on c.SEQ_CIDADE = org.SEQ_CIDADE
				where org.seq_orgao = '$seqOrgao'";
		$q = $this->db->execute($sql);
		$res = $q->getRows();
		return $res[0];
	}
}	
?>