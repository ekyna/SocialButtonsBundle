<?php

namespace Ekyna\Bundle\SocialButtonsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package Ekyna\Bundle\SocialButtonsBundle\DependencyInjection
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ekyna_social_buttons');

        $this->addDefaultsSection($rootNode);
        $this->addNetworksSection($rootNode);

        return $treeBuilder;
    }

    /**
     * Builds the defaults node definition.
     *
     * @param ArrayNodeDefinition $node
     */
    private function addDefaultsSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('defaults')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('template')->defaultValue('EkynaSocialButtonsBundle::buttons.html.twig')->cannotBeEmpty()->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    /**
     * Builds the networks node definition.
     *
     * @param ArrayNodeDefinition $node
     */
    private function addNetworksSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('networks')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('title')->defaultValue('')->end() // TODO default trans
                            ->scalarNode('format')->isRequired()->end()
                            ->scalarNode('icon')->isRequired()->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
