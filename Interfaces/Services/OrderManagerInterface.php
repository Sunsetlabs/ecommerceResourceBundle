<?php

namespace Sunsetlabs\EcommerceResourceBundle\Interfaces\Services;

interface OrderManagerInterface
{
	public function getOrder($id);
	public function getNewOrder();
	public function changeStateTo($id, $state);
	public function cancelOrder($id);
	public function getItems($id);
}
