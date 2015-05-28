<?php

namespace Sunsetlabs\EcommerceResourceBundle\Interfaces\Services;

use Sunsetlabs\EcommerceResourceBundle\Interfaces\Cart\CartItemInterface;
use Sunsetlabs\EcommerceResourceBundle\Interfaces\Product\ProductInterface;

interface CartManagerInterface
{
	public function getCart();
	public function addItem(CartItemInterface $cartItem);
	public function removeItem(CartItemInterface $cartItem, $all = true);
	public function addProduct(ProductInterface $product, $quantity);
	public function removeProduct(ProductInterface $product, $quantity = null);
}