<?php
class Modelos_PdfController extends Zend_Controller_Action{
	
	public function init(){
		Zend_Layout::resetMvcInstance();
        $this->_helper->viewRenderer->setNoRender(true);
    }
    public function indexAction(){
    	$pgid = 'mod_ft_geral';
        $modeloid = new Zend_Session_Namespace('modeloselecionado');
        $mdid = $this->_getParam('id', $modeloid->id);
        $idsys= 1;
        if($mdid != $modeloid->id){
            $modeloid->id = $mdid;
        }
        $versao = '';
        $content  = file_get_contents('modelos_ficha/modelo_grafica.html');
		if($versao == 'imprimir')
			$content  = file_get_contents('modelos_ficha/modelo_pdf.html');
		if($versao == 'jpg')
			$content  = file_get_contents('modelos_ficha/modelo_jpg.html');

        /*
		Lista de variaveis que serão usadas para gerar a ficha
		 */
		$nome_do_arquivo = ''; //Nome do arquivo que deverá ser retornado
		$titulo    	  	= '';
		$titulo2   	  	= '';
		$sub 	      	= '';
		$sub2	    	= '';
		$lateral   	  	= '';
		$rodape    	  	= '';
		$img       	  	= '';
		$img2      	  	= '';
		$nota	      	= '';
		$dimensoes 	  	= '';
		$pesos     	  	= '';
		$cabina    	  	= '';
		$motor 		  	= '';
		$sistema   	  	= '';
		$trans     	  	= '';
		$eixo      	  	= '';
		$chassi    	  	= '';
		$desem     	  	= '';
		$freios    	  	= '';
		$item1     	  	= '';
		$item2     	  	= '';
		$item3     	  	= '';
		$item4     	  	= '';
		$item5     	  	= '';
		$item6     	  	= '';
		$item7     	  	= '';
		$item8     	  	= '';
		$item9     	  	= '';
		$item10    	  	= '';
		$item11    	  	= '';
		$obs_chassi	  	= 0;
		$caixa 	      	= '';

        $tipos  = array(0 => 'load_inicial', 1 => 'mod_ft_dimensoes', 2 => 'mod_ft_pesos', 3 => 'mod_ft_pesos_adminissiveis', 4 => 'mod_ft_cabina', 5 => 'mod_ft_motor', 6 => 'mod_ft_sistema eletrico', 7 => 'mod_ft_transmissao', 8 => 'mod_ft_eixos', 9 => 'mod_ft_chassis', 10 => 'mod_ft_desempenho', 11 => 'mod_ft_freios', 12 => 'mod_ft_comentarios', 13 => 'mod_ft_caixa_transferencia');

        foreach($tipos as $key => $value){
        	if($value == 'mod_ft_pesos_adminissiveis'){continue;}

        	$ficha = new Model_FichaTecnica();
        	$item  = $ficha->loadData($idsys,$modeloid->id,$value);
        	switch ($value){
				case 'load_inicial':
					$item    = $item[0];
					$titulo  = ucfirst($item['coluna6']);
					$titulo2 = ucfirst($item['coluna7']);
					$sub 	 = ucfirst($item['coluna10']);
					$sub2	 = ucfirst($item['coluna11']);
					$lateral = $item['coluna8'];
					$rodape  = $item['coluna5'];
					$partes = (!is_null($lateral)) ? explode(' - ', $lateral) : '';
					$codigo = (isset($partes[1])) ? $partes[1] : '';
					$nome_do_arquivo = str_replace("_"," ",$item['coluna3']);
					if($versao == 'jpg')
						$nome_do_arquivo = strtolower($item['coluna1']) . '_' . $item['coluna2'];
					break;
				case 'mod_ft_dimensoes':
					foreach($item as $row){
						if($row['coluna4'] == 'cabecalho'){
							$item1 .= $row['coluna6'] . ' <span>' . $row['coluna7'] . $row['coluna8'] . '</span>';
							continue;
						}
						if($dimensoes == ''){
							$dimensoes .= '<tr><td class="item_atributo">' . $row['coluna6'] . '</td>';
							$dimensoes .= '<td class="aright"><b>' . $row['coluna7'] . '</b></td>';
							$dimensoes .= '<td class="aright"><b>' . $row['coluna8'] . '</b></td>';
							$dimensoes .= '<td class="aright"><b>' . $row['coluna9'] . '</b></td>';
							$dimensoes .= '<td class="aright"><b>' . $row['coluna10'] . '</b></td></tr>';
							continue;
						}
						$dimensoes .= '<tr><td class="item_atributo">' . $row['coluna6'] . '</td>';
						$dimensoes .= '<td class="aright">' . $row['coluna7'] . '</td>';
						$dimensoes .= '<td class="aright">' . $row['coluna8'] . '</td>';
						$dimensoes .= '<td class="aright">' . $row['coluna9'] . '</td>';
						$dimensoes .= '<td class="aright">' . $row['coluna10'] . '</td></tr>';
					}
					break;
				case 'mod_ft_pesos':
					$admissiveis = $ficha->loadData($idsys,$modeloid->id,'mod_ft_pesos_adminissiveis');
					$total_adm = count($admissiveis);
					$total_pes = count($item);
					$final = ($total_adm >= $total_pes) ? $total_adm : $total_pes;
					for($i=0;$i < $final; $i++){
						if(isset($item[$i]['coluna4']) && $item[$i]['coluna4'] == 'cabecalho'){
							$item2 .= $item[$i]['coluna6'] . ' <span>' . $item[$i]['coluna7'] . $item[$i]['coluna8'] . '</span>';
							$item3 .= $admissiveis[$i]['coluna6'] . ' <span>' . $admissiveis[$i]['coluna7'] . $admissiveis[$i]['coluna8'] . '</span>';
							continue;
						}
						if($pesos == ''){
							$pesos .= '<tr><td class="item_atributo">';
							$pesos .= ((isset($item[$i]['coluna6'])) ? trim($item[$i]['coluna6']) : '');
							$pesos .= '</td><td class="aright"><b>';
							$pesos .= ((isset($item[$i]['coluna7'])) ? trim($item[$i]['coluna7']) : '');
							$pesos .= '</b></td><td class="aright"><b>';
							$pesos .= ((isset($item[$i]['coluna8'])) ? trim($item[$i]['coluna8']) : '');
							$pesos .= '</b></td><td class="aright"><b>';
							$pesos .= ((isset($item[$i]['coluna9'])) ? trim($item[$i]['coluna9']) : '');
							$pesos .= '</b></td><td class="aright"><b>';
							$pesos .= ((isset($item[$i]['coluna10'])) ? trim($item[$i]['coluna10']) : '');
							$pesos .= '</b></td><td class="pesos_separator">&nbsp;</td>';
							$pesos .= '<td class="item_atributo">';
							$pesos .= ((isset($admissiveis[$i]['coluna6'])) ? trim($admissiveis[$i]['coluna6']) : '') . '</td>';
							$pesos .= '<td class="aright"><b>';
							$pesos .= ((isset($admissiveis[$i]['coluna7'])) ? trim($admissiveis[$i]['coluna7']) : '') . '</b></td>';
							$pesos .= '<td class="aright"><b>';
							$pesos .= ((isset($admissiveis[$i]['coluna8'])) ? trim($admissiveis[$i]['coluna8']) : '') . '</b></td>';
							$pesos .= '<td class="aright"><b>';
							$pesos .= ((isset($admissiveis[$i]['coluna9'])) ? trim($admissiveis[$i]['coluna9']) : '') . '</b></td>';
							$pesos .= '<td class="aright"><b>';
							$pesos .= ((isset($admissiveis[$i]['coluna10'])) ? trim($admissiveis[$i]['coluna10']) : '') . '</b></td></tr>';
							continue;
						}
						$pesos .= '<tr><td class="item_atributo">';
						$pesos .= ((isset($item[$i]['coluna6'])) ? trim($item[$i]['coluna6']) : '');
						$pesos .= '</td><td class="aright">';
						$pesos .= ((isset($item[$i]['coluna7'])) ? trim($item[$i]['coluna7']) : '');
						$pesos .= '</td><td class="aright">';
						$pesos .= ((isset($item[$i]['coluna8'])) ? trim($item[$i]['coluna8']) : '');
						$pesos .= '</td><td class="aright">';
						$pesos .= ((isset($item[$i]['coluna9'])) ? trim($item[$i]['coluna9']) : '');
						$pesos .= '</td><td class="aright">';
						$pesos .= ((isset($item[$i]['coluna10'])) ? trim($item[$i]['coluna10']) : '');
						$pesos .= '</td><td class="pesos_separator">&nbsp;</td>';
						$pesos .= '<td class="item_atributo">';
						$pesos .= ((isset($admissiveis[$i]['coluna6'])) ? trim($admissiveis[$i]['coluna6']) : '') . '</td>';
						$pesos .= '<td class="aright">';
						$pesos .= ((isset($admissiveis[$i]['coluna7'])) ? trim($admissiveis[$i]['coluna7']) : '') . '</td>';
						$pesos .= '<td class="aright">';
						$pesos .= ((isset($admissiveis[$i]['coluna8'])) ? trim($admissiveis[$i]['coluna8']) : '') . '</td>';
						$pesos .= '<td class="aright">';
						$pesos .= ((isset($admissiveis[$i]['coluna9'])) ? trim($admissiveis[$i]['coluna9']) : '') . '</td>';
						$pesos .= '<td class="aright">';
						$pesos .= ((isset($admissiveis[$i]['coluna10'])) ? trim($admissiveis[$i]['coluna10']) : '') . '</td></tr>';
					}
					//echo $pesos;
					break;
				case 'mod_ft_comentarios':
					foreach($item as $row){
						$nota .= $row['coluna6'] . ' ';
					}
					break;
				case 'mod_ft_cabina':
					foreach($item as $row){
						if($value == 'Cabina' && $row->coluna4 == 'cabecalho'){
							$item4 .= $row['coluna6'] . ' <span>' . $row['coluna7'] . $row['coluna8'] . '</span>';
							continue;
						}
						if($value == 'Cabina' && $row['coluna4'] == 'obs'){
							$cabina .= '<tr><td colspan="6">' . $row['coluna6'] . '</td></tr>';
							continue;
						}
						$cabina .= '<tr><td class="item_atributo2">' . $row['coluna6'] . '</td>';
						$cabina .= '<td>' . $row['coluna7'] . '</td>';
						$cabina .= '<td>' . $row['coluna8'] . '</td>';
						$cabina .= '<td>' . $row['coluna9'] . '</td>';
						$cabina .= '<td>' . $row['coluna10'] . '</td>';
						$cabina .= '<td>' . $row['coluna11'] . '</td></tr>';
					}
					break;
				case 'mod_ft_motor':
					foreach($item as $row){
						if($value == 'Motor' && $row['coluna4'] == 'cabecalho'){
							$item5 .= $row['coluna6'] . ' <span>' . $row['coluna7'] . $row['coluna8'] . '</span>';
							continue;
						}
						if($value == 'Motor' && $row['coluna4'] == 'obs'){
							$motor .= '<tr><td colspan="6">' . $row['coluna6'] . '</td></tr>';
							continue;
						}
						$motor .= '<tr><td class="item_atributo2">' . $row['coluna6'] . '</td>';
						$motor .= '<td>' . $row['coluna7'] . '</td>';
						$motor .= '<td>' . $row['coluna8'] . '</td>';
						$motor .= '<td>' . $row['coluna9'] . '</td>';
						$motor .= '<td>' . $row['coluna10'] . '</td>';
						$motor .= '<td>' . $row['coluna11'] . '</td></tr>';
					}
					break;
				case 'mod_ft_sistema eletrico':
					foreach($item as $row){
						if($value == 'Sistema Eletrico' && $row['coluna4'] == 'cabecalho'){
							$item6 .= $row['coluna6'] . ' <span>' . $row['coluna7'] . $row['coluna8'] . '</span>';
							continue;
						}
						if($value == 'Sistema Eletrico' && $row['coluna4'] == 'obs'){
							$sistema .= '<tr><td colspan="6">' . $row['coluna6'] . '</td></tr>';
							continue;
						}
						$sistema .= '<tr><td class="item_atributo2">' . $row['coluna6'] . '</td>';
						$sistema .= '<td>' . $row['coluna7'] . '</td>';
						$sistema .= '<td>' . $row['coluna8'] . '</td>';
						$sistema .= '<td>' . $row['coluna9'] . '</td>';
						$sistema .= '<td>' . $row['coluna10'] . '</td>';
						$sistema .= '<td>' . $row['coluna11'] . '</td></tr>';
					}
					break;
				case 'mod_ft_caixa_transferencia':
						
						foreach($item as $row){
							if($value == 'Caixa de transferência' && $row['coluna4'] == 'cabecalho'){
								$caixa  = '<div class="linha"><div class="item_title">' . $row['coluna6'] . ' <span>' . $row['coluna7'] . $row['coluna8'] . '</span></div>';
								$caixa .= '<div class="dv_item_tabela"><table class="item_tabela" cellpadding="0" cellspacing="0" border="0">';
								continue;
							}
							if($value == 'Caixa de transferência' && $row['coluna4'] == 'item'){
								$caixa .= '<tr><td class="item_atributo2">' . $row['coluna6'] . '</td>';
								$caixa .= '<td>' . $row['coluna7'] . '</td>';
								$caixa .= '<td>' . $row['coluna8'] . '</td>';
								$caixa .= '<td>' . $row['coluna9'] . '</td>';
								$caixa .= '<td>' . $row['coluna10'] . '</td>';
								$caixa .= '<td>' . $row['coluna11'] . '</td></tr>';
							}
						}
						if($caixa != ''){
							$caixa .= '</table></div></div>';
						}
					break;
				case 'mod_ft_transmissao':
					foreach($item as $row){
						if($value == 'Transmissao' && $row['coluna4'] == 'cabecalho'){
							$item7 .= $row['coluna6'] . ' <span>' . $row['coluna7'] . $row['coluna8'] . '</span>';
							continue;
						}
						if($value == 'Transmissao' && $row['coluna4'] == 'obs'){
							$trans .= '<tr><td colspan="6">' . $row['coluna6'] . '</td></tr>';
							continue;
						}
						$trans .= '<tr><td class="item_atributo2">' . $row['coluna6'] . '</td>';
						$trans .= '<td>' . $row['coluna7'] . '</td>';
						$trans .= '<td>' . $row['coluna8'] . '</td>';
						$trans .= '<td>' . $row['coluna9'] . '</td>';
						$trans .= '<td>' . $row['coluna10'] . '</td>';
						$trans .= '<td>' . $row['coluna11'] . '</td></tr>';
					}
					break;
				case 'mod_ft_eixos':
					foreach($item as $row){
						if($value == 'Eixos' && $row['coluna4'] == 'cabecalho'){
							$item8 .= $row['coluna6'] . ' <span>' . $row['coluna7'] . $row['coluna8'] . '</span>';
							continue;
						}
						if($value == 'Eixos' && $row['coluna4'] == 'obs'){
							$eixo .= '<tr><td colspan="6">' . $row['coluna6'] . '</td></tr>';
							continue;
						}
						$eixo .= '<tr><td class="item_atributo2">' . $row['coluna6'] . '</td><td>';
						$eixo .= $row['coluna7'] . ' ';
						$eixo .= $row['coluna8'] . ' ';
						$eixo .= $row['coluna9'] . ' ';
						$eixo .= $row['coluna10'] . ' ';
						$eixo .= $row['coluna11'] . '</td></tr>';
					}
					break;
				case 'mod_ft_chassis':
					$index = 0;
					foreach($item as $row){
						if($value == 'Chassis' && $row['coluna4'] == 'cabecalho'){
							$item9 .= $row['coluna6'] . ' <span>' . $row['coluna7'] . $row['coluna8'] . '</span>';
							continue;
						}
						if($value == 'Chassis' && $row['coluna4'] == 'obs' && $obs_chassi == 0){
							$obs_chassi = 1;
							$chassi .= '<tr><td colspan="6">' . $row['coluna6'] . '</td></tr>';
							continue;
						}
						$index = $index + 1;
						$chassi .= '<tr><td class="item_atributo2">' . $row['coluna6'] . '</td>';
						if($index == 1 || $index == 2){
							$chassi .= '<td colspan="5" class="item_atributo">' . $row['coluna7'] . '</td></tr>';
							continue;
						}
						if($value == 'Chassis' && $row['coluna4'] == 'item' && $row['coluna6'] == ''){
							$chassi .= '<td colspan="5" class="item_atributo">' . $row['coluna7'] . '</td></tr>';
							continue;
						}
						$chassi .= '<td>' . $row['coluna7'] . '</td>';
						$chassi .= '<td>' . $row['coluna8'] . '</td>';
						$chassi .= '<td>' . $row['coluna9'] . '</td>';
						$chassi .= '<td>' . $row['coluna10'] . '</td>';
						$chassi .= '<td>' . $row['coluna11'] . '</td></tr>';
					}
					break;
				case 'mod_ft_desempenho':
					foreach($item as $row){
						if($value == 'Desempenho' && $row['coluna4'] == 'cabecalho'){
							$item10 .= $row['coluna6'] . ' <span>' . $row['coluna7'] . $row['coluna8'] . '</span>';
							continue;
						}
						if($value == 'Desempenho' && $row['coluna4'] == 'obs'){
							$desem .= '<tr><td colspan="6">' . $row['coluna6'] . '</td></tr>';
							continue;
						}
						$ext_desempenho = substr($row['coluna6'],0,3);
						if($ext_desempenho == 'com'){
							$desem .= '<tr><td class="item_atributo" style="text-align: right;">' . $row['coluna6'] . '</td>';
						}else{
							$desem .= '<tr><td class="item_atributo2">' . $row['coluna6'] . '</td>';
						}
						$desem .= '<td>' . $row['coluna7'] . '</td>';
						$desem .= '<td>' . $row['coluna8'] . '</td>';
						$desem .= '<td>' . $row['coluna9'] . '</td>';
						$desem .= '<td>' . $row['coluna10'] . '</td>';
						$desem .= '<td>' . $row['coluna11'] . '</td></tr>';
					}
					break;
				case 'mod_ft_freios':
					foreach($item as $row){
						if($value == 'Freios' && $row['coluna4'] == 'cabecalho'){
							$item11 .= $row['coluna6'] . ' <span>' . $row['coluna7'] . $row['coluna8'] . '</span>';
							continue;
						}
						if($value == 'Freios' && $row['coluna4'] == 'obs'){
							$freios .= '<tr><td colspan="6">' . $row['coluna6'] . '</td></tr>';
							continue;
						}
						$freios .= '<tr><td class="item_atributo2">' . $row['coluna6'] . '</td>';
						$freios .= '<td>' . $row['coluna7'] . '</td>';
						$freios .= '<td>' . $row['coluna8'] . '</td>';
						$freios .= '<td>' . $row['coluna9'] . '</td>';
						$freios .= '<td>' . $row['coluna10'] . '</td>';
						$freios .= '<td>' . $row['coluna11'] . '</td></tr>';
					}
					break;
			}
        }
        $arr = array(
			'#TITULO#',
			'#TITULO2#',
			'#SUBTITULO#',
			'#SUBTITULO2#',
			'accelo_815_pic_1',
			'accelo_815_pic_2',
			'#DIMENSOES#',
			'#PESOS#',
			'#NOTA#',
			'#CABINA#',
			'#MOTOR#',
			'#SISTEMA#',
			'#CAIXA#',
			'#TRANS#',
			'#EIXO#',
			'#CHASSI#',
			'#DESEM#',
			'#FREIOS#',
			'#ITEM1#',
			'#ITEM2#',
			'#ITEM3#',
			'#ITEM4#',
			'#ITEM5#',
			'#ITEM6#',
			'#ITEM7#',
			'#ITEM8#',
			'#ITEM9#',
			'#ITEM10#',
			'#ITEM11#',
			'#RODAPE#',
			'#LATERAL#'
		);
		$sub = array(
			$titulo,
			$titulo2,
			$sub,
			$sub2,
			$img,
			$img2,
			$dimensoes,
			$pesos,
			$nota,
			$cabina,
			$motor,
			$sistema,
			$caixa,
			$trans,
			$eixo,
			$chassi,
			$desem,
			$freios,
			$item1,
			$item2,
			$item3,
			$item4,
			$item5,
			$item6,
			$item7,
			$item8,
			$item9,
			$item10,
			$item11,
			$rodape,
			$lateral
		);
		
		$content = str_replace($arr,$sub,$content);
		echo $content;
		/*$myfile  = fopen('temp.html', 'w');
		fwrite($myfile,$content);
		fclose($myfile);
		return $nome_do_arquivo;*/
    	/*$content = file_get_contents('modelos_ficha/modelo_grafica.html');
    	echo 'funcionando';*/ //$ficha->loadData('loadinicial','');
    }

    public function generatorAction(){
    	header ('Content-type: text/html; charset=UTF-8');

		$mpdf = new SC_Plugins_Pdf_pdf('utf8-s','A4','8','corpos' , 0 , 0 , 0 , 0 , 0 , 10);
		$mpdf->useOddEven = 0;
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->list_indent_first_level = 0;  // 1 or 0 - whether to indent the first level of a list

		$bucket    = 'mb-fichas-tecnicas';
        $root_path = 'gs://' . $bucket;

		$content  = file_get_contents('modelos_ficha/temp.html');
		$mpdf->WriteHTML($content);
		$a = $mpdf->Output("$root_path/teste.pdf",'F');
		//unlink('temp.html');
		echo $a;
    }
}