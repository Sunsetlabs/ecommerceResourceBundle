<?php

namespace Sunsetlabs\EcommerceResourceBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class SunsetlabsEcommerceResourceExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        
        $order_config   = $config['order_configuration'];
        $product_config = $config['product_configuration'];
        $cart_config    = $config['cart_configuration'];
        $address_config = $config['address_configuration'];
        $user_config    = $config['user_configuration'];
           
        $container->setParameter('sl.order.class', $order_config['order']['class']);
        $container->setParameter('sl.order.form.extra.fields', $order_config['order']['form_extra_fields']);
        $container->setParameter('sl.order.item.class', $order_config['order_item']['class']);
        $container->setParameter('sl.product.group.class', $product_config['product_group']['class']);
        $container->setParameter('sl.product.group.form.fields', $product_config['product_group']['form_fields']);
        $container->setParameter('sl.product.class', $product_config['product']['class']);
        $container->setParameter('sl.product.form.fields', $product_config['product']['form_fields']);
        $container->setParameter('sl.address.class', $address_config['class']);
        $container->setParameter('sl.address.form.fields', $address_config['form_fields']);
        $container->setParameter('sl.admin.class', $user_config['admin']['class']);
        $container->setParameter('sl.user.class', $user_config['user']['class']);
        $container->setParameter('sl.user.form.fields', $user_config['user']['form_fields']);
        $container->setParameter('sl.user.has_address', $user_config['user']['address']);
        $container->setParameter('sl.cart.class', $cart_config['cart']['class']);
        $container->setParameter('sl.cart.item.class', $cart_config['cart_item']['class']);

        $resources = array();
        if ($container->hasParameter('twig.form.resources')) {
            $resources = $container->getParameter('twig.form.resources');
        }
        $resources[] = '@SunsetlabsEcommerceResourceBundle/Form/fields.html.twig';
        $container->setParameter('twig.form.resources', $resources);
    }
}
