<?php

namespace Sunsetlabs\EcommerceResourceBundle\Interfaces\Services;

use Sunsetlabs\EcommerceResourceBundle\Interfaces\Order\OrderInterface;

interface StockManagerInterface
{
	public function hasStock($id, $quantity);
	public function getProductQuantities(OrderInterface $order);
	public function manageStock($old_quantities, $new_quantities);
}


