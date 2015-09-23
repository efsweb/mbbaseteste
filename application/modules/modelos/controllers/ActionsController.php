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
        $nome_do_arquivo    = $this->getRequest()->getParam('nome_do_arquivo', '');
        $usuario = new Zend_Session_Namespace('usuario');
        $modelo  = new Zend_Session_Namespace('modeloselecionado');
        $model   = new Model_Comentarios();

    	$model = new Model_Geralft();
    	$return = $model->atualizar($modelo->id,$complemento, $tracao, $classificacao, $aplicacao, $b09, $data_da_publicacao, $nome_do_arquivo, $usuario->va[0]);
    	echo json_encode($return);
        //echo $modelo->id . ' - ' . $complemento . ' - ' . $tracao . ' - ' . $classificacao . ' - ' . $aplicacao . ' - ' . $b09 . ' - ' . $data_da_publicacao;
    }

    public function savecomentariosAction(){
        $arr     = $this->getRequest()->getParam('lines');
        $pg      = $this->getRequest()->getParam('pg');
        $model   = new Model_FTMapper();
        $idmodel = new Zend_Session_Namespace('modeloselecionado');
        $usuario = new Zend_Session_Namespace('usuario');
        $return  = $model->atualizar($idmodel->id,$arr,$pg,$usuario->va[0]);
        echo json_encode($return);
    }
    public function savenotafinalAction(){
        $comment01 = $this->getRequest()->getParam('c1');
        $comment02 = $this->getRequest()->getParam('c2');
        
        $modeloid = new Zend_Session_Namespace('modeloselecionado');
        $usuario  = new Zend_Session_Namespace('usuario');
        $model    = new Model_Comentarios();
        $return   = $model->atualizar($modeloid->id,$comment01, $comment02,$usuario->va[0]);
        echo json_encode($return);
    }

    /*public function savedimensoesAction(){
        $arr     = $this->getRequest()->getParam('lines');
        $pg      = $this->getRequest()->getParam('pg');
        $model   = new Model_Dimensoes();
        $idmodel = new Zend_Session_Namespace('modeloselecionado');
        $return  = $model->atualizar($idmodel->id,$arr,$pg);
        print_r($return);
    }*/

    /**
     * Função que salva os dados dos seguintes agrupamentos de ficha técnica
     * (Dimensões, Pesos, Pesos Admissíveis, Cabina, Motor, Sistema Elétrico, Transmissão, Eixos)
     * (Chassis, Desempenho e Freios)
     * 
     */
    public function saveftAction(){
        $arr     = $this->getRequest()->getParam('lines');
        $pg      = $this->getRequest()->getParam('pg');
        $model   = new Model_FTMapper();
        $idmodel = new Zend_Session_Namespace('modeloselecionado');
        $usuario = new Zend_Session_Namespace('usuario');
        $return  = $model->atualizar($idmodel->id,$arr,$pg,$usuario->va[0]);
        print_r($return);
    }

    public function savealiasAction(){
        $a = $this->getRequest()->getParam('param_id_alias');
        $b = $this->getRequest()->getParam('param_id_classificacao');
        $c = $this->getRequest()->getParam('param_desc_alias');
        $d = $this->getRequest()->getParam('param_finalidade');
        $e = $this->getRequest()->getParam('param_tipo');
        $f = $this->getRequest()->getParam('param_item_vinculado');
        $g = $this->getRequest()->getParam('param_nivel_item_vinculado');
        $usuario  = new Zend_Session_Namespace('usuario');
        $model   = new Model_ModelosMapper();
        $return  = $model->savealias($a, $c, $d, $e, $f, $g,$usuario->va[0]);
        $deleted = $model->delclasi($return,$usuario->va[0]);
        $gravado = $model->saveclasi($return,$b,$usuario->va[0]);
        echo json_encode($gravado);
        //print_r($gravado);
    }

    public function savecomparativosAction(){
        $itens    = $this->getRequest()->getParam('comparativos');
        $idmodel  = new Zend_Session_Namespace('modeloselecionado');
        $usuario  = new Zend_Session_Namespace('usuario');
        $modelo   = new Model_Comparativos();
        //echo count($itens);
        $concorrentes = array();
        foreach($itens as $k => $v){
            $pieces = explode(',',$v);
            $x = $pieces[0];
            $exclude   = $modelo->clearBeforeSave($idmodel->id,$x,$usuario->va[0],$pieces[1]);
            $concorrentes[$x][] = $v;
        }
        //print_r($concorrentes);
        foreach($concorrentes as $cp => $lns){
            $vlr = explode(',',$lns[0]);
            //echo $vlr[1];
            $resultado = $modelo->addConcorrenteLine($idmodel->id,$cp,$lns,$usuario->va[0]);
            print_r($resultado);
        }
    }

    public function saveupgeralAction(){
        $idmodel  = new Zend_Session_Namespace('modeloselecionado');
        $usuario  = new Zend_Session_Namespace('usuario');
        $linhas   = $this->getRequest()->getParam('linhas');
        $modelo   = new Model_UP();
        $exclude  =  $modelo->clearBeforeSave($idmodel->id,$usuario->va[0]);
        $resultado = $modelo->savegeral($idmodel->id,$linhas,$usuario->va[0]);
        echo json_encode($resultado);
    }

    public function saveupitemAction(){
        $idmodel  = new Zend_Session_Namespace('modeloselecionado');
        $usuario  = new Zend_Session_Namespace('usuario');
        $linhas   = $this->getRequest()->getParam('linhas');
        $modelo   = new Model_UP();
        $exclude  =  $modelo->clearItemBeforeSave($idmodel->id,$usuario->va[0]);
        $result   = $modelo->saveItem($idmodel->id, $linhas,$usuario->va[0]);
        print_r($result);
    }

}