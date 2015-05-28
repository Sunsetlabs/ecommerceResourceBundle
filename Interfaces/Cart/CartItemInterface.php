<?php

namespace Sunsetlabs\EcommerceResourceBundle\Interfaces\Cart;

use Sunsetlabs\EcommerceResourceBundle\Interfaces\Cart\CartInterface;
use Sunsetlabs\EcommerceResourceBundle\Interfaces\Product\ProductInterface;

interface CartItemInterface
{
	public function getIdentifier();
	public function getProduct();
	public function getCart();
	public function getQuantity();
	public function setProduct(ProductInterface $product);
	public function setQuantity($quantity = 0);
	public function setCart(CartInterface $cart = null);
	public function merge(CartItemInterface $item);
}




