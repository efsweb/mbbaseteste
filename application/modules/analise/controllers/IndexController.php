<?php
class Analise_IndexController extends Zend_Controller_Action{
	public function init(){
		$this->_helper->layout()->setLayout('analise');
	}
	public function indexAction(){
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

	public function analiseAction(){
		
	}
}