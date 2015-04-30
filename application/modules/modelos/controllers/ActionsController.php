<?php
class Modelos_ActionsController extends Zend_Controller_Action{
    public function init(){
		Zend_Layout::resetMvcInstance();
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function savegeralAction(){
    	$complemento 		= $this->getRequest()->getParam('complemento', ''); 
    	$tracao 			= $this->getRequest()->getParam('tracao', ''); 
    	$classificacao 		= $this->getRequest()->getParam('classificacao', ''); 
    	$aplicacao 			= $this->getRequest()->getParam('aplicacao', ''); 
    	$b09 				= $this->getRequest()->getParam('b09', ''); 
    	$data_da_publicacao = $this->getRequest()->getParam('data_da_publicacao', '');
        
        $modelo = new Zend_Session_Namespace('modeloselecionado');
        $model = new Model_Comentarios();

    	$model = new Model_Geralft();
    	$return = $model->atualizar($modelo->id,$complemento, $tracao, $classificacao, $aplicacao, $b09, $data_da_publicacao);
    	echo json_encode($return);
        //echo $modelo->id . ' - ' . $complemento . ' - ' . $tracao . ' - ' . $classificacao . ' - ' . $aplicacao . ' - ' . $b09 . ' - ' . $data_da_publicacao;
    }

    public function savecomentariosAction(){
        $comment01 = $this->getRequest()->getParam('c1');
        $comment02 = $this->getRequest()->getParam('c2');
        
        $modeloid = new Zend_Session_Namespace('modeloselecionado');
        $model = new Model_Comentarios();
        $return = $model->atualizar($modeloid->id,$comment01, $comment02);
        echo json_encode($return);
    }

    public function savedimensoesAction(){
        $arr     = $this->getRequest()->getParam('lines');
        $pg      = $this->getRequest()->getParam('pg');
        $model   = new Model_Dimensoes();
        $idmodel = new Zend_Session_Namespace('modeloselecionado');
        $return  = $model->atualizar($idmodel->id,$arr,$pg);
        echo json_encode($return);
    }

    public function savealiasAction(){
        $a = $this->getRequest()->getParam('param_id_alias');
        $b = $this->getRequest()->getParam('param_id_classificacao');
        $c = $this->getRequest()->getParam('param_desc_alias');
        $d = $this->getRequest()->getParam('param_finalidade');
        $e = $this->getRequest()->getParam('param_tipo');
        $f = $this->getRequest()->getParam('param_item_vinculado');
        $g = $this->getRequest()->getParam('param_nivel_item_vinculado');
        $model   = new Model_ModelosMapper();
        $return  = $model->savealias($a, $c, $d, $e, $f, $g);
        $deleted = $model->delclasi($return);
        $gravado = $model->saveclasi($return,$b);
        echo json_encode($gravado);
        //print_r($gravado);
    }

    public function savecomparativosAction(){
        $itens    = $this->getRequest()->getParam('comparativos');
        $idmodel  = new Zend_Session_Namespace('modeloselecionado');
        $modelo   = new Model_Comparativos();
        //echo count($itens);
        $concorrentes = array();
        foreach($itens as $k => $v){
            $pieces = explode(',',$v);
            $x = $pieces[0];
            $concorrentes[$x][] = $v;
        }
        foreach($concorrentes as $cp => $lns){
            $exclude   = $modelo->clearBeforeSave($idmodel->id,$cp);
            $resultado = $modelo->addConcorrenteLine($idmodel->id,$cp,$lns);
            print_r($resultado);
        }
    }

    public function saveupgeralAction(){
        $idmodel  = new Zend_Session_Namespace('modeloselecionado');
        $linhas   = $this->getRequest()->getParam('linhas');
        $modelo   = new Model_UP();
        $exclude  =  $modelo->clearBeforeSave($idmodel->id);
        $resultado = $modelo->savegeral($idmodel->id,$linhas);
        echo json_encode($resultado);
    }

    public function saveupitemAction(){
        $idmodel  = new Zend_Session_Namespace('modeloselecionado');
        $linhas   = $this->getRequest()->getParam('linhas');
        $modelo   = new Model_UP();
        $exclude  =  $modelo->clearItemBeforeSave($idmodel->id);
        $result   = $modelo->saveItem($idmodel->id, $linhas);
        print_r($result);
    }

}