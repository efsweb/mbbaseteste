<?php
class Model_Comparativos{
    
    public function loadinicial($idmodelo){
        $db     = Zend_Db_Table::getDefaultAdapter();
        $db->query('SET NAMES "utf8"');
        $db->query('SET CHARACTER SET "utf8" ');
        $arr = array('com_conc_ddl_selecao', '', '', '1', $idmodelo, '', '', '');
        $return = $db->query("CALL sp_fe_com_listas(?,?,?,?,?,?,?,?)", $arr);
        $rows = $return->fetchAll();
        $result = array();
        foreach($rows as $row){
            array_push($result, array($row['bmb_id_conc_modelo'],$row['png_logo_marca'],$row['desc_modelo']));
        }
        return $result;
    }

    public function loaddados($idmodelo, $idconcorrente){
        $db     = Zend_Db_Table::getDefaultAdapter();
        $db->query('SET NAMES "utf8"');
        $db->query('SET CHARACTER SET "utf8" ');
        $arr = array(1, $idmodelo, 'mod_cp_geral', '',$idconcorrente);
        $return = $db->query("CALL sp_fe_com_consulta_visoes_modelo(?,?,?,?,?)", $arr);
        $rows = $return->fetchAll();

        $cabina      = array();
        $motor       = array();
        $seletrico   = array();
        $cambio      = array();
        $embreagem   = array();
        $etraseiro   = array();
        $pneus       = array();
        $freios      = array();
        $retardador  = array();
        $sdianteira  = array();
        $straseira   = array();
        $chassis     = array();
        $capacidades = array();
        $garantia    = array();

        foreach($rows as $row){
            switch ($row['id_agrupamento']) {
                case 'mod_cp_cabina':
                    array_push($cabina, array(
                        $row['bmb_nr_linha'],
                        $row['cod_item'],
                        $row['item'],
                        $row['cod_desc_item_mb'],
                        $row['desc_item_mb'],
                        $row['cod_id_desc_item_conc'],
                        $row['desc_item_conc'],
                        $row['cod_id_argumento_vendas'],
                        $row['desc_argumento_vendas'])
                    );
                    break;
                case 'mod_cp_motor':
                    array_push($motor,array(
                        $row['bmb_nr_linha'],
                        $row['cod_item'],
                        $row['item'],
                        $row['cod_desc_item_mb'],
                        $row['desc_item_mb'],
                        $row['cod_id_desc_item_conc'],
                        $row['desc_item_conc'],
                        $row['cod_id_argumento_vendas'],
                        $row['desc_argumento_vendas'])
                    );
                    break;
                case 'mod_cp_sistema_eletrico':
                    array_push($seletrico, array(
                        $row['bmb_nr_linha'],
                        $row['cod_item'],
                        $row['item'],
                        $row['cod_desc_item_mb'],
                        $row['desc_item_mb'],
                        $row['cod_id_desc_item_conc'],
                        $row['desc_item_conc'],
                        $row['cod_id_argumento_vendas'],
                        $row['desc_argumento_vendas'])
                    );
                    break;
                case 'mod_cp_cambio':
                    array_push($cambio, array(
                        $row['bmb_nr_linha'],
                        $row['cod_item'],
                        $row['item'],
                        $row['cod_desc_item_mb'],
                        $row['desc_item_mb'],
                        $row['cod_id_desc_item_conc'],
                        $row['desc_item_conc'],
                        $row['cod_id_argumento_vendas'],
                        $row['desc_argumento_vendas'])
                    );
                    break;
                case 'mod_cp_embreagem':
                    array_push($embreagem, array(
                        $row['bmb_nr_linha'],
                        $row['cod_item'],
                        $row['item'],
                        $row['cod_desc_item_mb'],
                        $row['desc_item_mb'],
                        $row['cod_id_desc_item_conc'],
                        $row['desc_item_conc'],
                        $row['cod_id_argumento_vendas'],
                        $row['desc_argumento_vendas'])
                    );
                    break;
                case 'mod_cp_eixo_traseiro':
                    array_push($etraseiro, array(
                        $row['bmb_nr_linha'],
                        $row['cod_item'],
                        $row['item'],
                        $row['cod_desc_item_mb'],
                        $row['desc_item_mb'],
                        $row['cod_id_desc_item_conc'],
                        $row['desc_item_conc'],
                        $row['cod_id_argumento_vendas'],
                        $row['desc_argumento_vendas'])
                    );
                    break;
                case 'mod_cp_pneus':
                    array_push($pneus, array(
                        $row['bmb_nr_linha'],
                        $row['cod_item'],
                        $row['item'],
                        $row['cod_desc_item_mb'],
                        $row['desc_item_mb'],
                        $row['cod_id_desc_item_conc'],
                        $row['desc_item_conc'],
                        $row['cod_id_argumento_vendas'],
                        $row['desc_argumento_vendas'])
                    );
                    break;
                case 'mod_cp_freios':
                    array_push($freios, array(
                        $row['bmb_nr_linha'],
                        $row['cod_item'],
                        $row['item'],
                        $row['cod_desc_item_mb'],
                        $row['desc_item_mb'],
                        $row['cod_id_desc_item_conc'],
                        $row['desc_item_conc'],
                        $row['cod_id_argumento_vendas'],
                        $row['desc_argumento_vendas'])
                    );
                    break;
                case 'mod_cp_retardador':
                    array_push($retardador, array(
                        $row['bmb_nr_linha'],
                        $row['cod_item'],
                        $row['item'],
                        $row['cod_desc_item_mb'],
                        $row['desc_item_mb'],
                        $row['cod_id_desc_item_conc'],
                        $row['desc_item_conc'],
                        $row['cod_id_argumento_vendas'],
                        $row['desc_argumento_vendas'])
                    );
                    break;
                case 'mod_cp_suspensao_dianteira':
                    array_push($sdianteira, array(
                        $row['bmb_nr_linha'],
                        $row['cod_item'],
                        $row['item'],
                        $row['cod_desc_item_mb'],
                        $row['desc_item_mb'],
                        $row['cod_id_desc_item_conc'],
                        $row['desc_item_conc'],
                        $row['cod_id_argumento_vendas'],
                        $row['desc_argumento_vendas'])
                    );
                    break;
                case 'mod_cp_suspensao_traseira':
                    array_push($straseira, array(
                        $row['bmb_nr_linha'],
                        $row['cod_item'],
                        $row['item'],
                        $row['cod_desc_item_mb'],
                        $row['desc_item_mb'],
                        $row['cod_id_desc_item_conc'],
                        $row['desc_item_conc'],
                        $row['cod_id_argumento_vendas'],
                        $row['desc_argumento_vendas'])
                    );
                    break;
                case 'mod_cp_chassis':
                    array_push($chassis, array(
                        $row['bmb_nr_linha'],
                        $row['cod_item'],
                        $row['item'],
                        $row['cod_desc_item_mb'],
                        $row['desc_item_mb'],
                        $row['cod_id_desc_item_conc'],
                        $row['desc_item_conc'],
                        $row['cod_id_argumento_vendas'],
                        $row['desc_argumento_vendas'])
                    );
                    break;
                case 'mod_cp_capacidades':
                    array_push($capacidades, array(
                        $row['bmb_nr_linha'],
                        $row['cod_item'],
                        $row['item'],
                        $row['cod_desc_item_mb'],
                        $row['desc_item_mb'],
                        $row['cod_id_desc_item_conc'],
                        $row['desc_item_conc'],
                        $row['cod_id_argumento_vendas'],
                        $row['desc_argumento_vendas'])
                    );
                    break;
                case 'mod_cp_garantia':
                    array_push($garantia, array(
                        $row['bmb_nr_linha'],
                        $row['cod_item'],
                        $row['item'],
                        $row['cod_desc_item_mb'],
                        $row['desc_item_mb'],
                        $row['cod_id_desc_item_conc'],
                        $row['desc_item_conc'],
                        $row['cod_id_argumento_vendas'],
                        $row['desc_argumento_vendas'])
                    );
                    break;
                
                default:
                    break;
            }
        }
        $myarr = array(
            'cabina'      => $cabina,
            'motor'       => $motor,
            'seletrico'   => $seletrico,
            'cambio'      => $cambio,
            'embreagem'   => $embreagem,
            'etraseiro'   => $etraseiro,
            'pneus'       => $pneus,
            'freios'      => $freios,
            'retardador'  => $retardador,
            'sdianteira'  => $sdianteira,
            'straseira'   => $straseira,
            'chassis'     => $chassis,
            'capacidades' => $capacidades,
            'garantia'    => $garantia
        );
        return $myarr;
    }

