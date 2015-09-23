<?php
class Model_FTMapper{
    
    /**
     * Busca lista de Alias do sistema para preencher os itens de ficha técnica
     * @author  Eliel Fernandes
     * @date    28/02/2015
     * @version 1.0.0
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

    /**
     * Função que atualiza a base de dados das fichas técnicas
     * Criada por: Eliel Fernandes
     * Atualizada em: 03/08/2015
     * Versão: 1.1.0
     * 
     */
    public function atualizar($idmodelo, $linhas, $pg, $sys){
        $db     = Zend_Db_Table::getDefaultAdapter();
        $db->query('SET NAMES "utf8"');
        $db->query('SET CHARACTER SET "utf8" ');
        $arr;
        $return = '';
        $del = array('D',$sys,$idmodelo,'',$pg, '', '', '', '', '', '', '', '', '', '', '', '', '');
        $db->query("CALL sp_fe_com_mod_ft_linha(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", $del);

        $db->beginTransaction();
        try{
            for($i = 0; $i < count($linhas);$i++){
                $arr = array('U',$sys,$idmodelo);
                $pt  = explode(',',$linhas[$i]);
                for($x = 0; $x < 15; $x++){
                    $itm = (isset($pt[$x])) ? $pt[$x] : '';
                    array_push($arr,$itm);
                }
                $db->query("CALL sp_fe_com_mod_ft_linha(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", $arr);
                $arr = '';
            }
            return $db->commit();
        }catch (Exception $e) {
            $db->rollBack();  
        }
    }

    /**
     * Função que tras os dados dos rodapés
     * @author  Eliel Fernandes
     * @since  20/08/2015
     * @version  1.0.0
     */
    public function loadfooter($sys,$modelo){
        $ld = array('C',$sys,$modelo,0,0,0);
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->query('SET NAMES "utf8"');
        $db->query('SET CHARACTER SET "utf8" ');
        $rt = $db->query("CALL sp_fe_com_rodapes_ctrl(?,?,?,?,?,?)", $ld);
        return $rt->fetchAll();
    }

}
