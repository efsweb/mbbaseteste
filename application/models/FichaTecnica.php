<?php
class Model_FichaTecnica{
    
    public function loadData($a, $b, $c){
    	$db     = Zend_Db_Table::getDefaultAdapter();
        $db->query('SET NAMES "utf8"');
        $db->query('SET CHARACTER SET "utf8" ');
    	$arr    = array($a, $b, $c);
    	$return = $db->query("CALL sp_fe_com_mod_ft_print(?,?,?)", $arr);
        $rows   = $return->fetchAll();
        $row    = array();
        foreach($rows as $key => $value){
            $line = '';
            foreach($value as $k => $v){
                $line[$k] = ($v == '0') ? '' : $v;
            }
            $row[$key] = $line;
        }
	   	return $row;
    }
}


