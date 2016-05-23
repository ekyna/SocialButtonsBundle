<?php

namespace Ekyna\Bundle\SocialButtonsBundle\Model;

use Ekyna\Bundle\CoreBundle\Model\AbstractConstants;

/**
 * Class Icons
 * @package Ekyna\Bundle\SocialButtonsBundle\Model
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
final class Icons extends AbstractConstants
{
    /**
     * {@inheritdoc}
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
