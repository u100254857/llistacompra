<?php
namespace Tipus;
class String{
	private $s;
	
	public function __construct($valor){
		if (is_string($valor)){
			$this->s=$valor;
		}		
	}
	
	public function getString(){
		return $this->s;
	}
}