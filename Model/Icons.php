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
     * Returns the icon choices.
     *
     * @return array
     */
    static public function getChoices()
    {
        return [
            'bitbucket'     => 'Bitbucket',
            'delicious'     => 'Delicious',
            'deviantart'    => 'Deviant Art',
            'digg'          => 'Digg',
            'dribbble'      => 'Dribbble',
            'facebook'      => 'Facebook',
            'flickr'        => 'Flickr',
            'github'        => 'Github',
            'google-plus'   => 'Google Plus',
            'instagram'     => 'Instagram',
            'linkedin'      => 'Linkedin',
            'pinterest'     => 'Pinterest',
            'stack-overflow' => 'Stack Overflow',
            'twitter'       => 'Twitter',
            'vimeo'         => 'Vimeo',
            'youtube'       => 'Youtube',
        ];
    }

    /**
     * Returns the icon keys.
     *
     * @return array
     */
    static public function getKeys()
    {
        return array_keys(self::getChoices());
    }
}
