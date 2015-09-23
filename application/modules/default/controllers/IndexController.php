<?php
class IndexController extends Zend_Controller_Action{
    public function init(){}
    public function indexAction(){
        $this->_helper->layout()->setLayout('login');
        $err = new Zend_Session_Namespace('login_error');
        if($err->login_error){
            $err->login_error = null;
            unset($err->login_error);
            unset($err);
            Zend_Auth::getInstance()->clearIdentity();
            Zend_Session::forgetMe();
            $this->view->loginfail = 1;
        }else{
            $this->view->loginfail = null;
        }
    }
    public function mnutopoAction(){
        $this->_helper->layout()->setLayout('default');
        $menu = new Model_UsuariosMapper();
        $this->view->menu = $menu->loadmenu('mt_geral', '1');
    }
    public function mnuesquerdoAction(){
        $this->_helper->layout()->setLayout('default');
        $menu = new Model_UsuariosMapper();
        $this->view->menu = $menu->loadmenu('prn_modelos', '1');
    }
    public function mnufamiliaAction(){
        Zend_Layout::resetMvcInstance();
        echo 'teste';
        $modelos = new Model_ModelosMapper();
        $this->view->familia = $modelos->lista();
        print_r($this->view->familia);
        /*$this->view->modelos = array();
        foreach($this->view->familia as $k => $v){
            $this->view->modelos[$v] = $modelos->lista('modelo',$v);
        }*/
    }
    public function loginAction(){
        Zend_Layout::resetMvcInstance();
        $this->_helper->viewRenderer->setNoRender(true);
        //echo $_SERVER['SERVER_ADDR'];
        $login = $this->_getParam('login', null);
        $pass = $this->_getParam('senha', null);
        if(trim($login) == '' || trim($pass) == ''){
            $err = new Zend_Session_Namespace('login_error');
            $err->login_error = 1;
            echo '<script>window.history.back();</script>';
        }else{
            $arr = array('login' => $login, 'pass' => $pass);
            $auth = new SC_Plugins_Authenticator();
            $result = $auth->getCredentials($arr);
            //echo 'Login: "' . $login . '"';
            //print_r($result);
            if(is_null($result)){
                $err = new Zend_Session_Namespace('login_error');
                $err->login_error = 1;
                echo '<script>window.history.back();</script>';
            }else{
                $versoes = new Model_VersaoMapper();
                $usuario = new Zend_Session_Namespace('usuario');
                $usuario->usuario = $result;
                $usuario->versoes = $versoes->loadversao();
                $usuario->va      = $usuario->versoes[0];
                $this->_redirect('/modelos/index2');
            }
        }
    }
    public function logoutAction(){
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        //Zend_Session::destroy();
        Zend_Session::namespaceUnset('usuario');
        Zend_Session::namespaceUnset('modeloselecionado');
        $this->_redirect('/');
    }
    public function recoveryAction(){
        Zend_Layout::resetMvcInstance();
        //$this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $login = $this->_getParam('emailsend', null);
        $usuario = new Model_Usuarios();
        $usermap = new Model_UsuariosMapper();
        $usermap->find($login,$usuario);
        if($usuario->getNome()){
            $utils = new SC_Plugins_Utils();
            echo "no if";
        }
        /*echo $usuario->getNome();
        print_r($usuario);*/
    }
    /**
     * Função que altera a versão do sistema
     * Criado por: Eliel Fernandes
     * Criado em: 14/08/2015
     * Versão: 1.0.0
     */
    public function changeversionAction(){
        Zend_Layout::resetMvcInstance();
        $this->_helper->viewRenderer->setNoRender(true);
        $versao  = $this->getRequest()->getParam('id','');
        $usuario = new Zend_Session_Namespace('usuario');
        $k = 0;
        foreach($usuario->versoes as $key => $row){
            if(in_array($versao, $row)){
                $k = $key;
            }
        }
        $usuario->va = $usuario->versoes[$k];
        echo 'OK';
        //print_r($usuario->va);
    }
}
