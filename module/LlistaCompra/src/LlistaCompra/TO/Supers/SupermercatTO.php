<?php
namespace LlistaCompra\TO\Supers;

use Tipus;
use Tipus\String;
use Tipus\Integer;
use LlistaCompra\Model\Supers\Supermercat;
use LlistaCompra\TO\CatalegProductes\ProducteTO;

class SupermercatTO{
	public $id;
	public $nom;
	public $productes;
		
	public function __construct(){
		$this->id=null;
		$this->nom=null;
		$this->productes=[];
	}
	
	public function convertir(Supermercat $s){		
		$this->id=$s->getId()->getInteger();
		$this->nom=$s->getNom()->getString();	
	}
	
	public function afegirProducte(ProducteTO $pto){
		$this->productes[]=$pto;
	}
}