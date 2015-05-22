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
    	$content = file_get_contents('modelos_ficha/modelo_grafica.html');
    	$ficha = new Model_FichaTecnica();
    	echo 'funcionando'; //$ficha->loadData('loadinicial','');
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