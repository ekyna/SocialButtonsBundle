<?php

namespace Ekyna\Bundle\SocialButtonsBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * Class EkynaSocialButtonsExtension
 * @package Ekyna\Bundle\SocialButtonsBundle\DependencyInjection
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class EkynaSocialButtonsExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $networksHelper = $container->getDefinition('ekyna_social_buttons.helper.networks');
        $networksHelper->replaceArgument(1, $config['networks']);

        $twigExtension = $container->getDefinition('ekyna_social_buttons.twig.buttons_extension');
        $twigExtension->replaceArgument(2, $config['defaults']);
    }
}
