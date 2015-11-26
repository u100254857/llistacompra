<?php
namespace LlistaCompra\Model\Supers;

use LlistaCompra\Model\Supers\Supermercat;
use LlistaCompra\DAO\Supers\SupersDAO;
use Tipus\String;
use Tipus\Integer;
use LlistaCompra\Model\CatalegProductes\Cataleg;
use Negoci\Transaccio;
use LlistaCompra\Model\Configuracio\Usuari;

class Supers{	
	private $supersDAO;
	
	public function __construct(){		
		$this->supersDAO=new SupersDAO();
	}
	
	public function consultarSupermercat(Integer $id,Usuari $depenDe){
		return $this->supersDAO->consultarSupermercat($id,$depenDe->getId());
	}
		
	public function consultarLlistaSupermercats(Usuari $depenDe){
		return $this->supersDAO->consultarLlistaSupermercats($depenDe->getId());
	}
}