<?php
class Dadosmestres_IndexController extends Zend_Controller_Action{
	public function init(){
        $user = new Zend_Session_Namespace('usuario');
        $this->view->usuarionome = $user->info->nome_usuario;
        $this->_helper->layout()->setLayout('dadosmestres');
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