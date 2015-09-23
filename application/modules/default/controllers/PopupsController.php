<?php
/**
 * Esta classe tem por objetivo controlar todos os popups do sistema
 * Criado por Eliel Fernandes
 * Criado em: 06/08/2015
 * Versão 1.0.0
 */
class PopupsController extends Zend_Controller_Action{
    public function init(){}

    /**
     * Controla o popup de Alias (Busca / Edita e Cria)
     * Criado por: Eliel Fernandes
     * Criado em: 06/08/2015
     * Versão 1.0.0
     */
    public function buscaealiasAction(){
        Zend_Layout::resetMvcInstance();
    }
    /**
     * Controla o popup de UP
     * Criado por: Eliel Fernandes
     * Criado em: 06/08/2015
     * Versão 1.0.0
     */
    public function upconteudoAction(){
        Zend_Layout::resetMvcInstance();
    }
    /**
     * Controla o popup de WA
     * Criado por: Eliel Fernandes
     * Criado em: 06/08/2015
     * Versão 1.0.0
     */
    public function waconteudoAction(){
        Zend_Layout::resetMvcInstance();
    }
    /**
     * Controla o popup de foto do WA
     * Criado por: Eliel Fernandes
     * Criado em: 06/08/2015
     * Versão 1.0.0
     */
    public function wafotoAction(){
        Zend_Layout::resetMvcInstance();
    }
}
