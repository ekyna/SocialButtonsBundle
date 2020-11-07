<?php

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
     *
     * @return array
     */
    public static function getChoices()
    {
        $choices = [];
        foreach (static::getConfig() as $constant => $config) {
            $choices[$config[0]] = $constant;
        }

        return $choices;
    }

    /**
     * Returns the configured icons.
     */
    public static function getConfig()
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
