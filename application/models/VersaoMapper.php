<?php
class Model_VersaoMapper{
    /**
     * Lista as versões disponíveis no sistema
     * @since  14/08/2015
     * @author  Eliel Fernandes
     * @version  1.0.0
     */
    public function loadversao(){
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->query('SET NAMES "utf8"');
        $db->query('SET CHARACTER SET "utf8" ');
        $arr  = array('C','','','');
        $ans  = $db->query("CALL sp_fe_com_versoes(?,?,?,?)", $arr);
        $rows = array();
        foreach($ans->fetchAll() as $row){
            $id = $row['bmb_id_sys'];
            $am = $row['bmb_sys_ambiente'];
            $vs = $row['bmb_sys_versao'];
            $rows[] = array($id, $vs, $am);
        }
        return $rows;
    }
}
