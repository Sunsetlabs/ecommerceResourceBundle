<?php

namespace Sunsetlabs\EcommerceResourceBundle\Services;

use Sunsetlabs\EcommerceResourceBundle\Interfaces\Services\OrderManagerInterface;
use Sunsetlabs\EcommerceResourceBundle\Interfaces\Order\OrderInterface;
use Doctrine\ORM\EntityManagerInterface;

class OrderManager implements OrderManagerInterface
{
	protected $order_class;
	protected $extra_fields;
	protected $em;
	protected $order = null;

	public function __construct(EntityManagerInterface $em, $order_class, $extra_fields)
	{
		$this->em = $em;
		$this->order_class = $order_class;
		$this->extra_fields = $extra_fields;
	}
	public function getOrder($id)
	{
		if (!$id) {
			throw new \Exception("Invalid order #.", 1);
		}
		if (($this->order) and ($this->order->getId() == $id)){
			return $this->order;
		}

		$this->order = $this->em->getRepository($this->order_class)->find($id);

		if (!$this->order){
			throw new \Exception("No order #".$id." found.", 1);
		}

		return $this->order;
	}
	public function getNewOrder()
	{
		return new $this->order_class();
	}
	public function getExtraFields()
	{
		return $this->extra_fields;
	}
	public function changeStateTo($id, $state)
	{
		$this->order = $this->getOrder($id);

		if ($this->order->hasState($state)) {
			if (($this->order->getNextState() === $state) or ($this->order->getPrevState() === $state)) {
				$this->order->setState($state);
			}else{
				throw new \Exception("Order #".$id." current state (". $this->order->getState() .") can't be changed to ".$state, 1);	
			}
		}else{
			throw new \Exception($state." is not a valid state for order #".$id, 1);
		}

		return $this;
	}
	public function cancelOrder($id)
	{
		$this->order = $this->getOrder($id);

		if ($this->order->isCanceled())
		{
			return $this;
		}

		$this->order->cancel();

		return $this;
	}
	public function getItems($id)
	{
		$this->order = $this->getOrder($id);
		return $this->order->getItems();
	}
	public function  updateOrder(OrderInterface $order = null)
	{
		if ($order) {
			$this->em->persist($order);
		}else{
			$this->em->persist($this->order);
		}

		$this->em->flush();
		return $this;
	}
}


