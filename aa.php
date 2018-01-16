<?php
class Animal {  
	private $dog = 'dog';  
	public function __call($name,$args){
		if(is_callable($this->$name))
			return call_user_func($this->$name,$args);
	}
	public function __set($name, $value) {  
		$this->$name = is_callable($value)?   
			$value->bindTo($this, $this):   
			$value;  
	}  
}  

$animal = new Animal;  

$animal->getdog = function() {  
	return $this->dog;  
};  

echo $animal->getdog();  