    public function clearBeforeSave($idmodelo, $idcp, $idpg){
        $db     = Zend_Db_Table::getDefaultAdapter();
        $db->query('SET NAMES "utf8"');
        $db->query('SET CHARACTER SET "utf8" ');
        $arr;
        $return = '';
        $del = array('D',1,$idmodelo,$idcp,$idpg, '', '', '', '', '');
        $return = $db->query("CALL sp_fe_com_mod_cp_geral(?,?,?,?,?,?,?,?,?,?)", $del);
        return $return->fetchAll();
    }
    public function addConcorrenteLine($idmodelo, $idcp, $linhas){
        $db     = Zend_Db_Table::getDefaultAdapter();
        $db->query('SET NAMES "utf8"');
        $db->query('SET CHARACTER SET "utf8" ');
        $arr;
        $return = '';
        $db->beginTransaction();
        try{
            for($i = 0; $i < count($linhas);$i++){
                $arr = array('I',1,$idmodelo);
                $pt  = explode(',',$linhas[$i]);
                for($x = 0; $x < 7; $x++){
                    $itm = (isset($pt[$x])) ? $pt[$x] : '';
                    array_push($arr,$itm);
                }
                $db->query("CALL sp_fe_com_mod_cp_geral(?,?,?,?,?,?,?,?,?,?)", $arr);
                $arr = '';
            }
            //return count($linhas) . '<br>';
            return $db->commit();
        }catch (Exception $e){
            $db->rollBack();  
        }
    }

}


