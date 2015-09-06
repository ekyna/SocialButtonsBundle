<?php

namespace Ekyna\Bundle\SocialButtonsBundle\Helper;

use Ekyna\Bundle\SocialButtonsBundle\Exception\InvalidArgumentException;
use Ekyna\Bundle\SocialButtonsBundle\Share\Button;
use Ekyna\Bundle\SocialButtonsBundle\Share\Subject;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class Networks
 * @package Ekyna\Bundle\SocialButtonsBundle\Helper
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class Networks
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var array
     */
    private $config;


    /**
     * Constructor.
     *
     * @param TranslatorInterface $translator
     * @param array               $config
     */
    public function __construct(TranslatorInterface $translator, array $config)
    {
        $this->translator = $translator;
        $this->config     = array_merge($this->getDefaults(), $config);
    }

    /**
     * Creates the share buttons.
     *
     * @param Subject $subject The subject to share
     * @param array   $names   The networks name
     * @return Button[]
     */
    public function createShareButtons(Subject $subject, array $names = array())
    {
        if (empty($names)) {
            $names = $this->getNetworksNames();
        }

        $buttons = array();

        foreach ($names as $name) {
            $buttons[] = $this->createShareButton($name, $subject);
        }

        return $buttons;
    }

    /**
     * Creates the share button.
     *
     * @param string $name     The network name
     * @param Subject $subject The subject to share
     * @return Button
     */
    public function createShareButton($name, Subject $subject)
    {
        if (!array_key_exists($name, $this->config)) {
            throw new InvalidArgumentException("Unknown {$name} network.");
        }
        $config = $this->config[$name];

        $button = new Button();
        $button->name = $name;
        $button->title = $this->translator->trans($config['title'], array(
            '{title}' => $subject->title,
        ));
        $button->url = str_replace(
            array('[URL]', '[TITLE]'),
            array(urlencode($subject->url), urlencode($subject->title)),
            $config['format']
        );
        $button->icon = $config['icon'];

        return $button;
    }

    /**
     * Returns the configured networks names.
     *
     * @return array
     */
    public function getNetworksNames()
    {
        return array_keys($this->config);
    }

    /**
     * Returns the default configuration.
     *
     * @return array
     */
    private function getDefaults()
    {
        return array(
            'facebook'  => array(
                'title'  => 'ekyna_social_buttons.share.facebook',
                'format' => 'http://www.facebook.com/share.php?u=[URL]&title=[TITLE]',
                'icon'   => 'fa fa-facebook',
            ),
            'twitter'   => array(
                'title'  => 'ekyna_social_buttons.share.twitter',
                'format' => 'http://twitter.com/intent/tweet?status=[TITLE]+[URL]',
                'icon'   => 'fa fa-twitter',
            ),
            'google'    => array(
                'title'  => 'ekyna_social_buttons.share.google',
                'format' => 'https://plus.google.com/share?url=[URL]',
                'icon'   => 'fa fa-google-plus',
            ),
            'pinterest' => array(
                'title'  => 'ekyna_social_buttons.share.pinterest',
                'format' => 'http://pinterest.com/pin/create/bookmarklet/?url=[URL]&is_video=false&description=[TITLE]', // &media=[MEDIA]
                'icon'   => 'fa fa-pinterest',
            ),
        );
    }
}
