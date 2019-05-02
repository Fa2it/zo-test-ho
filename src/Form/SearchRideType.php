<?php

namespace App\Form;

use App\Entity\Ride;
use App\Entity\Car;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchRideType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // $options['car_data']; supplied from Controller, config in configureOptions
        $builder
            ->add('pickUp')
            ->add('dropOff')
            ->add('pickUpDate', DateType::class,[
                'widget' => 'single_text',
                'format' => 'dd.MM.yyyy',

                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ride::class,
        ]);
    }
}
