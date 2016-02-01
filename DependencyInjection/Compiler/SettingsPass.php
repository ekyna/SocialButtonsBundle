<?php

namespace Ekyna\Bundle\SocialButtonsBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class SettingsPass
 * @package Ekyna\Bundle\SocialButtonsBundle\DependencyInjection\Compiler
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class SettingsPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('ekyna_setting.manager')) {
            return;
        }

        // Settings schema
        $settingsSchemaDefinition = new Definition('Ekyna\Bundle\SocialButtonsBundle\Settings\Schema');
        $settingsSchemaDefinition->addTag('ekyna_setting.schema', [
            'namespace' => 'social',
            'position'  => '99',
        ]);
        $container->setDefinition('ekyna_social_buttons.settings', $settingsSchemaDefinition);

        // Twig extension
        $twigExtension = $container->getDefinition('ekyna_social_buttons.twig.buttons_extension');
        $twigExtension->addMethodCall('setSettingsManager', [new Reference('ekyna_setting.manager')]);
    }
}
