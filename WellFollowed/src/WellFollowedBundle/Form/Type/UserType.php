<?php
/**
 * Created by PhpStorm.
 * User: sreiss
 * Date: 06/10/15
 * Time: 22:56
 */

namespace WellFollowedBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('login')
            ->add('subscriptionDate')
            ->add('save', 'submit')
        ;
    }

    public function getName()
    {
        return 'user_form';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'WellFollowedBundle\Entity\User'
        ));
    }
}