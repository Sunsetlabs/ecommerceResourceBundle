<?php

namespace Sunsetlabs\EcommerceResourceBundle\Services;

use Sunsetlabs\EcommerceResourceBundle\Interfaces\Services\CartManagerInterface;
use Sunsetlabs\EcommerceResourceBundle\Interfaces\Cart\CartItemInterface;
use Sunsetlabs\EcommerceResourceBundle\Interfaces\Product\ProductInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartManager implements CartManagerInterface
{
	protected $cart_class;
	protected $cart_item_class;
	protected $session;
	protected $em;
	protected $cart = null;

	public function __construct(EntityManagerInterface $em, SessionInterface $session, $cart_class, $cart_item_class)
	{
		$this->em = $em;
		$this->session = $session;
		$this->cart_class = $cart_class;
		$this->cart_item_class = $cart_item_class;
	}
	public function getCart()
	{
		return $this->findCart($this->getCartId());
	}
	public function addItem(CartItemInterface $cartItem)
	{
		$this->cart = $this->getCart();
		$this->cart->addItem($cartItem);
		return $this;
	}
	public function removeItem(CartItemInterface $cartItem, $all = true)
	{
		$this->cart = $this->getCart();
		$this->cart->removeItem($cartItem, $all);
		return $this;
	}
	public function addProduct(ProductInterface $product, $quantity)
	{
		$this->cart = $this->getCart();
		$item = $this->createItem($product, $quantity);
		$this->cart->addItem($item);
		return $this;

	}
	public function removeProduct(ProductInterface $product, $quantity = 0)
	{
		$item = $this->createItem($product, $quantity);
		if ($quantity > 0) {
			$this->removeItem($item, false);
		}else{
			$this->removeItem($item, true);
		}
		return $this;
	}
	public function updateCart()
	{
		$this->em->persist($this->cart);
		$this->em->flush();
		$this->session->set('cartid', $this->cart->getId());
		return $this;
	}

	protected function createItem($product, $quantity)
	{
		$item = new $this->cart_item_class();
		$item->setProduct($product);
		$item->setQuantity($quantity);
		return $item;
	}
	protected function getCartId($id = null)
	{
		return $this->session->get('cartid', null);
	}
	protected function findCart($id = null)
	{
		if ($id === null) {
			return new $this->cart_class();
		}

		if (($this->cart) and ($this->cart->getId() === $id))
		{
			return $this->cart;
		}

		$this->cart = $this->em->getRepository($this->cart_class)->find($id);

		if (!$this->cart) {
			return new $this->cart_class();
		}

		return $this->cart;
	}
}
