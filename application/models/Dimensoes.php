<?php
class Model_Dimensoes{
    
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

    public function atualizar($idmodelo, $linhas, $pg){
        $db     = Zend_Db_Table::getDefaultAdapter();
        $db->query('SET NAMES "utf8"');
        $db->query('SET CHARACTER SET "utf8" ');
        $arr;
        $return = '';
        $del = array('D',1,$idmodelo,'',$pg, '', '', '', '', '', '', '', '', '', '', '', '');
        $db->query("CALL sp_fe_com_mod_ft_linha(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", $del);

        $db->beginTransaction();
        try{
            for($i = 0; $i < count($linhas);$i++){
                $arr = array('U',1,$idmodelo);
                $pt  = explode(',',$linhas[$i]);
                for($x = 0; $x < 14; $x++){
                    $itm = (isset($pt[$x])) ? $pt[$x] : '';
                    array_push($arr,$itm);
                }
                $db->query("CALL sp_fe_com_mod_ft_linha(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", $arr);
                $arr = '';
            }
            return $db->commit();
        }catch (Exception $e) {
            $db->rollBack();  
        }
    }

}
