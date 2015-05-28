<?php

namespace Sunsetlabs\EcommerceResourceBundle\Utils;

class Identifier 
{
	protected $id;

	public function __construct()
	{
		$this->id = array();
	}

	public function addPk($name, $key)
	{
		$this->id[$name] = $key;
	}

	public function getIdentifier(){
		return $this->id;
	}

	public function equals(Identifier $other)
	{
		$o = $other->getIdentifier();

		if (count($o) != count($this->id)){
			return false;
		}

		foreach ($this->id as $key => $value) {
			if (!isset($o[$key])){
				return false;
			}

			if ($value != $o[$key]){
				return false;
			}
		}
		return true;
	}
}