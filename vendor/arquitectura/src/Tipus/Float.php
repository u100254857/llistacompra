<?php
namespace Tipus;
class Float{
	private $f;
	
	public function __construct($valor){
		if (is_float($valor)){
			$this->f=$valor;
		}		
	}
	
	public function getFloat(){
		return $this->f;
	}
}