<?php

namespace Ekyna\Bundle\SocialButtonsBundle\DependencyInjection;

use Ekyna\Bundle\SocialButtonsBundle\Service\SettingSchema;
use Ekyna\Bundle\SocialButtonsBundle\Service\SocialHelper;
use Ekyna\Bundle\SocialButtonsBundle\Service\SocialRenderer;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Class EkynaSocialButtonsExtension
 * @package Ekyna\Bundle\SocialButtonsBundle\DependencyInjection
 * @author  Étienne Dauvergne <contact@ekyna.com>
 */
class EkynaSocialButtonsExtension extends Extension
{
    /**
     * @inheritDoc
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        $this->configureHelper($container, $config);
        $this->configureRenderer($container, $config);
        $this->configureSetting($container);
    }

    /**
     * Configures the helper.
     *
     * @param ContainerBuilder $container
     * @param array            $config
     */
    private function configureHelper(ContainerBuilder $container, array $config): void
    {
        $container
            ->getDefinition(SocialHelper::class)
            ->replaceArgument(1, $config['networks']);
    }

    /**
     * Configures the renderer.
     *
     * @param ContainerBuilder $container
     * @param array            $config
     */
    private function configureRenderer(ContainerBuilder $container, array $config): void
    {
        $container
            ->getDefinition(SocialRenderer::class)
            ->replaceArgument(3, [
                'icon_prefix' => $config['defaults']['icon_prefix'],
                'template'    => $config['defaults']['template'],
                'links'       => $config['links'],
            ]);
    }

    /**
     * Configures the setting services.
     *
     * @param ContainerBuilder $container
     */
    private function configureSetting(ContainerBuilder $container): void
    {
        $bundles = $container->getParameter('kernel.bundles');
        if (!array_key_exists('EkynaSettingBundle', $bundles)) {
            return;
        }

        // Setting schema
        $container
            ->register(SettingSchema::class)
            ->setPublic(false)
            ->addTag('ekyna_setting.schema', [
                'namespace' => 'social',
                'position'  => 99,
            ]);

        // Renderer
        $container
            ->getDefinition(SocialRenderer::class)
            ->addMethodCall('setSetting', [new Reference('ekyna_setting.manager')]);
    }
}
