<?php
class Model_Geralft{
    
    public function loaddata($idmodelo, $idpg){
        $db     = Zend_Db_Table::getDefaultAdapter();
        $db->query('SET NAMES "utf8"');
        $db->query('SET CHARACTER SET "utf8" ');

        $arr    = array('C', 1, $idmodelo, '', '', '', '', '', '');
        $return = $db->query("CALL sp_fe_com_mod_ft_ctrl(?,?,?,?,?,?,?,?,?)", $arr);
        $result = $return->fetchAll();
        $utils  = new SC_Plugins_Utils();
        $result[0]['data_publicacao_dados'] = $utils->dataToSite($result[0]['data_publicacao_dados']);
        return $result;
    }

    public function atualizar($idmodelo, $complemento, $tracao, $classificacao, $aplicacao, $b09, $data){
        $db     = Zend_Db_Table::getDefaultAdapter();
        $db->query('SET NAMES "utf8"');
        $db->query('SET CHARACTER SET "utf8" ');

        $utils  = new SC_Plugins_Utils();
        $data   = $utils->dataToBd($data);
        $arr    = array('U', 1, $idmodelo, $complemento, $tracao, $classificacao, $aplicacao, $b09, $data);
        $return = $db->query("CALL sp_fe_com_mod_ft_ctrl(?,?,?,?,?,?,?,?,?)", $arr);
        $result = $return->fetchAll();
        return $result;
    }

}
