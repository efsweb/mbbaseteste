<?php

class Model_WA{
	public function loaddata($idmodelo, $idpg, $sys){
        $db     = Zend_Db_Table::getDefaultAdapter();
        $arr    = array($sys,$idmodelo, 'mod_wa_load', "''", "''");
        $return = $db->query("CALL mbase_prod.sp_fe_com_consulta_visoes_modelo(?,?,?,?,?)", $arr);
        $result = $return->fetchAll();
        return $result;	
	}

    /**
     * Deleta todas as referencias dos pontos antes de salvar os dados
     * Criado por: Eliel Fernandes
     * Criado em: 21/07/2015
     * Versão: 1.0.0
     */
    public function deletar($id,$sys){
        $db     = Zend_Db_Table::getDefaultAdapter();
        $db->query('SET NAMES "utf8"');
        $db->query('SET CHARACTER SET "utf8" ');

        $db->beginTransaction();
        try{
            $del = array('D',$sys,$id,'',0,'','',0,0,0,'');
            $db->query("CALL sp_fe_com_mod_wa_linha(?,?,?,?,?,?,?,?,?,?,?)", $del);
            return $db->commit();
        }catch (Exception $e) {
            $db->rollBack();  
        }
        
    }

    /**
     * Função que grava os dados no banco
     * Criado por: Mike Oliveira
     * Atualizada por: Eliel Fernandes
     * Atualizada em: 21/07/2015
     * Versão 1.0.1
     */
	public function atualizar($idmodelo,$linhas,$sys){
        $db     = Zend_Db_Table::getDefaultAdapter();
        $db->query('SET NAMES "utf8"');
        $db->query('SET CHARACTER SET "utf8" ');
        $ret;
        $db->beginTransaction();
        try{
            for($i = 0; $i < count($linhas);$i++){
                $id = $i + 1;
                $arr = array('I',$sys,$idmodelo);
                for($x = 0; $x < 7; $x++){
                    $itm = (isset($linhas[$i][$x])) ? $linhas[$i][$x] : 0;
                    array_push($arr,$itm);
                    if($x == 0){
                        array_push($arr,$id);
                    }
                }
                $db->query("CALL sp_fe_com_mod_wa_linha(?,?,?,?,?,?,?,?,?,?,?)", $arr);
                $arr = '';
            }
            return $db->commit();
        }catch (Exception $e) {
            $db->rollBack();  
        }
	}

}