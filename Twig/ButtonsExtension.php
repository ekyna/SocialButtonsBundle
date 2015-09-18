<?php

namespace Ekyna\Bundle\SocialButtonsBundle\Twig;

use Ekyna\Bundle\SocialButtonsBundle\Event\SubjectEvent;
use Ekyna\Bundle\SocialButtonsBundle\Event\SubjectEvents;
use Ekyna\Bundle\SocialButtonsBundle\Exception\InvalidArgumentException;
use Ekyna\Bundle\SocialButtonsBundle\Exception\SubjectNotFoundException;
use Ekyna\Bundle\SocialButtonsBundle\Helper\Networks;
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
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('social_share_buttons', array($this, 'renderSocialShareButtons'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('social_share_button', array($this, 'renderSocialShareButton'), array('is_safe' => array('html'))),
        );
    }

    /**
     * Renders the social buttons.
     *
     * @param array $parameters
     * @return string
     */
    public function renderSocialShareButtons(array $parameters = array())
    {
        $subject = $this->resolveSubject($parameters);
        $networks = isset($parameters['networks']) ? (array) $parameters['networks'] : array();
        $template = $this->resolveTemplate(isset($parameters['template']) ?: null);

        $buttons = $this->networks->createShareButtons($subject, $networks);

        $attr = array(
            'class' => 'social-buttons',
        );
        if (array_key_exists('attr', $parameters)) {
            $attr = array_replace($attr, $parameters['attr']);
        }

        return $template->renderBlock('share_buttons', array(
            'buttons' => $buttons,
            'attr'    => $attr,
        ));
    }

    /**
     * Renders the social buttons.
     *
     * @param array $parameters
     * @return string
     */
    public function renderSocialShareButton(array $parameters = array())
    {
        if (!array_key_exists('network', $parameters)) {
            throw new InvalidArgumentException('Network is mandatory.');
        }
        $network = $parameters['network'];
        $template = $this->resolveTemplate(isset($parameters['template']) ?: null);
        $subject = $this->resolveSubject($parameters);

        $button = $this->networks->createShareButton($network, $subject);

        return $template->renderBlock('share_button', array('button' => $button));
    }

    /**
     * Resolves the subject.
     *
     * @param array $parameters
     * @return Subject
     * @throws SubjectNotFoundException
     */
    private function resolveSubject(array $parameters = array())
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
