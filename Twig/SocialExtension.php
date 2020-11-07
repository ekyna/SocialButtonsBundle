<?php

namespace Ekyna\Bundle\SocialButtonsBundle\Twig;

use Ekyna\Bundle\SocialButtonsBundle\Service\SocialRenderer;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class SocialExtension
 * @package Ekyna\Bundle\SocialButtonsBundle\Twig
 * @author  Étienne Dauvergne <contact@ekyna.com>
 */
class SocialExtension extends AbstractExtension
{
    /**
     * @inheritDoc
     */
    public function getFunctions()
    {
        return [
            new TwigFunction(
                'social_link_buttons',
                [SocialRenderer::class, 'renderSocialLinkButtons'],
                ['is_safe' => ['html']]
            ),
            new TwigFunction(
                'social_share_buttons',
                [SocialRenderer::class, 'renderSocialShareButtons'],
                ['is_safe' => ['html']]
            ),
            new TwigFunction(
                'social_share_button',
                [SocialRenderer::class, 'renderSocialShareButton'],
                ['is_safe' => ['html']]
            ),
        ];
    }
}
