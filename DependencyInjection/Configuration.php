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
        $this->addLinksSection($rootNode);

        return $treeBuilder;
    }

    /**
     * Builds the defaults node definition.
     *
     * @param ArrayNodeDefinition $node
     */
    private function addDefaultsSection(ArrayNodeDefinition $node): void
    {
        $node
            ->children()
                ->arrayNode('defaults')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('icon_prefix')->defaultValue('fa fa-')->cannotBeEmpty()->end()
                        ->scalarNode('template')
                            ->defaultValue('@EkynaSocialButtons/buttons.html.twig')
                            ->cannotBeEmpty()
                        ->end()
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
    private function addNetworksSection(ArrayNodeDefinition $node): void
    {
        $node
            ->children()
                ->arrayNode('networks')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('title')->defaultValue('')->end() // TODO default trans
                            ->scalarNode('format')->isRequired()->end()
                            ->scalarNode('icon')->isRequired()->end() // TODO validation
                        ->end()
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
    private function addLinksSection(ArrayNodeDefinition $node): void
    {
        $node
            ->children()
                ->arrayNode('links')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('icon')->isRequired()->end() // TODO validation
                            ->scalarNode('title')->defaultNull()->end()
                            ->scalarNode('url')->isRequired()->end() // TODO validation
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
