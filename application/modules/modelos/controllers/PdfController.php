<?php
class Modelos_PdfController extends Zend_Controller_Action{
	
	/*
	Lista de variaveis que serão usadas para gerar a ficha
	 */
	protected $_nome_do_arquivo = ''; //Nome do arquivo que deverá ser retornado
	protected $_titulo    	  	= '';
	protected $_titulo2   	  	= '';
	protected $_sub 	      	= '';
	protected $_sub2	    	= '';
	protected $_lateral   	  	= '';
	protected $_rodape    	  	= '';
	protected $_img       	  	= '';
	protected $_img2      	  	= '';
	protected $_nota	      	= '';
	protected $_dimensoes 	  	= '';
	protected $_pesos     	  	= '';
	protected $_cabina    	  	= '';
	protected $_motor 		  	= '';
	protected $_sistema   	  	= '';
	protected $_trans     	  	= '';
	protected $_eixo      	  	= '';
	protected $_chassi    	  	= '';
	protected $_desem     	  	= '';
	protected $_freios    	  	= '';
	protected $_item1     	  	= '';
	protected $_item2     	  	= '';
	protected $_item3     	  	= '';
	protected $_item4     	  	= '';
	protected $_item5     	  	= '';
	protected $_item6     	  	= '';
	protected $_item7     	  	= '';
	protected $_item8     	  	= '';
	protected $_item9     	  	= '';
	protected $_item10    	  	= '';
	protected $_item11    	  	= '';
	protected $_obs_chassi	  	= 0;
	protected $_caixa 	      	= '';

