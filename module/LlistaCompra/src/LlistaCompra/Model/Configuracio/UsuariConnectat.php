<?php
namespace LlistaCompra\Model\Configuracio;

use LlistaCompra\Model\Configuracio\Usuari;
use Zend\Session\Container;

class UsuariConnectat{

	private function __construct(){
		
	}
		
	public static function setUsuari(Usuari $u){
		$session=new Container('llista_compra');
		$session->usuari=$u;
	}
	
	public static function getUsuari(){		
		$session=new Container('llista_compra');
		return $session->usuari;
	}
	
	public static function estaConnectat(){
		$session=new Container('llista_compra');
		return !empty($session->usuari);
	}
	
	public static function desconnectar(){
		$session=new Container('llista_compra');
		$session->usuari=null;
	}
}