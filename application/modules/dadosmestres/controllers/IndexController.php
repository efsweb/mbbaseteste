<?php
class Dadosmestres_IndexController extends Zend_Controller_Action{
	public function init(){
        $this->_helper->layout()->setLayout('dadosmestres');
        $usuario = new Zend_Session_Namespace('usuario');
        $this->view->usuarionome = $usuario->usuario->nome_usuario;
        $this->view->versoes     = $usuario->versoes;
        $this->view->versaoatual = $usuario->va[1];
	}
	public function indexAction(){
		$this->_redirect('/dadosmestres/comercial/alias');
	}
	public function mnuesquerdoAction(){
        $menu = new Model_UsuariosMapper();
        $this->view->menu = $menu->loadmenu('prn_dados_mestres', '1');
	}
	public function selectfamiliamodeloAction(){
        $modelos = new Model_ModelosMapper();
        $this->view->familia = $modelos->lista();
    }
}