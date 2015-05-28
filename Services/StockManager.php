<?php

namespace Sunsetlabs\EcommerceResourceBundle\Services;

use Sunsetlabs\EcommerceResourceBundle\Interfaces\Services\StockManagerInterface;
use Sunsetlabs\EcommerceResourceBundle\Interfaces\Order\OrderInterface;
use Doctrine\ORM\EntityManagerInterface;

class StockManager implements StockManagerInterface
{
	protected $product_class;
	protected $em;

	public function __construct(EntityManagerInterface $em, $product_class)
	{
		$this->em = $em;
		$this->product_class = $product_class;
	}
	public function hasStock($id, $quantity)
	{
		$product = $this->getProduct($id);
		return ($product->getStock() >= $quantity);
	}
	public function getProductQuantities(OrderInterface $order)
	{
		$products_quantities = array();
		foreach ($order->getItems() as $item) {
			$products_quantities[$item->getProduct()->getId()] = $item->getQuantity();
		}
		return $products_quantities;
	}
	public function manageStock($old_quantities, $new_quantities)
	{
		$product_quantity = $this->getProductQuantityDiff($old_quantities, $new_quantities);

		foreach ($product_quantity as $id => $diff) {
			$product = $this->getProduct($id);
			$product->setStock($product->getStock() - $diff);
			$this->em->persist($product);
		}

	}
	public function updateStock()
	{
		$this->em->flush();
	}
	protected function getProductQuantityDiff($old_quantities, $new_quantities)
	{
		$products = array();

		foreach ($new_quantities as $product => $new_quantity) {
			if (!isset($old_quantities[$product])){
				$old_quantity = 0;
			}else{
				$old_quantity = $old_quantities[$product];
				unset($old_quantities[$product]);
			}
			$quantity = $new_quantity - $old_quantity;
			$products[$product] = $quantity;
		}

		foreach ($old_quantities as $product => $old_quantity) {
			$products[$product] = -$old_quantity;
		}

		return $products;
	}
	protected function getProduct($id)
	{
		if (!$id) {
			throw new \Exception("Invaild Product id.", 1);
		}

		$product = $this->em->getRepository($this->product_class)->find($id);

		if (!$product){
			throw new \Exception("No product #".$id, 1);
		}

		return $product;
	}
}




