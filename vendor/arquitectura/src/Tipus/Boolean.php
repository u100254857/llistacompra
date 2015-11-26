<?php
namespace Tipus;
class Boolean{
	private $b;
	
	public function __construct($valor){
		if (is_bool($valor)){
			$this->b=$valor;
		}		
	}
	
	public function getBoolean(){
		return $this->b;
	}
}