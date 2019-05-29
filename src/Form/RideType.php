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

class RideType extends AbstractType
{
    private $car_data;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // $options['car_data']; supplied from Controller, config in configureOptions
        $builder
            ->add('car', EntityType::class, [
                'class' => Car::class,
                'choices' => $options['car_data'],
                'choice_label' => function ($car) {
                    return $car->getBrand() .' '. $car->getModel();
                }
            ])
            ->add('pickUp')
            ->add('dropOff')
            ->add('price')
            ->add('passengers', ChoiceType::class,[
                'placeholder' => 'Reisende ....',
                'choices'=>[ 1=>1, 2=>2, 3=>3, 4=>4, 5=>5, 6=>6 ],
                ])
            ->add('pickUpDate', DateType::class,[
                'widget' => 'single_text',
                'format' => 'dd.MM.yyyy',

                ])
            ->add('pickUpTime', TimeType::class)
            ->add('dropOffDate', DateType::class,[
                'widget' => 'single_text',
                'format' => 'dd.MM.yyyy',

            ])
            ->add('dropOffTime', TimeType::class)
            ->add('displayProperty',ChoiceType::class,[
                'choices'=>['Nur per E-Mail'=>2, 'Nur per Handy'=>4, 'Bides'=>6 ]
            ])
            ->add('description')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ride::class,
            'car_data' => null,
        ]);
    }
}
