<?php

namespace Ekyna\Bundle\SocialButtonsBundle\Settings;

use Ekyna\Bundle\GoogleBundle\Form\Type\TrackingCodeType;
use Ekyna\Bundle\GoogleBundle\Model\TrackingCode;
use Ekyna\Bundle\SettingBundle\Schema\AbstractSchema;
use Ekyna\Bundle\SettingBundle\Schema\SettingsBuilder;
use Ekyna\Bundle\SocialButtonsBundle\Form\Type\LinkType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints;

/**
 * Class Schema
 * @package Ekyna\Bundle\SocialButtonsBundle\Settings
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class Schema extends AbstractSchema
{
    /**
     * {@inheritdoc}
     */
    public function buildSettings(SettingsBuilder $builder)
    {
        $builder
            ->setDefaults(array_merge([
                'links' => array(),
            ], $this->defaults))
            ->setAllowedTypes('links', 'array')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('links', 'ekyna_collection', array(
                'label'      => 'ekyna_social_buttons.link.label.plural',
                'type'       => new LinkType(),
                'allow_sort' => true,
                'required'   => false,
            ))
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function getLabel()
    {
        return 'ekyna_social_buttons.settings.label';
    }

    /**
     * {@inheritDoc}
     */
    public function getShowTemplate()
    {
        return 'EkynaSocialButtonsBundle:Admin/Settings:show.html.twig';
    }

    /**
     * {@inheritDoc}
     */
    public function getFormTemplate()
    {
        return 'EkynaSocialButtonsBundle:Admin/Settings:form.html.twig';
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'ekyna_social_buttons_settings';
    }
}
