<?php
namespace Tipus;
class Integer{
	private $i;
	
	public function __construct($valor){
		if (is_numeric($valor)){
			$this->i=$valor;
		}		
	}
	
	public function getInteger(){
		return $this->i;
	}
}