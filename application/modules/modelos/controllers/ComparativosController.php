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
    public function resumoAction(){
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
    public function cabinaAction(){
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
    public function motorAction(){
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
    public function cambioAction(){
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
    public function embreagemAction(){
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
    public function eixotraseiroAction(){
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
    public function pneusAction(){
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
    public function freiosAction(){
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
    public function retardadorAction(){
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
    public function suspensaodianteiraAction(){
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
    public function suspensaotraseiraAction(){
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
    public function chassisAction(){
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
    public function capacidadeAction(){
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
    public function garantiaAction(){
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
    
}
