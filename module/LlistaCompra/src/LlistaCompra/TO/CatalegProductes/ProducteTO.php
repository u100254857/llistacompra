<?php
namespace LlistaCompra\TO\CatalegProductes;

use Tipus;
use Tipus\String;
use Tipus\Integer;
use LlistaCompra\Model\CatalegProductes\Producte;
use LlistaCompra\TO\Supers\SupermercatTO;

class ProducteTO{
	public $id;
	public $nom;
	public $nombre;
	public $frequencia;
	public $darreraCompra;	
	public $supermercat;
	public $enCistella;
	public $seguentCompra;
		
	public function __construct(){
		$this->id=null;		
		$this->nom=null;
		$this->nombre=null;
		$this->frequencia=null;
		$this->darreraCompra=null;
		$this->enCistella=null;
		$this->seguentCompra=null;
	}
	
	public function convertir(Producte $p){		
		$this->id=$p->getId()->getInteger();
		$this->nom=$p->getNom()->getString();	
		$this->nombre=$p->getNombre()->getString();
		$this->frequencia=$p->getFrequencia()->getInteger();
		if ($p->getDarreraCompra()==null){			
			$this->darreraCompra="-";
		} else {
			$this->darreraCompra=$p->getDarreraCompra()->format("d/m/Y");
		}			
		$this->supermercat=new SupermercatTO();		
		if ($p->getSupermercat()!=null){
			$this->supermercat->convertir($p->getSupermercat());
		}
		$this->enCistella=$p->getEnCistella()->getBoolean();
		$this->seguentCompra=$p->seguentCompra();
	}
}