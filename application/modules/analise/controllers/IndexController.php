<?php
class Analise_IndexController extends Zend_Controller_Action{
	public function init(){
		$this->_helper->layout()->setLayout('analise');
        $usuario = new Zend_Session_Namespace('usuario');
        $this->view->usuarionome = $usuario->usuario->nome_usuario;
        $this->view->versoes     = $usuario->versoes;
        $this->view->versaoatual = $usuario->va[1];
	}
	public function indexAction(){
        $this->_redirect('/analise/alias/geral');
		/*$this->_helper->layout()->setLayout('modelos2');
		$modelo = new Zend_Session_Namespace('modeloselecionado');
        if(!isset($modelo->id)){
            $modelo->id = '106';
        }
        $modelos = new Model_ModelosMapper();
        $familias = $modelos->lista();
        $myarr = array();
        foreach ($familias as $key => $value) {
            $arr = $modelos->lista2('modelo',$value);
            array_push($myarr, $arr);
            $this->view->mdsel = key($arr);
            if(array_key_exists($modelo->id, $arr)){
                $this->view->mdsel = $modelo->id;
            }
        }
        $this->view->modelos = $myarr;*/
	}

	public function analiseAction(){}
    public function modelosAction(){}

    public function mnuesquerdoAction(){
        Zend_Layout::resetMvcInstance();
        $menu = new Model_UsuariosMapper();
        $this->view->menu = $menu->loadmenu('prn_analise', '1');
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
}