<?php
class Analise_AliasController extends Zend_Controller_Action{
	public function init(){
		$this->_helper->layout()->setLayout('analise');
        $usuario = new Zend_Session_Namespace('usuario');
        $this->view->usuarionome = $usuario->usuario->nome_usuario;
        $this->view->versoes     = $usuario->versoes;
        $this->view->versaoatual = $usuario->va[1];
	}

	public function geralAction(){}
    public function modelosAction(){}

    public function mnuesquerdoAction(){
        Zend_Layout::resetMvcInstance();
        $menu = new Model_UsuariosMapper();
        $this->view->menu = $menu->loadmenu('prn_analise', '1');
    }

    public function resumoAction(){
        $model    = new Model_Comparativos();
        $modeloid = new Zend_Session_Namespace('modeloselecionado');
        $usuario = new Zend_Session_Namespace('usuario');
        $mdid = $this->_getParam('id', $modeloid->id);
        if($mdid != $modeloid->id){
            $modeloid->id = $mdid;
        }
        $return   = $model->loadinicial($mdid,$usuario->va[0]);
        $modelos = array();
        $dados   = array();
        foreach($return as $item){
            if(empty($dados)){
                $dados   = $model->loaddados($modeloid->id,$item[0],$usuario->va[0]);
            }
            $concorrente = $model->loaddados($modeloid->id,$item[0],$usuario->va[0]);
            $modelos[$item[0]] = $concorrente;
        }
        
        $this->view->mbdados      = $dados;
        $this->view->concorrentes = $return;
        $this->view->modelos      = $modelos;
    }
}