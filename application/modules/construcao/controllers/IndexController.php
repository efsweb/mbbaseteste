<?php
class Analise_IndexController extends Zend_Controller_Action{
	public function init(){
		$this->_helper->layout()->setLayout('construcao');
	}
	public function indexAction(){
        $this->_helper->layout()->setLayout('construcao');
	}
}