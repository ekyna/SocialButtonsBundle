<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SocialButtonsBundle\Service;

use Ekyna\Bundle\SettingBundle\Schema\AbstractSchema;
use Ekyna\Bundle\SettingBundle\Schema\SettingsBuilder;
use Ekyna\Bundle\SocialButtonsBundle\Form\Type\LinkType;
use Ekyna\Bundle\UiBundle\Form\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Contracts\Translation\TranslatableInterface;

use function Symfony\Component\Translation\t;

/**
 * Class SettingSchema
 * @package Ekyna\Bundle\SocialButtonsBundle\Service
 * @author  Étienne Dauvergne <contact@ekyna.com>
 */
class SettingSchema extends AbstractSchema
{
    public function buildSettings(SettingsBuilder $builder): void
    {
        $builder
            ->setDefaults(array_merge([
                'links' => [],
            ], $this->defaults))
            ->setAllowedTypes('links', 'array');
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('links', CollectionType::class, [
                'label'      => t('link.label.plural', [], 'EkynaSocialButtons'),
                'entry_type' => LinkType::class,
                'allow_sort' => true,
                'required'   => false,
            ]);
    }

    public function getLabel(): TranslatableInterface
    {
        return t('settings.label', [], 'EkynaSocialButtons');
    }

    public function getShowTemplate(): string
    {
        return '@EkynaSocialButtons/Admin/Settings/show.html.twig';
    }

    public function getFormTemplate(): string
    {
        return '@EkynaSocialButtons/Admin/Settings/form.html.twig';
    }
}
