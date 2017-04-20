<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SocialButtonsBundle\Service;

use Ekyna\Bundle\SettingBundle\Manager\SettingManagerInterface;
use Ekyna\Bundle\SocialButtonsBundle\Event\SubjectEvent;
use Ekyna\Bundle\SocialButtonsBundle\Event\SubjectEvents;
use Ekyna\Bundle\SocialButtonsBundle\Exception\InvalidArgumentException;
use Ekyna\Bundle\SocialButtonsBundle\Exception\SubjectNotFoundException;
use Ekyna\Bundle\SocialButtonsBundle\Model\Link;
use Ekyna\Bundle\SocialButtonsBundle\Model\Subject;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Twig\Environment;
use Twig\TemplateWrapper;

/**
 * Class Renderer
 * @package Ekyna\Bundle\SocialButtonsBundle\Service\Renderer
 * @author  Étienne Dauvergne <contact@ekyna.com>
 */
class SocialRenderer
{
    private SocialHelper $helper;
    private EventDispatcherInterface $dispatcher;
    private Environment $engine;
    private array $config;

    private SettingManagerInterface $setting;
    private ?TemplateWrapper $template = null;

    public function __construct(
        SocialHelper $helper,
        EventDispatcherInterface $dispatcher,
        Environment $engine,
        array $config
    ) {
        $this->helper     = $helper;
        $this->dispatcher = $dispatcher;
        $this->engine     = $engine;
        $this->config     = $config;
    }

    /**
     * Sets the setting manager.
     */
    public function setSetting(SettingManagerInterface $setting): void
    {
        $this->setting = $setting;
    }

    /**
     * Renders the social link buttons.
     */
    public function renderSocialLinkButtons(array $parameters = []): string
    {
        $links = [];

        if ($this->setting) {
            $links = $this->setting->getParameter('social.links');
        }

        if (empty($links)) {
            foreach ($this->config['links'] as $name => $config) {
                $link = new Link();
                $link
                    ->setName($name)
                    ->setIcon($config['icon'])
                    ->setUrl($config['url'])
                    ->setTitle($config['title']);

                $links[] = $link;
            }
        }

        if (empty($links)) {
            return '';
        }

        $parameters = array_replace([
            'template' => null,
            'attr'     => [],
        ], $parameters);

        $attr = array_replace($parameters['attr'], [
            'class' => 'social-link-buttons',
        ]);

        return $this
            ->resolveTemplate($parameters['template'])
            ->renderBlock('link_buttons', [
                'icon_prefix' => $this->config['icon_prefix'],
                'links'       => $links,
                'attr'        => $attr,
            ]);
    }

    /**
     * Renders the social share buttons.
     */
    public function renderSocialShareButtons(array $parameters = []): string
    {
        $parameters = array_replace([
            'networks' => [],
            'template' => null,
            'attr'     => [],
        ], $parameters);

        $subject  = $this->resolveSubject($parameters);
        $networks = (array)$parameters['networks'];

        $buttons = $this->helper->createShareButtons($subject, $networks);

        if (empty($buttons)) {
            return '';
        }

        $attr = array_replace($parameters['attr'], [
            'class' => 'social-share-buttons',
        ]);

        return $this
            ->resolveTemplate($parameters['template'])
            ->renderBlock('share_buttons', [
                'icon_prefix' => $this->config['icon_prefix'],
                'buttons'     => $buttons,
                'attr'        => $attr,
            ]);
    }

    /**
     * Renders the social share buttons.
     */
    public function renderSocialShareButton(array $parameters = []): string
    {
        $parameters = array_replace([
            'network'  => null,
            'template' => null,
        ], $parameters);

        if (!isset($parameters['network'])) {
            throw new InvalidArgumentException('Network is mandatory.');
        }

        $network = $parameters['network'];

        $subject = $this->resolveSubject($parameters);

        $button = $this->helper->createShareButton($network, $subject);

        return $this
            ->resolveTemplate($parameters['template'])
            ->renderBlock('share_button', [
                'icon_prefix' => $this->config['icon_prefix'],
                'button'      => $button,
            ]);
    }

    /**
     * Resolves the share subject.
     *
     * @throws SubjectNotFoundException
     */
    private function resolveSubject(array $parameters = []): Subject
    {
        if (isset($parameters['url']) && isset($parameters['title'])) {
            $subject        = new Subject();
            $subject->url   = $parameters['url'];
            $subject->title = $parameters['title'];

            return $subject;
        }

        $event = new SubjectEvent($parameters);
        $this->dispatcher->dispatch($event, SubjectEvents::RESOLVE);
        if (null !== $subject = $event->getSubject()) {
            return $subject;
        }

        throw new SubjectNotFoundException();
    }

    /**
     * Resolves the template to use to render the button(s).
     */
    private function resolveTemplate(string $name = null): TemplateWrapper
    {
        if (!empty($name)) {
            return $this->engine->load($name);
        }

        if ($this->template) {
            return $this->template;
        }

        return $this->template = $this->engine->load($this->config['template']);
    }
}
