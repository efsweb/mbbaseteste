<?php
class Model_Comentarios{
    
    public function lista($idmodelo){
        $db     = Zend_Db_Table::getDefaultAdapter();
        $db->query('SET NAMES "utf8"');
        $db->query('SET CHARACTER SET "utf8" ');
        $arr    = array('C', 1, $idmodelo, '', '');
        $return = $db->query("CALL sp_fe_com_mod_ft_coments(?,?,?,?,?)", $arr);
        $result = $return->fetchAll();
        return $result;
    }

    public function atualizar($idmodelo, $c1, $c2){
        $db     = Zend_Db_Table::getDefaultAdapter();
        $db->query('SET NAMES "utf8"');
        $db->query('SET CHARACTER SET "utf8" ');
        $arr    = array('U', 1, $idmodelo, $c1, $c2);
        $return = $db->query("CALL sp_fe_com_mod_ft_coments(?,?,?,?,?)", $arr);
        $result = $return->fetchAll();
        return $result;
    }

  }
