<?php
class Concorrentes_IndexController extends Zend_Controller_Action{
	public function init(){}
	public function indexAction(){
		$this->_helper->layout()->setLayout('construcao');
	}
}