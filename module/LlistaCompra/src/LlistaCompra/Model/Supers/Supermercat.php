<?php
namespace LlistaCompra\Model\Supers;

use Tipus;
use Tipus\String;
use Tipus\Integer;
use LlistaCompra\DAO\Supers\SupermercatDAO;
use LlistaCompra\Model\Configuracio\Usuari;
use Negoci\Transaccio;
use LlistaCompra\Model\CatalegProductes\Cataleg;

class Supermercat{
	private $id;
	private $nom;
	private $supermercatDAO;

	public function __construct(){
		$this->id=null;
		$this->nom="";
		$this->supermercatDAO=new SupermercatDAO();
	}
	
	public function getId(){
		return $this->id;
	}
	
	public function getNom(){
		return $this->nom;
	}
	
	public function setId(Integer $id){
		$this->id=$id;			
	}
	
	public function setNom(String $nom){
		$this->nom=$nom;
	}
	
	public function guardar(Integer $id,String $nom,Usuari $depenDe){
		$this->setNom($nom);
		if ($id->getInteger()!=null){
			$this->setId($id);
		}
		return $this->supermercatDAO->guardar($this,$depenDe->getId());
	}
	
	public function esborrar(Usuari $depenDe){
		try{
			$t=new Transaccio();
			$cp=new Cataleg();
			$cp->esborrarProductesSupermercat($this->getId(),$depenDe);
			$this->supermercatDAO->esborrar($this,$depenDe->getId());				
			$t->confirmar();				
		} catch (\Exception $e){
			$t->desfer();
			throw $e;
		}
	}

}