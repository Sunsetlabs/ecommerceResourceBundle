<?php

namespace Sunsetlabs\EcommerceResourceBundle\Interfaces\Product;

use Sunsetlabs\EcommerceResourceBundle\Interfaces\Product\ProductInterface;

interface ProductGroupInterface
{
	public function getProducts();
	public function addProduct(ProductInterface $product);
	public function removeProduct(ProductInterface $product);
}