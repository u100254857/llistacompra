<?php
namespace LlistaCompra\Model\CatalegProductes;

use Tipus;
use Tipus\String;
use Tipus\Integer;
use DateTime;
use DateInterval;
use LlistaCompra\Model\Supers\Supermercat;
use Tipus\Boolean;
use LlistaCompra\DAO\CatalegProductes\ProducteDAO;
use LlistaCompra\Model\Configuracio\Usuari;

class Producte{
	private $id;
	private $supermercat;
	private $nom;
	private $nombre;
	private $frequencia;
	private $penultimaFrequencia;
	private $darreraCompra;
	private $penultimaCompra;
	private $enCistella;
	private $copsComprat;
	private $producteDAO;
		
	public function __construct(){
		$this->id=null;
		$this->supermercat=null;
		$this->nom=null;
		$this->nombre=null;
		$this->frequencia=null;
		$this->darreraCompra=null;
		$this->enCistella=null;
		$this->copsComprat=null;
		$this->producteDAO=new ProducteDAO();		
	}
	
	public function getId(){
		return $this->id;
	}
	
	public function getSupermercat(){
		return $this->supermercat;
	}
	
	public function getNom(){
		return $this->nom;
	}
	
	public function getNombre(){
		return $this->nombre;
	}
	
	public function getFrequencia(){
		return $this->frequencia;
	}
	
	public function getPenultimaFrequencia(){
		return $this->penultimaFrequencia;
	}
		
	public function getDarreraCompra(){
		return $this->darreraCompra;	
	}	
	
	public function getPenultimaCompra(){
		return $this->penultimaCompra;
	}
	
	public function getEnCistella(){
		return $this->enCistella;
	}
			
	public function seguentCompra(){
		if (empty($this->darreraCompra) || empty($this->frequencia)){
			return 0;
		} else {
			$avui=new DateTime();
			$avui=$avui->setTime(0,0,0);
			$freq=$this->frequencia->getInteger();
			if (empty($freq)){
				$freq=0;
			}
			
			$sc=$this->darreraCompra->add(new DateInterval("P".$freq."D"));
			$scd=$avui->diff($sc);
			$dies=$scd->days;
			if ($avui<=$sc){
				return $dies;
			} else {				
				return $dies*(-1);		
			}
						
		}
	}
	
	public function getCopsComprat(){
		return $this->copsComprat;
	}
	
	public function setId(Integer $id){
		$this->id=$id;			
	}
	
	public function setSupermercat(Supermercat $s){
		$this->supermercat=$s;
	}
	
	public function setNom(String $nom){
		$this->nom=$nom;
	}

	public function setNombre(String $nombre){		
			$this->nombre=$nombre;					
	}	
	
	public function setFrequencia(Integer $frequencia){
		$this->frequencia=$frequencia;
	}
		
	public function setPenultimaFrequencia(Integer $penultimaFrequencia){
		$this->penultimaFrequencia=$penultimaFrequencia;
	}
		
	public function setDarreraCompra(DateTime $darreraCompra){
		$this->darreraCompra=$darreraCompra;
	}
	
	public function setPenultimaCompra(DateTime $penultimaCompra){
		$this->penultimaCompra=$penultimaCompra;
	}
	
	public function setEnCistella(Boolean $ec){
		$this->enCistella=$ec;
	}
	
	public function setCopsComprat(Integer $copsComprat){
		$this->copsComprat=$copsComprat;
	}
	
	public function guardar(Integer $id,Supermercat $super,String $nom,String $nombre,Usuari $depenDe){			
		$this->setSupermercat($super);
		$this->setNom($nom);
		$this->setNombre($nombre);
		if ($id->getInteger()==null){
			$this->setEnCistella(new Boolean(false));
			$this->setFrequencia(new Integer(0));
			$this->setCopsComprat(new Integer(0));
		} else {
			$this->setId($id);
		}		
		return $this->producteDAO->guardar($this,$depenDe->getId());
	}
	
	public function eliminar(Usuari $depenDe){		
		$this->producteDAO->esborrar($this,$depenDe->getId());		
	}
	
	public function afegirCistella(Usuari $depenDe){
		$this->setEnCistella(new Boolean(true));		
		$this->producteDAO->guardar($this, $depenDe->getId());
	}

	public function treureCistella(Usuari $depenDe){
		$this->setEnCistella(new Boolean(false));
		$this->producteDAO->guardar($this, $depenDe->getId());
	}
	
	public function comprar(Usuari $depenDe){
		$ara=new DateTime();
		$ara=$ara->setTime(0,0,0);
		$darreraCompra=$this->getDarreraCompra();
		$interval=0;
		$copsComprat=$this->getCopsComprat()->getInteger();
		$copsComprat++;		
		$this->setCopsComprat(new Integer($copsComprat));
		if ($darreraCompra!=null){
			$this->setPenultimaCompra($darreraCompra);
			$interval=date_diff($ara,$darreraCompra);
			$interval=$interval->format("%d");
		};
		$this->setEnCistella(new Boolean(false));
		$this->setDarreraCompra($ara);
		$this->setPenultimaFrequencia($this->getFrequencia());
		$novaFreq=($this->getFrequencia()->getInteger()+$interval)/($this->getCopsComprat()->getInteger());		
		$this->setFrequencia(new Integer($novaFreq));			
		$this->producteDAO->guardar($this,$depenDe->getId());
	}
	
	public function retornar(Usuari $depenDe){		
		$penultimaFrequencia=$this->getPenultimaFrequencia();
		$this->setEnCistella(new Boolean(true));
		$this->darreraCompra=$this->penultimaCompra;		
		$this->setFrequencia($penultimaFrequencia);
		$copsComprat=$this->getCopsComprat()->getInteger();
		$copsComprat--;
		$this->setCopsComprat(new Integer($copsComprat));		
		$this->producteDAO->guardar($this,$depenDe->getId());
	}
	
}