<?php
class Model_Sistemaeletrico{
    
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
                $rows[] = $v->bmb_familia;
            }else{
                $rows[$v->bmb_id_modelo] = $v->bmb_desc_modelo;
            }
        }
        if($tipo == 'familia'){
            asort($rows);
        }
        return $rows;
    }


    public function loaddata($idmodelo, $idpg){
        $db     = Zend_Db_Table::getDefaultAdapter();
        $db->query('SET NAMES "utf8"');
        $db->query('SET CHARACTER SET "utf8" ');
        $arr    = array(1, $idmodelo, $idpg,'');
        $return = $db->query("CALL sp_fe_com_consulta_visoes_modelo(?,?,?,?)", $arr);
        $result = $return->fetchAll();
        //$rows   = array();
        /*foreach($result as $k => $v){
            if($k != 'tipo_retorno' && $k != 'msg_retorno'){
                $rows[] = $v->bmb_familia;
            }
        }
        if($tipo == 'familia'){
            asort($rows);
        }*/
        return $result;
    }

    /**
     * Busca lista de Alias do sistema para preencher os itens de ficha técnica
     * @author Eliel Fernandes
     * @date    2015-02-28
     * @version 1.0
     * @return  array [com o resultado da busca]
     */
    public function searchalias($a, $b, $c){
        $db     = Zend_Db_Table::getDefaultAdapter();
        $db->query('SET NAMES "utf8"');
        $db->query('SET CHARACTER SET "utf8" ');
        $arr    = array($a, $b, $c);
        $return = $db->query("CALL sp_fe_com_pesquisa_alias(?,?,?)", $arr);
        $result = $return->fetchAll();
        return $result;
    }
    public function inserir($idmodelo, $idlinha, $colunas, $idlabel, $idvalor1 = '', $idvalor2 = '', $idvalor3 = '', $idvalor4 = '', $idvalor5 = '', $idtipo1 = '', $idtipo2 = '', $idtipo3 = '', $idtipo4 = '', $idtipo5 = '' ){
        $db     = Zend_Db_Table::getDefaultAdapter();
        $db->query('SET NAMES "utf8"');
        $db->query('SET CHARACTER SET "utf8" ');
        $arr    = array('I', 1, $idmodelo, $idlinha, 'mod_ft_sistema_eletrico', $colunas, $idlabel, $idvalor1, $idtipo1, $idvalor2, $idtipo2, $idvalor3, $idtipo3, $idvalor4, $idtipo4, $idvalor5, $idtipo5);
        $return = $db->query("CALL sp_fe_com_modelos_ficha_tecnica(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", $arr);
        $result = $return->fetchAll();
        return $result;
    }

    public function atualizar($idmodelo, $idlinha, $colunas, $idlabel, $idvalor1 = '', $idvalor2 = '', $idvalor3 = '', $idvalor4 = '', $idvalor5 = '', $idtipo1 = '', $idtipo2 = '', $idtipo3 = '', $idtipo4 = '', $idtipo5 = '' ){
        $db     = Zend_Db_Table::getDefaultAdapter();
        $db->query('SET NAMES "utf8"');
        $db->query('SET CHARACTER SET "utf8" ');
        $arr    = array('U', 1, $idmodelo, $idlinha, 'mod_ft_sistema_eletrico', $colunas, $idlabel, $idvalor1, $idtipo1, $idvalor2, $idtipo2, $idvalor3, $idtipo3, $idvalor4, $idtipo4, $idvalor5, $idtipo5);
        $return = $db->query("CALL sp_fe_com_modelos_ficha_tecnica(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", $arr);
        $result = $return->fetchAll();
        return $result;
    }

    public function deletar($idmodelo, $idlinha, $colunas, $idlabel, $idvalor1 = '', $idvalor2 = '', $idvalor3 = '', $idvalor4 = '', $idvalor5 = '', $idtipo1 = '', $idtipo2 = '', $idtipo3 = '', $idtipo4 = '', $idtipo5 = '' ){
        $db     = Zend_Db_Table::getDefaultAdapter();
        $db->query('SET NAMES "utf8"');
        $db->query('SET CHARACTER SET "utf8" ');
        $arr    = array('D', 1, $idmodelo, $idlinha, 'mod_ft_sistema_eletrico', $colunas, $idlabel, $idvalor1, $idtipo1, $idvalor2, $idtipo2, $idvalor3, $idtipo3, $idvalor4, $idtipo4, $idvalor5, $idtipo5);
        $return = $db->query("CALL sp_fe_com_modelos_ficha_tecnica(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", $arr);
        $result = $return->fetchAll();
        return $result;
    }
}
