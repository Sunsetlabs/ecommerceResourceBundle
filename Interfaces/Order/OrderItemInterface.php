<?php

namespace Sunsetlabs\EcommerceResourceBundle\Interfaces\Order;

use Sunsetlabs\EcommerceResourceBundle\Interfaces\Product\ProductInterface;
use Sunsetlabs\EcommerceResourceBundle\Interfaces\Order\OrderInterface;

interface OrderItemInterface
{
	public function getId();
	public function getProduct();
	public function setProduct(ProductInterface $product);
	public function getIdentifier();
	public function merge(OrderItemInterface $item);
	public function setQuantity($quantity = 0);
	public function getQuantity();
	public function setOrder(OrderInterface $order = null);
	public function getOrder();
}