	public function init(){
		Zend_Layout::resetMvcInstance();
        $this->_helper->viewRenderer->setNoRender(true);
    }
    public function indexAction(){
    	$pgid = 'mod_ft_geral';
        $modeloid = new Zend_Session_Namespace('modeloselecionado');
        $mdid = $this->_getParam('id', $modeloid->id);
        if($mdid != $modeloid->id){
            $modeloid->id = $mdid;
        }
    	$myarr = 'Accelo / 815';

    	$modelos = new Model_ModelosMapper();
    	$familias = $modelos->lista();
        foreach ($familias as $key => $value) {
            $arr = $modelos->lista2('modelo',$value);
            if(array_key_exists($modeloid->id, $arr)){
                $myarr  = $arr[$modeloid->id];
            }
        }

        $family = explode(' / ', $myarr)[0];
    	$modelo = str_replace(' ', '_', explode(' / ', $myarr)[1]);
        $tipos  = array(0 => 'load_inicial', 1 => 'Dimensoes', 2 => 'Pesos', 3 => 'Pesos Admissiveis', 4 => 'Cabina', 5 => 'Motor', 6 => 'Sistema Eletrico', 7 => 'Transmissao', 8 => 'Eixos', 9 => 'Chassis', 10 => 'Desempenho', 11 => 'Freios', 12 => 'rodape_1', 13 => 'Caixa de transferência');

        foreach($tipos as $key => $value){
        	if($value == 'Pesos Admissiveis'){continue;}
        	$params = "'" . strtolower($family) . "','" . $modelo . "','" . $value . "'";

        	$ficha = new Model_FichaTecnica();
        	$item  = $ficha->loadData(strtolower($family),$modelo,$value);
        	switch ($value){
				case 'load_inicial':
					$item   = $item[0];
					$titulo  = ucfirst($item->coluna6);
					$titulo2 = ucfirst($item->coluna7);
					$sub 	 = ucfirst($item->coluna10);
					$sub2	 = ucfirst($item->coluna11);
					$lateral = $item->coluna8;
					$rodape  = $item->coluna5;
					$partes = (!is_null($lateral)) ? explode(' - ', $lateral) : '';
					$codigo = (isset($partes[1])) ? $partes[1] : '';
					$nome_do_arquivo = str_replace("_"," ",$item->coluna3);
					if($versao == 'jpg')
						$nome_do_arquivo = strtolower($item->coluna1) . '_' . $item->coluna2;
					break;
				case 'Dimensoes':
					foreach($item as $row){
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
					break;
				case 'Pesos':
					$admissiveis = $ficha->loadData(strtolower($family),$modelo,'Pesos Admissiveis');
					$total_adm = count($admissiveis);
					$total_pes = count($item);
					$final = ($total_adm >= $total_pes) ? $total_adm : $total_pes;
					for($i=0;$i < $final; $i++){
						if(isset($item[$i]->coluna4) && $item[$i]->coluna4 == 'cabecalho'){
							$item2 .= $item[$i]->coluna6 . ' <span>' . $item[$i]->coluna7 . $item[$i]->coluna8 . '</span>';
							$item3 .= $admissiveis[$i]->coluna6 . ' <span>' . $admissiveis[$i]->coluna7 . $admissiveis[$i]->coluna8 . '</span>';
							continue;
						}
						if($pesos == ''){
							$pesos .= '<tr><td class="item_atributo">';
							$pesos .= ((isset($item[$i]->coluna6)) ? trim($item[$i]->coluna6) : '');
							$pesos .= '</td><td class="aright"><b>';
							$pesos .= ((isset($item[$i]->coluna7)) ? trim($item[$i]->coluna7) : '');
							$pesos .= '</b></td><td class="aright"><b>';
							$pesos .= ((isset($item[$i]->coluna8)) ? trim($item[$i]->coluna8) : '');
							$pesos .= '</b></td><td class="aright"><b>';
							$pesos .= ((isset($item[$i]->coluna9)) ? trim($item[$i]->coluna9) : '');
							$pesos .= '</b></td><td class="aright"><b>';
							$pesos .= ((isset($item[$i]->coluna10)) ? trim($item[$i]->coluna10) : '');
							$pesos .= '</b></td><td class="pesos_separator">&nbsp;</td>';
							$pesos .= '<td class="item_atributo">';
							$pesos .= ((isset($admissiveis[$i]->coluna6)) ? trim($admissiveis[$i]->coluna6) : '') . '</td>';
							$pesos .= '<td class="aright"><b>';
							$pesos .= ((isset($admissiveis[$i]->coluna7)) ? trim($admissiveis[$i]->coluna7) : '') . '</b></td>';
							$pesos .= '<td class="aright"><b>';
							$pesos .= ((isset($admissiveis[$i]->coluna8)) ? trim($admissiveis[$i]->coluna8) : '') . '</b></td>';
							$pesos .= '<td class="aright"><b>';
							$pesos .= ((isset($admissiveis[$i]->coluna9)) ? trim($admissiveis[$i]->coluna9) : '') . '</b></td>';
							$pesos .= '<td class="aright"><b>';
							$pesos .= ((isset($admissiveis[$i]->coluna10)) ? trim($admissiveis[$i]->coluna10) : '') . '</b></td></tr>';
							continue;
						}
						$pesos .= '<tr><td class="item_atributo">';
						$pesos .= ((isset($item[$i]->coluna6)) ? trim($item[$i]->coluna6) : '');
						$pesos .= '</td><td class="aright">';
						$pesos .= ((isset($item[$i]->coluna7)) ? trim($item[$i]->coluna7) : '');
						$pesos .= '</td><td class="aright">';
						$pesos .= ((isset($item[$i]->coluna8)) ? trim($item[$i]->coluna8) : '');
						$pesos .= '</td><td class="aright">';
						$pesos .= ((isset($item[$i]->coluna9)) ? trim($item[$i]->coluna9) : '');
						$pesos .= '</td><td class="aright">';
						$pesos .= ((isset($item[$i]->coluna10)) ? trim($item[$i]->coluna10) : '');
						$pesos .= '</td><td class="pesos_separator">&nbsp;</td>';
						$pesos .= '<td class="item_atributo">';
						$pesos .= ((isset($admissiveis[$i]->coluna6)) ? trim($admissiveis[$i]->coluna6) : '') . '</td>';
						$pesos .= '<td class="aright">';
						$pesos .= ((isset($admissiveis[$i]->coluna7)) ? trim($admissiveis[$i]->coluna7) : '') . '</td>';
						$pesos .= '<td class="aright">';
						$pesos .= ((isset($admissiveis[$i]->coluna8)) ? trim($admissiveis[$i]->coluna8) : '') . '</td>';
						$pesos .= '<td class="aright">';
						$pesos .= ((isset($admissiveis[$i]->coluna9)) ? trim($admissiveis[$i]->coluna9) : '') . '</td>';
						$pesos .= '<td class="aright">';
						$pesos .= ((isset($admissiveis[$i]->coluna10)) ? trim($admissiveis[$i]->coluna10) : '') . '</td></tr>';
					}
					//echo $pesos;
					break;
				case 'rodape_1':
					foreach($item as $row){
						$nota .= $row->coluna6 . ' ';
					}
					break;
				case 'Cabina':
					foreach($item as $row){
						if($value == 'Cabina' && $row->coluna4 == 'cabecalho'){
							$item4 .= $row->coluna6 . ' <span>' . $row->coluna7 . $row->coluna8 . '</span>';
							continue;
						}
						if($value == 'Cabina' && $row->coluna4 == 'obs'){
							$cabina .= '<tr><td colspan="6">' . $row->coluna6 . '</td></tr>';
							continue;
						}
						$cabina .= '<tr><td class="item_atributo2">' . $row->coluna6 . '</td>';
						$cabina .= '<td>' . $row->coluna7 . '</td>';
						$cabina .= '<td>' . $row->coluna8 . '</td>';
						$cabina .= '<td>' . $row->coluna9 . '</td>';
						$cabina .= '<td>' . $row->coluna10 . '</td>';
						$cabina .= '<td>' . $row->coluna11 . '</td></tr>';
					}
					break;
				case 'Motor':
					foreach($item as $row){
						if($value == 'Motor' && $row->coluna4 == 'cabecalho'){
							$item5 .= $row->coluna6 . ' <span>' . $row->coluna7 . $row->coluna8 . '</span>';
							continue;
						}
						if($value == 'Motor' && $row->coluna4 == 'obs'){
							$motor .= '<tr><td colspan="6">' . $row->coluna6 . '</td></tr>';
							continue;
						}
						$motor .= '<tr><td class="item_atributo2">' . $row->coluna6 . '</td>';
						$motor .= '<td>' . $row->coluna7 . '</td>';
						$motor .= '<td>' . $row->coluna8 . '</td>';
						$motor .= '<td>' . $row->coluna9 . '</td>';
						$motor .= '<td>' . $row->coluna10 . '</td>';
						$motor .= '<td>' . $row->coluna11 . '</td></tr>';
					}
					break;
				case 'Sistema Eletrico':
					foreach($item as $row){
						if($value == 'Sistema Eletrico' && $row->coluna4 == 'cabecalho'){
							$item6 .= $row->coluna6 . ' <span>' . $row->coluna7 . $row->coluna8 . '</span>';
							continue;
						}
						if($value == 'Sistema Eletrico' && $row->coluna4 == 'obs'){
							$sistema .= '<tr><td colspan="6">' . $row->coluna6 . '</td></tr>';
							continue;
						}
						$sistema .= '<tr><td class="item_atributo2">' . $row->coluna6 . '</td>';
						$sistema .= '<td>' . $row->coluna7 . '</td>';
						$sistema .= '<td>' . $row->coluna8 . '</td>';
						$sistema .= '<td>' . $row->coluna9 . '</td>';
						$sistema .= '<td>' . $row->coluna10 . '</td>';
						$sistema .= '<td>' . $row->coluna11 . '</td></tr>';
					}
					break;
				case 'Caixa de transferência':
						
						foreach($item as $row){
							if($value == 'Caixa de transferência' && $row->coluna4 == 'cabecalho'){
								$caixa  = '<div class="linha"><div class="item_title">' . $row->coluna6 . ' <span>' . $row->coluna7 . $row->coluna8 . '</span></div>';
								$caixa .= '<div class="dv_item_tabela"><table class="item_tabela" cellpadding="0" cellspacing="0" border="0">';
								continue;
							}
							if($value == 'Caixa de transferência' && $row->coluna4 == 'item'){
								$caixa .= '<tr><td class="item_atributo2">' . $row->coluna6 . '</td>';
								$caixa .= '<td>' . $row->coluna7 . '</td>';
								$caixa .= '<td>' . $row->coluna8 . '</td>';
								$caixa .= '<td>' . $row->coluna9 . '</td>';
								$caixa .= '<td>' . $row->coluna10 . '</td>';
								$caixa .= '<td>' . $row->coluna11 . '</td></tr>';
							}
						}
						if($caixa != ''){
							$caixa .= '</table></div></div>';
						}
					break;
				case 'Transmissao':
					foreach($item as $row){
						if($value == 'Transmissao' && $row->coluna4 == 'cabecalho'){
							$item7 .= $row->coluna6 . ' <span>' . $row->coluna7 . $row->coluna8 . '</span>';
							continue;
						}
						if($value == 'Transmissao' && $row->coluna4 == 'obs'){
							$trans .= '<tr><td colspan="6">' . $row->coluna6 . '</td></tr>';
							continue;
						}
						$trans .= '<tr><td class="item_atributo2">' . $row->coluna6 . '</td>';
						$trans .= '<td>' . $row->coluna7 . '</td>';
						$trans .= '<td>' . $row->coluna8 . '</td>';
						$trans .= '<td>' . $row->coluna9 . '</td>';
						$trans .= '<td>' . $row->coluna10 . '</td>';
						$trans .= '<td>' . $row->coluna11 . '</td></tr>';
					}
					break;
				case 'Eixos':
					foreach($item as $row){
						if($value == 'Eixos' && $row->coluna4 == 'cabecalho'){
							$item8 .= $row->coluna6 . ' <span>' . $row->coluna7 . $row->coluna8 . '</span>';
							continue;
						}
						if($value == 'Eixos' && $row->coluna4 == 'obs'){
							$eixo .= '<tr><td colspan="6">' . $row->coluna6 . '</td></tr>';
							continue;
						}
						$eixo .= '<tr><td class="item_atributo2">' . $row->coluna6 . '</td><td>';
						$eixo .= $row->coluna7 . ' ';
						$eixo .= $row->coluna8 . ' ';
						$eixo .= $row->coluna9 . ' ';
						$eixo .= $row->coluna10 . ' ';
						$eixo .= $row->coluna11 . '</td></tr>';
					}
					break;
				case 'Chassis':
					$index = 0;
					foreach($item as $row){
						if($value == 'Chassis' && $row->coluna4 == 'cabecalho'){
							$item9 .= $row->coluna6 . ' <span>' . $row->coluna7 . $row->coluna8 . '</span>';
							continue;
						}
						if($value == 'Chassis' && $row->coluna4 == 'obs' && $obs_chassi == 0){
							$obs_chassi = 1;
							$chassi .= '<tr><td colspan="6">' . $row->coluna6 . '</td></tr>';
							continue;
						}
						$index = $index + 1;
						$chassi .= '<tr><td class="item_atributo2">' . $row->coluna6 . '</td>';
						if($index == 1 || $index == 2){
							$chassi .= '<td colspan="5" class="item_atributo">' . $row->coluna7 . '</td></tr>';
							continue;
						}
						if($value == 'Chassis' && $row->coluna4 == 'item' && $row->coluna6 == ''){
							$chassi .= '<td colspan="5" class="item_atributo">' . $row->coluna7 . '</td></tr>';
							continue;
						}
						$chassi .= '<td>' . $row->coluna7 . '</td>';
						$chassi .= '<td>' . $row->coluna8 . '</td>';
						$chassi .= '<td>' . $row->coluna9 . '</td>';
						$chassi .= '<td>' . $row->coluna10 . '</td>';
						$chassi .= '<td>' . $row->coluna11 . '</td></tr>';
					}
					break;
				case 'Desempenho':
					foreach($item as $row){
						if($value == 'Desempenho' && $row->coluna4 == 'cabecalho'){
							$item10 .= $row->coluna6 . ' <span>' . $row->coluna7 . $row->coluna8 . '</span>';
							continue;
						}
						if($value == 'Desempenho' && $row->coluna4 == 'obs'){
							$desem .= '<tr><td colspan="6">' . $row->coluna6 . '</td></tr>';
							continue;
						}
						$ext_desempenho = substr($row->coluna6,0,3);
						if($ext_desempenho == 'com'){
							$desem .= '<tr><td class="item_atributo" style="text-align: right;">' . $row->coluna6 . '</td>';
						}else{
							$desem .= '<tr><td class="item_atributo2">' . $row->coluna6 . '</td>';
						}
						$desem .= '<td>' . $row->coluna7 . '</td>';
						$desem .= '<td>' . $row->coluna8 . '</td>';
						$desem .= '<td>' . $row->coluna9 . '</td>';
						$desem .= '<td>' . $row->coluna10 . '</td>';
						$desem .= '<td>' . $row->coluna11 . '</td></tr>';
					}
					break;
				case 'Freios':
					foreach($item as $row){
						if($value == 'Freios' && $row->coluna4 == 'cabecalho'){
							$item11 .= $row->coluna6 . ' <span>' . $row->coluna7 . $row->coluna8 . '</span>';
							continue;
						}
						if($value == 'Freios' && $row->coluna4 == 'obs'){
							$freios .= '<tr><td colspan="6">' . $row->coluna6 . '</td></tr>';
							continue;
						}
						$freios .= '<tr><td class="item_atributo2">' . $row->coluna6 . '</td>';
						$freios .= '<td>' . $row->coluna7 . '</td>';
						$freios .= '<td>' . $row->coluna8 . '</td>';
						$freios .= '<td>' . $row->coluna9 . '</td>';
						$freios .= '<td>' . $row->coluna10 . '</td>';
						$freios .= '<td>' . $row->coluna11 . '</td></tr>';
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
		
		/*$content = str_replace($arr,$sub,$content);
		$myfile  = fopen('temp.html', 'w');
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