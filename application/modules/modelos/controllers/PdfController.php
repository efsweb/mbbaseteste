<?php
use google\appengine\api\cloud_storage\CloudStorageTools;
class Modelos_PdfController extends Zend_Controller_Action{
	
	public function init(){
		Zend_Layout::resetMvcInstance();
        $this->_helper->viewRenderer->setNoRender(true);
    }
    public function indexAction(){
    	error_reporting(0);
    	$pgid = 'mod_ft_geral';

        $modeloid = new Zend_Session_Namespace('modeloselecionado');
        $usuario  = new Zend_Session_Namespace('usuario');
        $mdid = $this->_getParam('id', $modeloid->id);
        $idsys= $usuario->va[0];
        //$versao = 'v' . $idsys . '_';
        if($mdid != $modeloid->id){
            $modeloid->id = $mdid;
        }
        $versao = $this->getRequest()->getParam('versao', '');
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
					$titulo2 = ucfirst(explode(' ',$item['coluna7'])[0]);
					$sub 	 = ucfirst($item['coluna10']);
					$sub2	 = ucfirst($item['coluna11']);
					$util = new SC_Plugins_Utils();
					$queb = explode(' - ',$item['coluna8']);
					$k = explode(' ', $queb[2]);
					if(count($k) > 1){
						$lateral = $item['coluna8'];
					}else{
						$lateral = $queb[0] . ' - ' . $queb[1] . ' - ' . $util->dataExtenso($queb[2]);
					}
					$rodape  = $item['coluna5'];
					$partes = (!is_null($lateral)) ? explode(' - ', $lateral) : '';
					$codigo = (isset($partes[1])) ? $partes[1] : '';
					$nome_do_arquivo = 'v' . $idsys . '_' . str_replace("_"," ",$item['coluna3']);
					$img  = CloudStorageTools::getPublicUrl('gs://mb-ft-images/v' . $idsys . '_' . strtolower($item['coluna1']) . '_' . strtolower($item['coluna2']) . '_pic_1.jpg',true);
					$img2 = CloudStorageTools::getPublicUrl('gs://mb-ft-images/v' . $idsys . '_' . strtolower($item['coluna1']) . '_' . strtolower($item['coluna2']) . '_pic_2.jpg',true);
					if($versao == 'jpg')
						$nome_do_arquivo = 'v' . $idsys . '_' . strtolower($item['coluna1']) . '_' . $item['coluna2'];
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
					$pesosobs = '';
					$admobs   = '';
					for($i=0;$i < $final; $i++){
						if(isset($item[$i]['coluna4']) && $item[$i]['coluna4'] == 'cabecalho'){
							$item2 .= $item[$i]['coluna6'] . ' <span>' . $item[$i]['coluna7'] . $item[$i]['coluna8'] . '</span>';
							$item3 .= $admissiveis[$i]['coluna6'] . ' <span>' . $admissiveis[$i]['coluna7'] . $admissiveis[$i]['coluna8'] . '</span>';
							continue;
						}
						if($pesos == ''){
							if($item[$i]['coluna4'] == 'obs'){
								$pesosobs .= '<tr><td colspan="10">';
								$pesosobs .= ((isset($item[$i]['coluna6'])) ? trim($item[$i]['coluna6']) : '');
								$pesosobs .= '</td></tr>';
							}else{
								$pesos .= '<tr><td class="item_atributo_pesos">';
								$pesos .= ((isset($item[$i]['coluna6'])) ? trim($item[$i]['coluna6']) : '');
								$pesos .= '</td><td class="aright"><b>';
								$pesos .= ((isset($item[$i]['coluna7'])) ? trim($item[$i]['coluna7']) : '');
								$pesos .= '</b></td><td class="aright"><b>';
								$pesos .= ((isset($item[$i]['coluna8'])) ? trim($item[$i]['coluna8']) : '');
								$pesos .= '</b></td><td class="aright"><b>';
								$pesos .= ((isset($item[$i]['coluna9'])) ? trim($item[$i]['coluna9']) : '');
								$pesos .= '</b></td>';
								//$pesos .= '<td class="aright"><b>';
								//$pesos .= ((isset($item[$i]['coluna10'])) ? trim($item[$i]['coluna10']) : '') . '</b></td>';
								$pesos .= '<td class="pesos_separator">&nbsp;</td>';
							}
							if($admissiveis[$i]['coluna4'] == 'obs'){
								$admobs .= '<tr><td colspan="10">';
								$admobs .= ((isset($admissiveis[$i]['coluna6'])) ? trim($admissiveis[$i]['coluna6']) : '') . '</td></tr>';
							}else{
								$pesos .= '<td class="item_atributo_pesos">';
								$pesos .= ((isset($admissiveis[$i]['coluna6'])) ? trim($admissiveis[$i]['coluna6']) : '') . '</td>';
								$pesos .= '<td class="aright"><b>';
								$pesos .= ((isset($admissiveis[$i]['coluna7'])) ? trim($admissiveis[$i]['coluna7']) : '') . '</b></td>';
								$pesos .= '<td class="aright"><b>';
								$pesos .= ((isset($admissiveis[$i]['coluna8'])) ? trim($admissiveis[$i]['coluna8']) : '') . '</b></td>';
								$pesos .= '<td class="aright"><b>';
								$pesos .= ((isset($admissiveis[$i]['coluna9'])) ? trim($admissiveis[$i]['coluna9']) : '') . '</b></td>';
								//$pesos .= '<td class="aright"><b>';
								//$pesos .= ((isset($admissiveis[$i]['coluna10'])) ? trim($admissiveis[$i]['coluna10']) : '') . '</b></td>';
								$pesos .= '</tr>';
								continue;
							}
						}else{
							if($item[$i]['coluna4'] == 'obs' && $admissiveis[$i]['coluna4'] != 'obs'){
								$pesosobs .= '<tr><td colspan="10">';
								$pesosobs .= ((isset($item[$i]['coluna6'])) ? trim($item[$i]['coluna6']) : '');
								$pesosobs .= '</td></tr>';

								if(isset($admissiveis[$i]['coluna6'])){
									$pesos .= '<tr><td colspan="4"></td><td class="pesos_separator">&nbsp;</td>';
									$pesos .= '<td class="item_atributo_pesos">';
									$pesos .= ((isset($admissiveis[$i]['coluna6'])) ? trim($admissiveis[$i]['coluna6']) : '') . '</td>';
									$pesos .= '<td class="aright">';
									$pesos .= ((isset($admissiveis[$i]['coluna7'])) ? trim($admissiveis[$i]['coluna7']) : '') . '</td>';
									$pesos .= '<td class="aright">';
									$pesos .= ((isset($admissiveis[$i]['coluna8'])) ? trim($admissiveis[$i]['coluna8']) : '') . '</td>';
									$pesos .= '<td class="aright">';
									$pesos .= ((isset($admissiveis[$i]['coluna9'])) ? trim($admissiveis[$i]['coluna9']) : '') . '</td>';
									//$pesos .= '<td class="aright">';
									//$pesos .= ((isset($admissiveis[$i]['coluna10'])) ? trim($admissiveis[$i]['coluna10']) : '') . '</td>';
									$pesos .= '</tr>';
								}
							}elseif($item[$i]['coluna4'] == 'obs' && $admissiveis[$i]['coluna4'] == 'obs'){
								$pesosobs .= '<tr><td colspan="10">';
								$pesosobs .= ((isset($item[$i]['coluna6'])) ? trim($item[$i]['coluna6']) : '');
								$pesosobs .= '</td></tr>';
								$admobs .= '<tr><td colspan="10">';
								$admobs .= ((isset($admissiveis[$i]['coluna6'])) ? trim($admissiveis[$i]['coluna6']) : '') . '</td></tr>';
							}elseif($item[$i]['coluna4'] != 'obs' && $admissiveis[$i]['coluna4'] == 'obs'){
								if(!isset($item[$i]['coluna6'])){
									if($pesosobs != ''){
										$pesos .= $pesosobs;
										$pesosobs = '';
									}
									$pesos .= '<tr><td colspan="10">';
									$pesos .= ((isset($admissiveis[$i]['coluna6'])) ? trim($admissiveis[$i]['coluna6']) : '') . '</td></tr>';
								}else{
									$admobs .= '<tr><td colspan="10">';
									$admobs .= ((isset($admissiveis[$i]['coluna6'])) ? trim($admissiveis[$i]['coluna6']) : '') . '</td></tr>';

									$pesos .= '<tr><td class="item_atributo_pesos">';
									$pesos .= ((isset($item[$i]['coluna6'])) ? trim($item[$i]['coluna6']) : '');
									$pesos .= '</td><td class="aright">';
									$pesos .= ((isset($item[$i]['coluna7'])) ? trim($item[$i]['coluna7']) : '');
									$pesos .= '</td><td class="aright">';
									$pesos .= ((isset($item[$i]['coluna8'])) ? trim($item[$i]['coluna8']) : '');
									$pesos .= '</td><td class="aright">';
									$pesos .= ((isset($item[$i]['coluna9'])) ? trim($item[$i]['coluna9']) : '');
									$pesos .= '</td>';
									//$pesos .= '<td class="aright">' . ((isset($item[$i]['coluna10'])) ? trim($item[$i]['coluna10']) : '') . '</td>';
									$pesos .= '<td class="pesos_separator">&nbsp;</td>';
									$pesos .= '<td colspan="4"></td></tr>';
								}
							}else{
								$pesos .= '<tr><td class="item_atributo_pesos">';
								$pesos .= ((isset($item[$i]['coluna6'])) ? trim($item[$i]['coluna6']) : '');
								$pesos .= '</td><td class="aright">';
								$pesos .= ((isset($item[$i]['coluna7'])) ? trim($item[$i]['coluna7']) : '');
								$pesos .= '</td><td class="aright">';
								$pesos .= ((isset($item[$i]['coluna8'])) ? trim($item[$i]['coluna8']) : '');
								$pesos .= '</td><td class="aright">';
								$pesos .= ((isset($item[$i]['coluna9'])) ? trim($item[$i]['coluna9']) : '');
								$pesos .= '</td>';
								//$pesos .= '<td class="aright">' . ((isset($item[$i]['coluna10'])) ? trim($item[$i]['coluna10']) : '') . '</td>';
								$pesos .= '<td class="pesos_separator">&nbsp;</td>';

								$pesos .= '<td class="item_atributo_pesos">';
								$pesos .= ((isset($admissiveis[$i]['coluna6'])) ? trim($admissiveis[$i]['coluna6']) : '') . '</td>';
								$pesos .= '<td class="aright">';
								$pesos .= ((isset($admissiveis[$i]['coluna7'])) ? trim($admissiveis[$i]['coluna7']) : '') . '</td>';
								$pesos .= '<td class="aright">';
								$pesos .= ((isset($admissiveis[$i]['coluna8'])) ? trim($admissiveis[$i]['coluna8']) : '') . '</td>';
								$pesos .= '<td class="aright">';
								$pesos .= ((isset($admissiveis[$i]['coluna9'])) ? trim($admissiveis[$i]['coluna9']) : '') . '</td>';
								//$pesos .= '<td class="aright">';
								//$pesos .= ((isset($admissiveis[$i]['coluna10'])) ? trim($admissiveis[$i]['coluna10']) : '') . '</td></tr>';
								$pesos .= '</tr>';
							}
						}
					}
					if($pesosobs != ''){
						$pesos .= $pesosobs;
						$pesosobs = '';
					}
					if($admobs != ''){
						$pesos .= $admobs;
						$admobs = '';
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
						if($value == 'mod_ft_cabina' && $row['coluna4'] == 'cabecalho'){
							$item4 .= $row['coluna6'] . ' <div>' . $row['coluna7'] . $row['coluna8'] . '</div>';
							continue;
						}
						//if($value == 'mod_ft_cabina' && $row['coluna4'] == 'obs'){
						if($row['coluna7'] == '' && $row['coluna8'] == '' && $row['coluna9'] == '' && $row['coluna10'] == '' && $row['coluna11'] == ''){
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
						if($value == 'mod_ft_motor' && $row['coluna4'] == 'cabecalho'){
							$item5 .= $row['coluna6'] . ' <div>' . $row['coluna7'] . $row['coluna8'] . '</div>';
							continue;
						}
						//if($value == 'mod_ft_motor' && $row['coluna4'] == 'obs'){
						if($row['coluna7'] == '' && $row['coluna8'] == '' && $row['coluna9'] == '' && $row['coluna10'] == '' && $row['coluna11'] == ''){
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
						if($value == 'mod_ft_sistema eletrico' && $row['coluna4'] == 'cabecalho'){
							$item6 .= $row['coluna6'] . ' <div>' . $row['coluna7'] . $row['coluna8'] . '</div>';
							continue;
						}
						//if($value == 'mod_ft_sistema eletrico' && $row['coluna4'] == 'obs'){
						if($row['coluna7'] == '' && $row['coluna8'] == '' && $row['coluna9'] == '' && $row['coluna10'] == '' && $row['coluna11'] == ''){
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
						$t = count($item);
						if($t != 1){
							foreach($item as $row){
								if($value == 'mod_ft_caixa_transferencia' && $row['coluna4'] == 'cabecalho'){
									$caixa  = '<div class="linha"><div class="item_title">' . $row['coluna6'] . ' <div>' . $row['coluna7'] . $row['coluna8'] . '</div></div>';
									$caixa .= '<div class="dv_item_tabela"><table class="item_tabela" cellpadding="0" cellspacing="0" border="0">';
									continue;
								}
								if($value == 'mod_ft_caixa_transferencia' && $row['coluna4'] == 'item'){
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
						}
					break;
				case 'mod_ft_transmissao':
					foreach($item as $row){
						if($value == 'mod_ft_transmissao' && $row['coluna4'] == 'cabecalho'){
							$item7 .= $row['coluna6'] . ' <div>' . $row['coluna7'] . $row['coluna8'] . '</div>';
							continue;
						}
						if($row['coluna7'] == '' && $row['coluna8'] == '' && $row['coluna9'] == '' && $row['coluna10'] == '' && $row['coluna11'] == ''){
							//if($value == 'mod_ft_transmissao' && $row['coluna4'] == 'obs'){
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
						if($value == 'mod_ft_eixos' && $row['coluna4'] == 'cabecalho'){
							$item8 .= $row['coluna6'] . ' <div>' . $row['coluna7'] . $row['coluna8'] . '</div>';
							continue;
						}
						//if($value == 'mod_ft_eixos' && $row['coluna4'] == 'obs'){
						if($row['coluna7'] == '' && $row['coluna8'] == '' && $row['coluna9'] == '' && $row['coluna10'] == '' && $row['coluna11'] == ''){
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
						if($value == 'mod_ft_chassis' && $row['coluna4'] == 'cabecalho'){
							$item9 .= $row['coluna6'] . ' <div>' . $row['coluna7'] . $row['coluna8'] . '</div>';
							continue;
						}
						if($row['coluna7'] == '' && $row['coluna8'] == '' && $row['coluna9'] == '' && $row['coluna10'] == '' && $row['coluna11'] == '' && $obs_chassi == 0){
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
						if($row['coluna4'] == 'item' && $row['coluna8'] == ' '){
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
						if($value == 'mod_ft_desempenho' && $row['coluna4'] == 'cabecalho'){
							$item10 .= $row['coluna6'] . ' <div>' . $row['coluna7'] . $row['coluna8'] . '</div>';
							continue;
						}
						if($row['coluna7'] == '' && $row['coluna8'] == '' && $row['coluna9'] == '' && $row['coluna10'] == '' && $row['coluna11'] == ''){
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
						if($value == 'mod_ft_freios' && $row['coluna4'] == 'cabecalho'){
							$item11 .= $row['coluna6'] . ' <div>' . $row['coluna7'] . $row['coluna8'] . '</div>';
							continue;
						}
						if($row['coluna7'] == '' && $row['coluna8'] == '' && $row['coluna9'] == '' && $row['coluna10'] == '' && $row['coluna11'] == ''){
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
			'novas/accelo_815_pic_1.jpg',
			'novas/accelo_815_pic_2.jpg',
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
		//echo $content;
		$flopn 	 = md5(date("YmdHis")) . '.html';
		$bucket    = 'mb-fichas-tecnicas/';
        $root_path = 'gs://' . $bucket . $flopn;

		$myfile  = fopen("$root_path", 'w');
		fwrite($myfile,$content);
		fclose($myfile);
		$return = array('arquivo' => $nome_do_arquivo, 'temp' => $root_path);
		echo json_encode($return);
    }

    public function generatorAction(){
    	header ('Content-type: text/html; charset=UTF-8');
    	$file = $this->getRequest()->getParam('temp', '');
    	$nome = $this->getRequest()->getParam('nome', '');
    	$tipo = $this->getRequest()->getParam('versao', '');
    	if($tipo == 'grafica'){
    		$mpdf = new SC_Plugins_Pdf_pdf('utf8-s',array(225.98, 313.01),'8','corpos' , 0 , 0 , 0 , 0 , 0 , 10);
    	}elseif($tipo == 'jpg'){
    		$math = 66 * 7; //total de linhas
    		$mpdf = new SC_Plugins_Pdf_pdf('utf8-s',array(210,$math),'8','corpos' , 0 , 0 , 0 , 0 , 0 , 10);
    	}else{
    		$mpdf = new SC_Plugins_Pdf_pdf('utf8-s','A4','8','corpos' , 0 , 0 , 0 , 0 , 0 , 10);
    	}
		
		$mpdf->useOddEven = 0;
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->list_indent_first_level = 0;  // 1 or 0 - whether to indent the first level of a list

		$bucket    = 'mb-fichas-tecnicas';
        $root_path = 'gs://' . $bucket;

		$content  = file_get_contents("$file");
		$mpdf->WriteHTML($content);
		$a = $mpdf->Output("$root_path/$nome",'F');
		unlink("$file");
		echo $a;
    }
}