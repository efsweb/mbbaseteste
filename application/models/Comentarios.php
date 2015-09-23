<?php
class Model_Comentarios{
    
    public function lista($idmodelo,$sys){
        $db     = Zend_Db_Table::getDefaultAdapter();
        $db->query('SET NAMES "utf8"');
        $db->query('SET CHARACTER SET "utf8" ');
        $arr    = array('C', $sys, $idmodelo, '', '');
        $rows = $db->query("CALL sp_fe_com_mod_ft_coments(?,?,?,?,?)", $arr);
        $return = array();
        foreach($rows as $k => $v){
            $return[] = $v;
        }
        return $return;
    }

    public function atualizar($idmodelo, $c1, $c2, $sys){
        $db     = Zend_Db_Table::getDefaultAdapter();
        $db->query('SET NAMES "utf8"');
        $db->query('SET CHARACTER SET "utf8" ');
        $arr    = array('U', $sys, $idmodelo, $c1, $c2);
        $return = $db->query("CALL sp_fe_com_mod_ft_coments(?,?,?,?,?)", $arr);
        $result = $return->fetchAll();
        return $result;
    }

  }
