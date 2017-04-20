<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SocialButtonsBundle\Form\Type;

use Ekyna\Bundle\SocialButtonsBundle\Model\Icons;
use Ekyna\Bundle\SocialButtonsBundle\Model\Link;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use function Symfony\Component\Translation\t;

/**
 * Class LinkType
 * @package Ekyna\Bundle\SocialButtonsBundle\Form\Type
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class LinkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('icon', Type\ChoiceType::class, [
                'label'   => false,
                'choices' => Icons::getChoices(),
                'attr'    => [
                    'placeholder' => t('link.field.icon', [], 'EkynaSocialButtons'),
                ],
            ])
            ->add('title', Type\TextType::class, [
                'label'    => false,
                'required' => false,
                'attr'     => [
                    'placeholder' => t('link.field.title', [], 'EkynaSocialButtons'),
                ],
            ])
            ->add('url', Type\UrlType::class, [
                'label' => false,
                'attr'  => [
                    'placeholder' => t('link.field.url', [], 'EkynaSocialButtons'),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Link::class,
        ]);
    }
}
