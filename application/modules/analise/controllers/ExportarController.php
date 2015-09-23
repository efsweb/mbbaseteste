<?php
use google\appengine\api\cloud_storage\CloudStorageTools;

class Analise_ExportarController extends Zend_Controller_Action{
	public function init(){
		$this->_helper->layout()->setLayout('analise');
		$usuario = new Zend_Session_Namespace('usuario');
                $this->view->usuarionome = $usuario->usuario->nome_usuario;
                $this->view->versoes     = $usuario->versoes;
                $this->view->versaoatual = $usuario->va[1];
	}
	public function geracaoAction(){
		$model = new Model_ModelosMapper();
		$this->view->familias = $model->lista();
		$this->view->modelos  = array();
		foreach($this->view->familias as $familia){
			$this->view->modelos[$familia] = $model->lista('modelo',$familia);
		}
		$site = array();
		$graf = array();
                $this->view->listsite = '';
                $this->view->listgraf = '';
	}
	public function repositorioAction(){
                error_reporting(0);
                $usuario = new Zend_Session_Namespace('usuario');
                $v = 'v' . $usuario->va[0];
		if($handle = opendir('gs://mb-fichas-tecnicas/')){
                	while (false !== ($file = readdir($handle))){
                		$fl  = explode(' ',$file);
                		$pop = array_pop($fl);
                                $ini = explode('_',$file);
                                $ign = array_shift($ini);
                                if($ign == $v){
                        		if($pop === 'Site.pdf'){
                        			$site[] = array($file,$ini[0]);
                        		}elseif($pop === 'Grafica.pdf'){
                        			$graf[] = array($file,$ini[0]);
                        		}else{}
                                }
                	}
                }
                $this->view->listsite = $site;
                $this->view->listgraf = $graf;
	}
	public function testAction(){
		Zend_Layout::resetMvcInstance();
        $this->_helper->viewRenderer->setNoRender(true);
        if($handle = opendir('gs://mb-fichas-tecnicas/')){
        	while (false !== ($file = readdir($handle))){
        		echo $file . '</br>';
        	}
        }
	}

}