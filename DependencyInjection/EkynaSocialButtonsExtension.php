<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SocialButtonsBundle\DependencyInjection;

use Ekyna\Bundle\SettingBundle\DependencyInjection\Compiler\RegisterSchemasPass;
use Ekyna\Bundle\SocialButtonsBundle\Service\SettingSchema;
use Ekyna\Bundle\SocialButtonsBundle\Service\SocialHelper;
use Ekyna\Bundle\SocialButtonsBundle\Service\SocialRenderer;
use Ekyna\Bundle\SocialButtonsBundle\Twig\SocialExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

use function array_key_exists;

/**
 * Class EkynaSocialButtonsExtension
 * @package Ekyna\Bundle\SocialButtonsBundle\DependencyInjection
 * @author  Étienne Dauvergne <contact@ekyna.com>
 */
class EkynaSocialButtonsExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $config = $this->processConfiguration(new Configuration(), $configs);

        $container
            ->register('ekyna_social_buttons.helper', SocialHelper::class)
            ->setArguments([
                new Reference('translator'),
                $config['networks'],
            ]);

        $container
            ->register('ekyna_social_buttons.renderer', SocialRenderer::class)
            ->setArguments([
                new Reference('ekyna_social_buttons.helper'),
                new Reference('event_dispatcher'),
                new Reference('twig'),
                [
                    'icon_prefix' => $config['defaults']['icon_prefix'],
                    'template'    => $config['defaults']['template'],
                    'links'       => $config['links'],
                ],
            ])
            ->addTag('twig.runtime');

        $container
            ->register('ekyna_social_buttons.twig_extension', SocialExtension::class)
            ->addTag('twig.extension');

        $this->configureSetting($container);
    }

    /**
     * Configures the setting services.
     */
    private function configureSetting(ContainerBuilder $container): void
    {
        $bundles = $container->getParameter('kernel.bundles');
        if (!array_key_exists('EkynaSettingBundle', $bundles)) {
            return;
        }

        // Setting schema
        $container
            ->register('ekyna_social_buttons.setting_schema', SettingSchema::class)
            ->addTag(RegisterSchemasPass::TAG, [
                'namespace' => 'social',
                'position'  => 99,
            ]);

        // Renderer
        $container
            ->getDefinition('ekyna_social_buttons.renderer')
            ->addMethodCall('setSetting', [new Reference('ekyna_setting.manager')]);
    }
}
