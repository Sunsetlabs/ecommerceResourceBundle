<?php

namespace Sunsetlabs\EcommerceResourceBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('sunsetlabs_ecommerce_resource');

        $rootNode
            ->children()
                ->arrayNode('order_configuration')
                    ->children()
                        ->arrayNode('order')
                            ->children()
                                ->scalarNode('class')->end()
                                ->arrayNode('form_extra_fields')
                                    ->prototype('array')
                                        ->children()
                                            ->scalarNode('label')->end()
                                            ->scalarNode('property')->end()
                                            ->scalarNode('input_icon')->defaultFalse()->end()
                                            ->scalarNode('class')->defaultFalse()->end()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('order_item')
                            ->children()
                                ->scalarNode('class')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('product_configuration')
                    ->children()
                        ->arrayNode('product_group')
                            ->children()
                                ->scalarNode('class')->end()
                                ->arrayNode('form_fields')
                                    ->prototype('scalar')->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('product')
                            ->children()
                                ->scalarNode('class')->end()
                                ->arrayNode('form_fields')
                                    ->prototype('scalar')->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('cart_configuration')
                    ->children()
                        ->arrayNode('cart')
                            ->children()
                                ->scalarNode('class')->end()
                            ->end()
                        ->end()
                        ->arrayNode('cart_item')
                            ->children()
                                ->scalarNode('class')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('address_configuration')
                    ->children()
                        ->scalarNode('class')->end()
                        ->arrayNode('form_fields')
                            ->prototype('array')
                                ->children()
                                    ->scalarNode('label')->end()
                                    ->scalarNode('property')->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('user_configuration')
                    ->children()
                        ->arrayNode('admin')
                            ->children()
                                ->scalarNode('class')->end()
                            ->end()
                        ->end()
                        ->arrayNode('user')
                            ->children()
                                ->scalarNode('class')->end()
                                ->arrayNode('form_fields')
                                    ->prototype('array')
                                        ->children()
                                            ->scalarNode('label')->end()
                                            ->scalarNode('property')->end()
                                            ->scalarNode('type')->defaultNull()->end()
                                        ->end()
                                    ->end()
                                ->end()
                                ->booleanNode('address')->defaultFalse()->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

            // sunsetlabs_ecommerce:
            //     order_configuration:
            //         order:
            //             class:
            //             form_extra_fields:
            //                 - { label: , property:, input_icon:, class: }
            //         order_item:
            //             class:
            //     product_configuration:
            //         product_group:
            //             class:
            //             form_fields: []
            //         product:
            //             class:
            //             form_fields: []
            //     cart_configuration:
            //         cart:
            //             class:
            //         cart_item:
            //             class:
            //     address_configuration:
            //         class:
            //         form_fields:
            //             - { label:, property:  }
            //     user_configuration:
            //         admin:
            //             class:
            //         user:
            //             class:
            //             form_fields:
            //                 - { label:, property:, type:}
            //             address: boolean


        return $treeBuilder;
    }
}
