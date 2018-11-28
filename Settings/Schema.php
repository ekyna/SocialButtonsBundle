<?php

namespace Ekyna\Bundle\SocialButtonsBundle\Settings;

use Ekyna\Bundle\CoreBundle\Form\Type\CollectionType;
use Ekyna\Bundle\SettingBundle\Schema\AbstractSchema;
use Ekyna\Bundle\SettingBundle\Schema\SettingsBuilder;
use Ekyna\Bundle\SocialButtonsBundle\Form\Type\LinkType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class Schema
 * @package Ekyna\Bundle\SocialButtonsBundle\Settings
 * @author  Étienne Dauvergne <contact@ekyna.com>
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
                'links' => [],
            ], $this->defaults))
            ->setAllowedTypes('links', 'array');
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('links', CollectionType::class, [
                'label'      => 'ekyna_social_buttons.link.label.plural',
                'entry_type' => LinkType::class,
                'allow_sort' => true,
                'required'   => false,
            ]);
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
        return '@EkynaSocialButtons/Admin/Settings/show.html.twig';
    }

    /**
     * {@inheritDoc}
     */
    public function getFormTemplate()
    {
        return '@EkynaSocialButtons/Admin/Settings/form.html.twig';
    }
}
