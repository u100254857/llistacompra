<?php
namespace LlistaCompra\View\Helper;
use Zend\View\Helper\AbstractHelper;
use Zend\Session\Container;
use LlistaCompra\Model\Configuracio\UsuariConnectat;

class ViewHelper extends AbstractHelper{
	
	public function __invoke(){
		$vhc=ViewHelperClass::getInstance();
		return $vhc;
	}	
}

class ViewHelperClass{
	private static $instancia;
	
	private function __construct(){
		
	}
	
	public static function getInstance(){
		if ( !self::$instancia instanceof self)
		{
			self::$instancia = new self;
		}
		return self::$instancia;
	}
	
	public static function getIdioma(){
		if (UsuariConnectat::estaConnectat() && UsuariConnectat::getUsuari()->getIdioma()->getString()=="C"){
			return "es_CA";
		} else {
			return "es_ES";
		}
	}

	public function esCatala(){
		return (UsuariConnectat::getUsuari()->getIdioma()->getString()=="C");
	}
}