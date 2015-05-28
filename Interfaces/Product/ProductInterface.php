<?php

namespace Sunsetlabs\EcommerceResourceBundle\Interfaces\Product;

use Sunsetlabs\EcommerceResourceBundle\Interfaces\Product\ProductGroupInterface;

interface ProductInterface
{
	public function getId();
	public function getGroup();
	public function setGroup(ProductGroupInterface $group = null);
	public function getStock();
	public function setStock($stock);
	public function get($attr);
}
