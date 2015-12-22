<?php
namespace LlistaCompra\Model\CatalegProductes;

use LlistaCompra\Model\CatalegProductes\Producte;
use LlistaCompra\DAO\CatalegProductes\CatalegDAO;
use Tipus\String;
use Tipus\Integer;
use LlistaCompra\Model\Configuracio\Usuari;
use DateTime;
use Tipus\Boolean;
use LlistaCompra\Model\Supers\Supermercat;

class Cataleg{	
	private $catalegDAO;
	
	public function __construct(){		
		$this->catalegDAO=new CatalegDAO();
	}
	
	public function consultarProducte(Integer $id,Usuari $depenDe){
		$query=new String("ID=".$id->getInteger());
		return $this->catalegDAO->consultarProducte($query,$depenDe->getId());
	}
	
	public function consultarProducteNom(String $nom, Usuari $depenDe){
		$query=new String("LOWER(NOM)=LOWER('".$nom->getString()."')");
		return $this->catalegDAO->consultarProducte($query, $depenDe->getId());
	}
	
	public function consultarProducteNombre(String $nombre, Usuari $depenDe){
		$query=new String("LOWER(NOMBRE)=LOWER('".$nombre->getString()."')");
		return $this->catalegDAO->consultarProducte($query, $depenDe->getId());
	}
	
	public function esborrarProductesSupermercat(Integer $s,Usuari $depenDe){
		$this->catalegDAO->esborrarProductesSupermercat($s,$depenDe->getId());
	}
	
	public function consultarProductesSupermercat(Integer $s,Usuari $depenDe){
		return $this->catalegDAO->consultarLlistaProductesSupermercat($s,$depenDe->getId());
	}
	
	public function consultarLlistaProductes(Usuari $depenDe){
		return $this->catalegDAO->consultarLlistaProductes($depenDe->getId());
	}
	
	public function consultarProductesCistella(Usuari $depenDe){
		return $this->catalegDAO->consultarProductesCistella($depenDe->getId());
	}
			
}