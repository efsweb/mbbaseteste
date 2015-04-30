<?php
class Model_ModelosMapper{
    
    public function lista($tipo = 'familia', $item = ''){
    	$db     = Zend_Db_Table::getDefaultAdapter();
        $db->query('SET NAMES "utf8"');
        $db->query('SET CHARACTER SET "utf8" ');
    	$arr    = array('com_modelo_principal_familia', 'load_inicial', $tipo, $item, '', '', '', '');
    	$return = $db->query("CALL sp_fe_com_listas(?,?,?,?,?,?,?,?)", $arr);
    	$result = $return->fetchAll();
    	$rows   = array();
    	foreach($result as $k => $v){
    		if($tipo == 'familia'){
    			$rows[] = $v['bmb_familia'];
    		}else{
    			$rows[$v['bmb_id_modelo']] = $v['bmb_desc_modelo'];
    		}
    	}
    	if($tipo == 'familia'){
	    	asort($rows);
	    }
	   	return $rows;
    }

    public function lista2($tipo = 'familia', $item = ''){
        $db     = Zend_Db_Table::getDefaultAdapter();
        $db->query('SET NAMES "utf8"');
        $db->query('SET CHARACTER SET "utf8" ');
        $arr    = array('com_modelo_principal_familia', 'load_inicial', $tipo, $item, '', '', '', '');
        $return = $db->query("CALL sp_fe_com_listas(?,?,?,?,?,?,?,?)", $arr);
        $result = $return->fetchAll();
        $rows   = array();
        foreach($result as $k => $v){
            if($tipo == 'familia'){
                $rows[] = $v['bmb_familia'];
            }else{
                $rows[$v['bmb_id_modelo']] = $item . ' / ' . $v['bmb_desc_modelo'];
            }
        }
        if($tipo == 'familia'){
            asort($rows);
        }
        return $rows;
    }

    public function visaomodelos($idmodelo, $idpg){
    	$db     = Zend_Db_Table::getDefaultAdapter();
        $db->query('SET NAMES "utf8"');
        $db->query('SET CHARACTER SET "utf8" ');
    	$arr    = array(1, $idmodelo, $idpg,'',0);
    	$return = $db->query("CALL sp_fe_com_consulta_visoes_modelo(?,?,?,?,?)", $arr);
    	$result = $return->fetchAll();
        $db->closeConnection();
	   	return $result;
    }

    /**
     * Busca lista de Alias do sistema para preencher os itens de ficha técnica
     * @author Eliel Fernandes
     * @date    2015-02-28
     * @version 1.0
     * @return  array [com o resultado da busca]
     */
    public function searchalias($a, $b, $c, $d, $e){
        $db     = Zend_Db_Table::getDefaultAdapter();
        $db->query('SET NAMES "utf8"');
        $db->query('SET CHARACTER SET "utf8" ');
        $arr    = array($a, $b, $c, $d, $e);
        $return = $db->query("CALL sp_fe_com_pesquisa_alias(?,?,?,?,?)", $arr);
        $result = $return->fetchAll();
        $db->closeConnection();
        return $result;
    }

    public function savealias($a, $c, $d, $e, $f, $g){
        $db     = Zend_Db_Table::getDefaultAdapter();
        $db->query('SET NAMES "utf8"');
        $db->query('SET CHARACTER SET "utf8" ');
        $arr;
        $idalias= $a;
        $arr    = array('I',1,$a,$c,$d,$e,$f,$g,1);
        if($a != 0){
            $arr= array('U',1,$a,$c,$d,$e,$f,$g,1);
        }
        $return = $db->query("CALL sp_fe_dam_alias(?,?,?,?,?,?,?,?,?)", $arr);
        $result = $return->fetchAll();
        if($a == 0){
            $a = $result[0]['id_alias'];
        }
        $db->closeConnection();
        return $a;//delclasi($a, $b);
    }
    public function delclasi($a){
        $db     = Zend_Db_Table::getDefaultAdapter();
        $db->query('SET NAMES "utf8"');
        $db->query('SET CHARACTER SET "utf8" ');
        $del = array('D', 1, $a, 0);
        $return = $db->query("CALL sp_fe_dam_alias_classificacao(?,?,?,?)", $del);
        $db->closeConnection();
        return $return->fetchAll();
    }
    public function saveclasi($a, $b){
        $db     = Zend_Db_Table::getDefaultAdapter();
        $db->query('SET NAMES "utf8"');
        $db->query('SET CHARACTER SET "utf8" ');
        $db->beginTransaction();
        try{
            for($i = 0; $i < count($b);$i++){
                $cla = array('I', 1, $a, $b[$i]);
                $db->query("CALL sp_fe_dam_alias_classificacao(?,?,?,?)", $cla);
                $cla = '';
            }
            $db->commit();
            $db->closeConnection();
            return $arr;
        }catch (Exception $e) {
           $db->rollBack();
           $db->closeConnection();
        }
    }

    public function loadclassificacao(){
        $db     = Zend_Db_Table::getDefaultAdapter();
        $db->query('SET NAMES "utf8"');
        $db->query('SET CHARACTER SET "utf8" ');
        $arr = array('com_alias_lista_classificacao', '', '', 1, '', '', '', '');
        $return = $db->query("CALL sp_fe_com_listas(?,?,?,?,?,?,?,?)", $arr);
        $result = $return->fetchAll();
        $db->closeConnection();
        return $result;
    }
    public function loaditemengenharia(){
        $db     = Zend_Db_Table::getDefaultAdapter();
        $db->query('SET NAMES "utf8"');
        $db->query('SET CHARACTER SET "utf8" ');
        $arr = array('com_alias_lista_item', '', '', 1, '', '', '', '');
        $return = $db->query("CALL sp_fe_com_listas(?,?,?,?,?,?,?,?)", $arr);
        $result = $return->fetchAll();
        $db->closeConnection();
        return $result;
    }
    public function loadfiltrogrupo(){
        $db     = Zend_Db_Table::getDefaultAdapter();
        $db->query('SET NAMES "utf8"');
        $db->query('SET CHARACTER SET "utf8" ');
        $arr = array('com_alias_ddl_filtro_grupo', '', '', 1, '', '', '', '');
        $return = $db->query("CALL sp_fe_com_listas(?,?,?,?,?,?,?,?)", $arr);
        $result = $return->fetchAll();
        $db->closeConnection();
        return $result;
    }
    public function loadfiltroclassificacao(){
        $db     = Zend_Db_Table::getDefaultAdapter();
        $db->query('SET NAMES "utf8"');
        $db->query('SET CHARACTER SET "utf8" ');
        $arr = array('com_alias_ddl_filtro_classificacao', '', '', 1, '', '', '', '');
        $return = $db->query("CALL sp_fe_com_listas(?,?,?,?,?,?,?,?)", $arr);
        $result = $return->fetchAll();
        $db->closeConnection();
        return $result;
    }
    public function getaliasdata($id){
        $db     = Zend_Db_Table::getDefaultAdapter();
        $db->query('SET NAMES "utf8"');
        $db->query('SET CHARACTER SET "utf8" ');
        $arr    = array('C', 1, $id, '', '','', '', '', '');
        $return = $db->query("CALL sp_fe_dam_alias(?,?,?,?,?,?,?,?,?)", $arr);
        $result = $return->fetchAll();
        $db->closeConnection();
        return $result[0];
    }

}


