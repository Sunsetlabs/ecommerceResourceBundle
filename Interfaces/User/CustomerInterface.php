<?php

namespace Sunsetlabs\EcommerceResourceBundle\Interfaces\User;

use Sunsetlabs\EcommerceResourceBundle\Interfaces\User\UserInterface;
use Sunsetlabs\EcommerceResourceBundle\Interfaces\Address\AddressInterface;

interface CustomerInterface
{
	public function getUser();
	public function getFirstName();
	public function getLastName();
	public function getAddresses();
	public function setUser(UserInterface $user);
	public function setFirstName($first_name);
	public function setLastName($last_name);
	public function addAddress(AddressInterface $address);
	public function removeAddress(AddressInterface $address);
}


