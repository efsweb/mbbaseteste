<?php
class Model_FichaTecnica{
    
    public function loadData($a, $b, $c){
    	/*
    	$db     = Zend_Db_Table::getDefaultAdapter();
        $db->query('SET NAMES "utf8"');
        $db->query('SET CHARACTER SET "utf8" ');
    	$arr    = array($a, $b, $c);
    	$return = $db->query("CALL sp_fe_com_listas(?,?,?)", $arr);
    	$row    = json_decode($return->fetchAll());
    	
	   	return return $row;*/
	   	return true;
    }

    public function loadinicial($row){
    	$partes = (!is_null($row->coluna8)) ? explode(' - ', $row->coluna8) : '';
		$codigo = (isset($partes[1])) ? $partes[1] : '';
    	$retorno = array(
			'item'			  => $row[0],
			'titulo'		  => ucfirst($row->coluna6),
			'titulo2'		  => ucfirst($row->coluna7),
			'sub'			  => ucfirst($row->coluna10),
			'sub2'			  => ucfirst($row->coluna11),
			'lateral'		  => $row->coluna8,
			'rodape'		  => $row->coluna5,
			'codigo' 		  => $codigo,
			'nome_do_arquivo' => str_replace("_"," ",$row->coluna3)
    	);
    	return $retorno;
    }

    public function dimensoes($rows){
    	foreach($rows as $row){
			if($row->coluna4 == 'cabecalho'){
				$item1 .= $row->coluna6 . ' <span>' . $row->coluna7 . $row->coluna8 . '</span>';
				continue;
			}
			if($dimensoes == ''){
				$dimensoes .= '<tr><td class="item_atributo">' . $row->coluna6 . '</td>';
				$dimensoes .= '<td class="aright"><b>' . $row->coluna7 . '</b></td>';
				$dimensoes .= '<td class="aright"><b>' . $row->coluna8 . '</b></td>';
				$dimensoes .= '<td class="aright"><b>' . $row->coluna9 . '</b></td>';
				$dimensoes .= '<td class="aright"><b>' . $row->coluna10 . '</b></td></tr>';
				continue;
			}
			$dimensoes .= '<tr><td class="item_atributo">' . $row->coluna6 . '</td>';
			$dimensoes .= '<td class="aright">' . $row->coluna7 . '</td>';
			$dimensoes .= '<td class="aright">' . $row->coluna8 . '</td>';
			$dimensoes .= '<td class="aright">' . $row->coluna9 . '</td>';
			$dimensoes .= '<td class="aright">' . $row->coluna10 . '</td></tr>';
		}
    }

}


