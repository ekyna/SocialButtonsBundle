<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SocialButtonsBundle\Model;

/**
 * Class Icons
 * @package Ekyna\Bundle\SocialButtonsBundle\Model
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
final class Icons
{
    /**
     * Returns the constant choices.
     */
    public static function getChoices(): array
    {
        $choices = [];
        foreach (self::getConfig() as $constant => $config) {
            $choices[$config[0]] = $constant;
        }

        return $choices;
    }

    /**
     * Returns the configured icons.
     */
    public static function getConfig(): array
    {
        return [
            'bitbucket'      => ['Bitbucket'],
            'delicious'      => ['Delicious'],
            'deviantart'     => ['Deviant Art'],
            'digg'           => ['Digg'],
            'dribbble'       => ['Dribbble'],
            'facebook'       => ['Facebook'],
            'flickr'         => ['Flickr'],
            'github'         => ['Github'],
            'google-plus'    => ['Google Plus'],
            'instagram'      => ['Instagram'],
            'linkedin'       => ['Linkedin'],
            'pinterest'      => ['Pinterest'],
            'stack-overflow' => ['Stack Overflow'],
            'twitter'        => ['Twitter'],
            'vimeo'          => ['Vimeo'],
            'youtube'        => ['Youtube'],
        ];
    }
}
