<?php
class Modelos_FTCabinaController extends Zend_Controller_Action{
	public function saveAction(){
		Zend_Layout::resetMvcInstance();
        $this->_helper->viewRenderer->setNoRender(true);
	}
	public function deleteAction(){}
}