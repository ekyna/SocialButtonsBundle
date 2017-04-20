<?php

declare(strict_types=1);

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
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('ekyna_social_buttons');

        $rootNode = $treeBuilder->getRootNode();

        $this->addDefaultsSection($rootNode);
        $this->addNetworksSection($rootNode);
        $this->addLinksSection($rootNode);

        return $treeBuilder;
    }

    /**
     * Builds the defaults node definition.
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
     * Builds the network node definition.
     */
    private function addNetworksSection(ArrayNodeDefinition $node): void
    {
        $node
            ->children()
                ->arrayNode('networks')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('title')->isRequired()->end()
                            ->scalarNode('domain')->isRequired()->end()
                            ->scalarNode('format')->isRequired()->end()
                            ->scalarNode('icon')->isRequired()->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    /**
     * Builds the links node definition.
     */
    private function addLinksSection(ArrayNodeDefinition $node): void
    {
        $node
            ->children()
                ->arrayNode('links')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('icon')->isRequired()->end()
                            ->scalarNode('title')->defaultNull()->end()
                            ->scalarNode('url')->isRequired()->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
