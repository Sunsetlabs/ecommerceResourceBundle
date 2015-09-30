### Instalacion

#### via composer

````json
{
    "require": {
        "sunsetlabs/resource-bundle"    : "dev-master",
    },
    "repositories" : [
        {
            "type" : "vcs",
            "url" : "https://github.com/Sunsetlabs/ecommerceResourceBundle.git"
        }
    ]
}
````

### Configuracion

Registrar en el kernel de la aplicacion

````php
<?php
// app/AppKernel.php

$bundles = array(
    new Sunsetlabs\EcommerceResourceBundle\SunsetlabsEcommerceResourceBundle(),
);
````

El plugin provee dos servicios utilitarios para manejar ordenes y carritos que cumplan con las interfaces dadas por el plugin (order y cart bundles).

La firma de estos servios es la siguiente:

````php
<?php

// Servicio sl.cart.manager
interface CartManagerInterface
{
    /**
     * Retorna el carrito del usuario que este
     * navegando el sitio o una instancia nueva
     * en caso de no existir.
     *
     * @return CartInterface
     */
	public function getCart();
    /**
     * Agrega un item al carrito activo.
     * @param CartItemInterface $cartItem
     */
	public function addItem(CartItemInterface $cartItem);
    /**
     * Remueve un item del carrito activo.
     * @param CartItemInterface $cartItem
     * @param Boolean $all Define si borra todos los items identicos a $cartItem
     */
	public function removeItem(CartItemInterface $cartItem, $all = true);
    /**
     * Agrega un producto al carrito activo.
     * @param ProductInterface $product
     * @param int $quantity
     */
	public function addProduct(ProductInterface $product, $quantity);
    /**
     * Remueve un producto del carrito activo.
     * @param ProductInterface $product
     * @param int $quantity
     */
	public function removeProduct(ProductInterface $product, $quantity = null);
}

// Servicio sl.order.manager
interface OrderManagerInterface
{
    /**
     * Retorna la orden identificada por $id.
     * @param int $id
     * @return OrderManagerInterface
     */
	public function getOrder($id);
    /**
     * Retorna una nueva orden.
     * @return OrderManagerInterface
     */
	public function getNewOrder();
    /**
     * Cambia el estado de la orden al estado dado.
     * @param int $id Identifica a la orden
     * @param string $state
     */
	public function changeStateTo($id, $state);
    /**
     * Cancela la orden dada por $id.
     * @param int $id
     */
	public function cancelOrder($id);
    /**
     * Retorna los items de la orden dada por $id.
     * @param int $id
     * @return array
     */
	public function getItems($id);
}
````

A su vez el plugin necesita la configuracion de ciertos parametros, a continuacion la configuracion basica (rellenar con la info del proyecto).

````yml
# config.yml

sunsetlabs_ecommerce_resource:
    order_configuration:
        order:
            class: 'AppBundle\Entity\Order'
        order_item:
            class: 'AppBundle\Entity\OrderItem'
    product_configuration:
        product_group:
            class: 'AppBUndle\Entity\ProductGroup'
        product:
            class: 'AppBundle\Entity\Product'
    cart_configuration:
        cart:
            class: 'AppBundle\Entity\Cart'
        cart_item:
            class: 'AppBundle\Entity\CartItem'
    address_configuration:
        class: 'AppBundle\Entity\Address'
    user_configuration:
        admin:
            class: 'AppBundle\Entity\Admin'
        user:
            class: 'AppBundle\Entity\User'
````
