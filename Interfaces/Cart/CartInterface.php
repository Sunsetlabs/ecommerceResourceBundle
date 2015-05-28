<?php

namespace Sunsetlabs\EcommerceResourceBundle\Interfaces\Cart;

use Sunsetlabs\EcommerceResourceBundle\Interfaces\Cart\CartItemInterface;

interface CartInterface
{
	public function getId();
	public function getItems();
	public function addItem(CartItemInterface $item);
	public function removeItem(CartItemInterface $item, $all = true);
	public function hasItem(CartItemInterface $item);
	public function getItem(CartItemInterface $item);
	public function clear();
	public function isEmpty();
}



