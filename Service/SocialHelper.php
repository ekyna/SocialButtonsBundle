<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SocialButtonsBundle\Service;

use Ekyna\Bundle\SocialButtonsBundle\Exception\InvalidArgumentException;
use Ekyna\Bundle\SocialButtonsBundle\Model\Button;
use Ekyna\Bundle\SocialButtonsBundle\Model\Subject;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class SocialHelper
 * @package Ekyna\Bundle\SocialButtonsBundle\Service
 * @author  Étienne Dauvergne <contact@ekyna.com>
 */
class SocialHelper
{
    private TranslatorInterface $translator;
    private array               $config;

    public function __construct(TranslatorInterface $translator, array $config)
    {
        $this->translator = $translator;
        $this->config = array_merge($this->getDefaults(), $config);
    }

    /**
     * Creates the share buttons.
     *
     * @param Subject $subject The subject to share
     * @param array   $names   The networks name
     *
     * @return Button[]
     */
    public function createShareButtons(Subject $subject, array $names = []): array
    {
        if (empty($names)) {
            $names = $this->getNetworksNames();
        }

        $buttons = [];

        foreach ($names as $name) {
            $buttons[] = $this->createShareButton($name, $subject);
        }

        return $buttons;
    }

    /**
     * Creates the share button.
     *
     * @param string  $name    The network name
     * @param Subject $subject The subject to share
     */
    public function createShareButton(string $name, Subject $subject): Button
    {
        if (!array_key_exists($name, $this->config)) {
            throw new InvalidArgumentException("Unknown $name network.");
        }

        $config = $this->config[$name];

        $button = new Button();
        $button->name = $name;

        $button->title = $this->translator->trans($config['title'], [
            '{title}' => $subject->title,
        ], $config['domain']);

        $button->url = str_replace(
            ['[URL]', '[TITLE]'],
            [urlencode($subject->url), urlencode($subject->title)],
            $config['format']
        );

        $button->icon = $config['icon'];

        return $button;
    }

    /**
     * Returns the configured networks names.
     */
    public function getNetworksNames(): array
    {
        return array_keys($this->config);
    }

    /**
     * Returns the default configuration.
     */
    private function getDefaults(): array
    {
        return [
            'facebook'  => [
                'title'  => 'share.facebook',
                'domain' => 'EkynaSocialButtons',
                'format' => 'https://www.facebook.com/share.php?u=[URL]&title=[TITLE]',
                'icon'   => 'facebook',
            ],
            'twitter'   => [
                'title'  => 'share.twitter',
                'domain' => 'EkynaSocialButtons',
                'format' => 'https://twitter.com/intent/tweet?status=[TITLE]+[URL]',
                'icon'   => 'twitter',
            ],
            'pinterest' => [
                'title'  => 'share.pinterest',
                'domain' => 'EkynaSocialButtons',
                'format' => 'https://pinterest.com/pin/create/bookmarklet/?url=[URL]&is_video=false&description=[TITLE]',
                // &media=[MEDIA]
                'icon'   => 'pinterest',
            ],
        ];
    }
}
