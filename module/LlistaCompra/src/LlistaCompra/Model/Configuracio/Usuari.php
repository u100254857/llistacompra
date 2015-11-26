<?php
namespace LlistaCompra\Model\Configuracio;

use Tipus;
use Tipus\String;
use Tipus\Integer;


class Usuari{
	private $id;
	private $telefon;
	private $idioma;
	private $depenDe;
		
	public function getId(){
		return $this->id;
	}
	
	public function getTelefon(){
		return $this->telefon;
	}
	
	public function getIdioma(){
		return $this->idioma;
	}
	
	public function getDepenDe(){
		return $this->depenDe;
	}
	
	public function setId(Integer $id){
		$this->id=$id;			
	}
	
	public function setTelefon(Integer $telefon){
		$this->telefon=$telefon;
	}

	public function setIdioma(String $idioma){		
			$this->idioma=$idioma;					
	}	
	
	public function setDepenDe(Usuari $u){
		$this->depenDe=$u;
		if (empty($u->getId()->getInteger())){
			$this->depenDe=$this;
		}		
	}
	
}