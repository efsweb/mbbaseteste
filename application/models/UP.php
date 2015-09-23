<?php
class Model_UP{
    
    public function loadinicial($idmodelo, $pg, $idsys){
        $db     = Zend_Db_Table::getDefaultAdapter();
        $db->query('SET NAMES "utf8"');
        $db->query('SET CHARACTER SET "utf8" ');
        $arr = array($idsys, $idmodelo, $pg, 0,0);
        $return = $db->query("CALL sp_fe_com_consulta_visoes_modelo(?,?,?,?,?)", $arr);
        return $return->fetchAll();
    }

    public function loadinicialitem($idmodelo, $pg, $idsys){
        $db     = Zend_Db_Table::getDefaultAdapter();
        $db->query('SET NAMES "utf8"');
        $db->query('SET CHARACTER SET "utf8" ');
        $arr = array($idsys, $idmodelo, $pg, 0,0);
        $return = $db->query("CALL sp_fe_com_consulta_visoes_modelo(?,?,?,?,?)", $arr);
        $rows   = $return->fetchAll();
        $baum   = array();
        $item   = array();
        $items  = array();
        foreach($rows as $row){
            $cod = $row['cod_alias_item'];
            $baumuster = $row['baumuster'];
            if(!isset($items[$baumuster][$cod][0])){
                $items[$baumuster][$cod][0][0] = $row['alias_item'];
                $up = $row['up'];
                $items[$baumuster][$cod][0][$up] = array(
                    $row['ativo'],
                    $row['classificacao_lista_completa'],
                    $row['classificacao_lista_resumida'],
                    $row['variante']
                );
            }else{
                $up = $row['up'];
                $items[$baumuster][$cod][0][$up] = array(
                    $row['ativo'],
                    $row['classificacao_lista_completa'],
                    $row['classificacao_lista_resumida'],
                    $row['variante']
                );
            }
        }
        return $items;
    }


    public function clearBeforeSave($idmodelo, $idsys){
        $db     = Zend_Db_Table::getDefaultAdapter();
        $db->query('SET NAMES "utf8"');
        $db->query('SET CHARACTER SET "utf8" ');
        $arr;
        $return = '';
        $del = array('D',$idsys,$idmodelo,'','', '', '', '', '', '', '', '');
        $deleted = $db->query("CALL sp_fe_com_mod_up_ctrl(?,?,?,?,?,?,?,?,?,?,?,?)", $del);
        return $deleted->fetchAll();
    }
    public function savegeral($idmodelo,$rows, $idsys){
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->query('SET NAMES "utf8"');
        $db->query('SET CHARACTER SET "utf8"');
        $arr;
        $lines = array();
        $db->beginTransaction();
        try{
            for($i = 0; $i < count($rows); $i++){
                $arr = array('I',$idsys,$idmodelo);
                $pt  = explode(',',$rows[$i]);
                for($x = 0; $x < 9; $x++){
                    if($pt[$x] == 'Nao Aplicado'){
                        $pt[$x] = '0';
                    }
                    $itm = (isset($pt[$x])) ? $pt[$x] : '0';
                    array_push($arr,$itm);
                }
                //$lines[] = $arr;
                $db->query("CALL sp_fe_com_mod_up_ctrl(?,?,?,?,?,?,?,?,?,?,?,?)", $arr);
                $arr = '';
            }
            //return $lines;
            return $db->commit();
        }catch (Exception $e){
            $db->rollBack();
            return $e->getMessage();
        }
    }

    public function clearItemBeforeSave($idmodelo, $idsys){
        $db     = Zend_Db_Table::getDefaultAdapter();
        $db->query('SET NAMES "utf8"');
        $db->query('SET CHARACTER SET "utf8" ');
        $arr;
        $return = '';
        $del = array('D',$idsys,$idmodelo,'','', '', '', '', '', '');
        $deleted = $db->query("CALL sp_fe_com_mod_up_linha(?,?,?,?,?,?,?,?,?,?)", $del);
        return $deleted->fetchAll();
    }
    public function saveItem($id,$linhas, $idsys){
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->query('SET NAMES "utf8"');
        $db->query('SET CHARACTER SET "utf8"');
        $arr;
        $lines = array();
        $db->beginTransaction();
        try{
            foreach($linhas as $row){
                $col = explode('##',$row);
                $pad = explode(',', $col[0]); //Produz 2 itens baumuster e id do item
                for($i=1;$i<count($col);$i++){
                    $a = explode(',',$col[$i]);
                    $b = array('I',$idsys,$id,$pad[0],$a[3],$a[0],$pad[1],$a[1],$a[2],'S');
                    $db->query("CALL sp_fe_com_mod_up_linha(?,?,?,?,?,?,?,?,?,?)", $b);
                    //$lines[] = $b;
                }
            }
            //return $lines;
            return $db->commit();
        }catch (Exception $e){
            $db->rollBack();
            return $e->getMessage();
        }
    }

}


