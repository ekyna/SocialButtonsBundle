<?php

namespace Ekyna\Bundle\SocialButtonsBundle\Twig;

use Ekyna\Bundle\SettingBundle\Manager\SettingsManagerInterface;
use Ekyna\Bundle\SocialButtonsBundle\Event\SubjectEvent;
use Ekyna\Bundle\SocialButtonsBundle\Event\SubjectEvents;
use Ekyna\Bundle\SocialButtonsBundle\Exception\InvalidArgumentException;
use Ekyna\Bundle\SocialButtonsBundle\Exception\SubjectNotFoundException;
use Ekyna\Bundle\SocialButtonsBundle\Helper\Networks;
use Ekyna\Bundle\SocialButtonsBundle\Model\Link;
use Ekyna\Bundle\SocialButtonsBundle\Share\Subject;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class ButtonsExtension
 * @package Ekyna\Bundle\SocialButtonsBundle\Twig
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class ButtonsExtension extends \Twig_Extension
{
    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * @var Networks
     */
    private $networks;

    /**
     * @var SettingsManagerInterface
     */
    private $settingsManager;

    /**
     * @var array
     */
    private $config;

    /**
     * @var \Twig_Environment
     */
    private $environment;

    /**
     * @var \Twig_Template
     */
    private $defaultTemplate;


    /**
     * Constructor.
     *
     * @param EventDispatcherInterface $dispatcher
     * @param Networks                 $networks
     * @param array                    $config
     */
    public function __construct(EventDispatcherInterface $dispatcher, Networks $networks, array $config)
    {
        $this->dispatcher = $dispatcher;
        $this->networks   = $networks;
        $this->config     = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function initRuntime(\Twig_Environment $environment)
    {
        $this->environment     = $environment;
        $this->defaultTemplate = $environment->loadTemplate($this->config['template']);
    }

    /**
     * Sets the settings manager.
     *
     * @param SettingsManagerInterface $manager
     */
    public function setSettingsManager(SettingsManagerInterface $manager)
    {
        $this->settingsManager = $manager;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('social_link_buttons',  [$this, 'renderSocialLinkButtons'],  ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('social_share_buttons', [$this, 'renderSocialShareButtons'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('social_share_button',  [$this, 'renderSocialShareButton'],  ['is_safe' => ['html']]),
        ];
    }

    /**
     * Renders the social link buttons.
     *
     * @param array $parameters
     * @return string
     */
    public function renderSocialLinkButtons(array $parameters = [])
    {
        $links = [];
        if ($this->settingsManager) {
            $links = $this->settingsManager->getParameter('social.links');
        }
        if (empty($links)) {
            foreach ($this->config['links'] as $name => $config) {
                $link = new Link();
                $link
                    ->setName($name)
                    ->setIcon($config['icon'])
                    ->setUrl($config['url'])
                    ->setTitle($config['title'])
                ;
                $links[] = $link;
            }
        }

        if (empty($links)) {
            return '';
        }

        $attr = [
            'class' => 'social-link-buttons',
        ];
        if (array_key_exists('attr', $parameters)) {
            $attr = array_replace($attr, $parameters['attr']);
        }

        $template = $this->resolveTemplate(isset($parameters['template']) ?: null);

        return $template->renderBlock('link_buttons', [
            'icon_prefix' => $this->config['icon_prefix'],
            'links'       => $links,
            'attr'        => $attr,
        ]);
    }

    /**
     * Renders the social share buttons.
     *
     * @param array $parameters
     * @return string
     */
    public function renderSocialShareButtons(array $parameters = [])
    {
        $subject = $this->resolveSubject($parameters);
        $networks = isset($parameters['networks']) ? (array) $parameters['networks'] : [];
        $template = $this->resolveTemplate(isset($parameters['template']) ?: null);

        $buttons = $this->networks->createShareButtons($subject, $networks);

        if (empty($buttons)) {
            return '';
        }

        $attr = [
            'class' => 'social-share-buttons',
        ];
        if (array_key_exists('attr', $parameters)) {
            $attr = array_replace($attr, $parameters['attr']);
        }

        return $template->renderBlock('share_buttons', [
            'icon_prefix' => $this->config['icon_prefix'],
            'buttons'     => $buttons,
            'attr'        => $attr,
        ]);
    }

    /**
     * Renders the social share buttons.
     *
     * @param array $parameters
     * @return string
     */
    public function renderSocialShareButton(array $parameters = [])
    {
        if (!array_key_exists('network', $parameters)) {
            throw new InvalidArgumentException('Network is mandatory.');
        }
        $network = $parameters['network'];
        $template = $this->resolveTemplate(isset($parameters['template']) ?: null);
        $subject = $this->resolveSubject($parameters);

        $button = $this->networks->createShareButton($network, $subject);

        return $template->renderBlock('share_button', [
            'icon_prefix' => $this->config['icon_prefix'],
            'button'      => $button,
        ]);
    }

    /**
     * Resolves the share subject.
     *
     * @param array $parameters
     * @return Subject
     * @throws SubjectNotFoundException
     */
    private function resolveSubject(array $parameters = [])
    {
        if (array_key_exists('url', $parameters) && array_key_exists('title', $parameters)) {
            $subject = new Subject();
            $subject->url = $parameters['url'];
            $subject->title = $parameters['title'];
            return $subject;
        }

        $event = new SubjectEvent($parameters);
        $this->dispatcher->dispatch(SubjectEvents::RESOLVE, $event);
        if (null !== $subject = $event->getSubject()) {
            return $subject;
        }

        throw new SubjectNotFoundException();
    }

    /**
     * Resolves the template to use to render the button(s).
     *
     * @param string $name
     * @return \Twig_Template
     */
    private function resolveTemplate($name = null)
    {
        if (0 < strlen($name)) {
            return $this->environment->loadTemplate($name);
        }
        return $this->defaultTemplate;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'ekyna_social_buttons';
    }
}
