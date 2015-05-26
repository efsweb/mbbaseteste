<?php
class Model_Geralft{
    
    public function loaddata($idmodelo, $idpg){
        $db     = Zend_Db_Table::getDefaultAdapter();
        $db->query('SET NAMES "utf8"');
        $db->query('SET CHARACTER SET "utf8" ');

        $arr    = array('C', 1, $idmodelo, '', '', '', '', '', '','');
        $return = $db->query("CALL sp_fe_com_mod_ft_ctrl(?,?,?,?,?,?,?,?,?,?)", $arr);
        $result = $return->fetchAll();
        $utils  = new SC_Plugins_Utils();
        $teste = explode('-',$result[0]['data_publicacao_dados']);
        if(isset($teste[1])){
            $result[0]['data_publicacao_dados'] = $utils->dataToSite($result[0]['data_publicacao_dados']);
        }else{
            if($result[0]['data_publicacao_dados'] == '14 de maio de 2015'){
                $result[0]['data_publicacao_dados'] = '14/05/2015';
            }elseif($result[0]['data_publicacao_dados'] == '08 de maio de 2015'){
                $result[0]['data_publicacao_dados'] = '08/05/2015';
            }
        }
        return $result;
    }

    public function atualizar($idmodelo, $complemento, $tracao, $classificacao, $aplicacao, $b09, $data, $nome_arquivo){
        $db     = Zend_Db_Table::getDefaultAdapter();
        $db->query('SET NAMES "utf8"');
        $db->query('SET CHARACTER SET "utf8" ');

        $utils  = new SC_Plugins_Utils();
        $data   = $utils->dataToBd($data);
        $arr    = array('U', 1, $idmodelo, $complemento, $tracao, $classificacao, $aplicacao, $b09, $data, $nome_arquivo);
        $return = $db->query("CALL sp_fe_com_mod_ft_ctrl(?,?,?,?,?,?,?,?,?,?)", $arr);
        $result = $return->fetchAll();
        return $result;
    }

}
