<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('roles', ChoiceType::class,[
                'multiple'=>true,
                'choices' => ['ROLE_USER'=>'ROLE_USER','ROLE_ADMIN'=>'ROLE_ADMIN']
            ])
            ->add('password')
            ->add('firstName')
            ->add('lastName')
            ->add('phoneNr')
            ->add('dateOfBirth')
            ->add('isEmail')
            ->add('isPhone')
            ->add('photo')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('actCode')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
