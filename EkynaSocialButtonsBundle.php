<?php

namespace Ekyna\Bundle\SocialButtonsBundle;

use Ekyna\Bundle\SocialButtonsBundle\DependencyInjection\Compiler\SettingsPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class EkynaSocialButtonsBundle
 * @package Ekyna\Bundle\SocialButtonsBundle
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class EkynaSocialButtonsBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new SettingsPass());
    }
}
