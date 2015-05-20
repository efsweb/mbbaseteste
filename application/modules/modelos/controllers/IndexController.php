<?php
class Modelos_IndexController extends Zend_Controller_Action{
    public function init(){
        $user = new Zend_Session_Namespace('usuario');
        $this->view->usuarionome = $user->info->nome_usuario;
        /*if($user->info->nome_usuario == ''){
            $this->_redirect('/');
        }*/
    }
    public function indexAction(){
        $usuario = new Model_UsuariosMapper();
        $this->view->menutopo = $usuario->loadmenu('mt_geral',1);
        //$this->_redirect('/modelos/fichatecnica/geral');
        $this->_redirect('/modelos/index2');
        $this->_helper->layout()->setLayout('modelos');

    }
    public function index2Action(){
        $usuario = new Model_UsuariosMapper();
        $this->view->menutopo = $usuario->loadmenu('mt_geral',1);
        $this->_helper->layout()->setLayout('modelos2');
        
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
        $this->view->modelos = $myarr;
    }
    public function registramodeloAction(){
        Zend_Layout::resetMvcInstance();
        $this->getHelper('viewRenderer')->setNoRender();
        $modeloid = new Zend_Session_Namespace('modeloselecionado');
        $mdid = $this->_getParam('id', $modeloid->id);
        if($mdid != $modeloid->id){
            $modeloid->id = $mdid;
        }
    }
    public function selectfamiliamodeloAction(){
        //Zend_Layout::resetMvcInstance();
        $modelo = new Zend_Session_Namespace('modeloselecionado');
        if(!isset($modelo->id)){
            $modelo->id = '106';
            $modelo->fm = 'Accelo';
        }
        if(!isset($modelo->fm)){
            $modelo->id = '106';
            $modelo->fm = 'Accelo';
        }
        $modelos = new Model_ModelosMapper();
        $this->view->familia = $modelos->lista();
        $this->view->modelos = $modelos->lista('modelo',$modelo->fm);
        $this->view->fmsel = $modelo->fm;
        $this->view->mdsel = key($this->view->modelos);
        if(array_key_exists($modelo->id, $this->view->modelos)){
            $this->view->mdsel = $modelo->id;
        }
    }
    public function selectfamiliamodelonovoAction(){
        //Zend_Layout::resetMvcInstance();
        $modelo = new Zend_Session_Namespace('modeloselecionado');
        if(!isset($modelo->id)){
            $modelo->id = '106';
        }
        $modelos = new Model_ModelosMapper();
        $familias = $modelos->lista();
        $myarr = array();
        $this->view->mdsel = 106;
        foreach ($familias as $key => $value) {
            $arr = $modelos->lista2('modelo',$value);
            array_push($myarr, $arr);
            if(array_key_exists($modelo->id, $arr)){
                $this->view->mdsel = $modelo->id;
            }
        }
        $this->view->modelos = $myarr;
        $this->view->fmsel = $modelo->fm;
    }
    public function selectmodelosAction(){
        Zend_Layout::resetMvcInstance();
        $this->getHelper('viewRenderer')->setNoRender();
        $familia = $this->_getParam('familia','Accelo');

        $modelo = new Zend_Session_Namespace('modeloselecionado');
        $modelo->fm = $familia;

        $modelos = new Model_ModelosMapper();
        $results = $modelos->lista('modelo',$familia);
        $modelo->id = key($results);
        echo json_encode($results);
    }
    public function loadclassificacaoAction(){
        Zend_Layout::resetMvcInstance();
        //$this->getHelper('viewRenderer')->setNoRender();
        $modelos = new Model_ModelosMapper();
        $results = $modelos->loadclassificacao();
        $this->view->class = $results;
        //echo json_encode($results);
    }
    public function loaditemengenhariaAction(){
        Zend_Layout::resetMvcInstance();
        //$this->getHelper('viewRenderer')->setNoRender();
        $modelos = new Model_ModelosMapper();
        $results = $modelos->loaditemengenharia();
        $this->view->class = $results;
        //echo json_encode($results);
    }
    public function getaliasdataAction(){
        Zend_Layout::resetMvcInstance();
        $this->getHelper('viewRenderer')->setNoRender();
        $id = $this->_getParam('id','');
        $modelos = new Model_ModelosMapper();
        $results = $modelos->getaliasdata($id);
        echo json_encode($results);
    }

    public function loadfiltrogrupoAction(){
        Zend_Layout::resetMvcInstance();
        //$this->getHelper('viewRenderer')->setNoRender();
        $modelos = new Model_ModelosMapper();
        $results = $modelos->loadfiltrogrupo();
        $this->view->class = $results;
        //echo json_encode($results);
    }

    public function loadfiltroclassificacaoAction(){
        Zend_Layout::resetMvcInstance();
        //$this->getHelper('viewRenderer')->setNoRender();
        $modelos = new Model_ModelosMapper();
        $results = $modelos->loadfiltroclassificacao();
        $this->view->class = $results;
        //echo json_encode($results);
    }
    
    public function testesAction(){
    	$this->_helper->layout()->setLayout('modelos');
    	$this->getHelper('viewRenderer')->setNoRender();
    	Zend_Layout::resetMvcInstance();
        $usuario = new Model_UsuariosMapper();
        $this->view->menutopo = $usuario->loadmenu('prn_modelos',1);
        print_r($this->view->menutopo);
    }
}
