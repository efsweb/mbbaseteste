<?php
class Modelos_ComparativosController extends Zend_Controller_Action{
    public function init(){
    	$this->_helper->layout()->setLayout('modelos');
        $modelo = new Zend_Session_Namespace('modeloselecionado');
        $usuario = new Zend_Session_Namespace('usuario');
        $this->view->usuarionome = $usuario->usuario->nome_usuario;
        if(!isset($modelo->id)){
            $modelo->id = '106';
            $modelo->fm = 'Accelo';
        }
    }
    public function indexAction(){}
    public function geralAction(){
        $model    = new Model_Comparativos();
        $modeloid = new Zend_Session_Namespace('modeloselecionado');
        $mdid = $this->_getParam('id', $modeloid->id);
        if($mdid != $modeloid->id){
            $modeloid->id = $mdid;
        }
        $return   = $model->loadinicial($mdid);
        $modelos = array();
        $dados   = array();
        foreach($return as $item){
            if(empty($dados)){
                $dados   = $model->loaddados($modeloid->id,$item[0]);
            }
            $concorrente = $model->loaddados($modeloid->id,$item[0]);
            $modelos[$item[0]] = $concorrente;
        }
        
        $this->view->mbdados      = $dados;
    	$this->view->concorrentes = $return;
    	$this->view->modelos 	  = $modelos;
    }
    public function geralbkpAction(){
        $model    = new Model_Comparativos();
        $modeloid = new Zend_Session_Namespace('modeloselecionado');
        $mdid = $this->_getParam('id', $modeloid->id);
        if($mdid != $modeloid->id){
            $modeloid->id = $mdid;
        }
        $return   = $model->loadinicial($mdid);
        $modelos = array();
        $dados   = array();
        foreach($return as $item){
            if(empty($dados)){
                $dados   = $model->loaddados($modeloid->id,$item[0]);
            }
            $concorrente = $model->loaddados($modeloid->id,$item[0]);
            $modelos[$item[0]] = $concorrente;
        }
        
        $this->view->mbdados      = $dados;
        $this->view->concorrentes = $return;
        $this->view->modelos      = $modelos;
    }
    public function testeAction(){
        Zend_Layout::resetMvcInstance();
        $this->_helper->viewRenderer->setNoRender(true);
        $model    = new Model_Comparativos();
        $modeloid = new Zend_Session_Namespace('modeloselecionado');
        $mdid = $this->_getParam('id', $modeloid->id);
        if($mdid != $modeloid->id){
            $modeloid->id = $mdid;
        }
        $return   = $model->loadinicial($mdid);
        /*echo '<pre>';
        print_r($return);
        echo '</pre>';*/
        $modelos = array();
        foreach($return as $item){
            $concorrente = $model->loaddados($modeloid->id,$item[0]);
            $modelos[$item[0]] = $concorrente;
        }
        echo '<pre>';
        print_r($modelos);
        echo '</pre>';
        /*$dados    = $model->mbdados($modeloid->id);
        $this->view->mbdados      = $dados;
        $this->view->concorrentes = $return;
        $this->view->modelos      = $modelos;*/
    }
    public function itensconcorrentesAction(){}
    public function marcaconcorrenteAction(){}
    public function modelosconcorrentesAction(){}
    
}
