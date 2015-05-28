<?php

namespace Sunsetlabs\EcommerceResourceBundle\Interfaces\Order;

use Sunsetlabs\EcommerceResourceBundle\Interfaces\Order\OrderItemInterface;

interface OrderInterface
{
	public function getId();
	public function getState();
	public function setState($state);
	public function hasState($state);
	public function getNextState();
	public function getPrevState();
	public function isCanceld();
	public function cancel();
	public function getItems();
	public function addItem(OrderItemInterface $item);
	public function removeItem(OrderItemInterface $item, $all = true);
	public function hasItem(OrderItemInterface $item);
	public function clear();
	public function isEmpty();
}



