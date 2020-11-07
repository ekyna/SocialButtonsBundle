<?php

namespace Ekyna\Bundle\SocialButtonsBundle\Form\Type;

use Ekyna\Bundle\SocialButtonsBundle\Model\Icons;
use Ekyna\Bundle\SocialButtonsBundle\Model\Link;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class LinkType
 * @package Ekyna\Bundle\SocialButtonsBundle\Form\Type
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class LinkType extends AbstractType
{
    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('icon', Type\ChoiceType::class, [
                'label'   => false,
                'choices' => Icons::getChoices(),
                'attr'    => [
                    'placeholder' => 'ekyna_social_buttons.link.field.icon',
                ],
            ])
            ->add('title', Type\TextType::class, [
                'label'    => false,
                'required' => false,
                'attr'     => [
                    'placeholder' => 'ekyna_social_buttons.link.field.title',
                ],
            ])
            ->add('url', Type\UrlType::class, [
                'label' => false,
                'attr'  => [
                    'placeholder' => 'ekyna_social_buttons.link.field.url',
                ],
            ]);
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Link::class,
        ]);
    }
}
