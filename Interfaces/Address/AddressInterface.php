<?php

namespace Sunsetlabs\EcommerceResourceBundle\Interfaces\Address;

interface AddressInterface
{
	public function setPhone($phone);
	public function setStreet($street);
	public function getPhone();
	public function getStreet();	
}