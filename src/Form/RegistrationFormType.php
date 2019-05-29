<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Captcha\Bundle\CaptchaBundle\Form\Type\CaptchaType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sex', ChoiceType::class,[
                'choices'=>['W'=>'W', 'M'=>'M'],
                'expanded' => true,
                'attr' => ['class' => 'form-check-inline'],
            ])
            ->add('firstName')
            ->add('lastName')
            ->add('dateOfBirth', DateType::class,[
                'format' => 'dd-MMM-yyyy',
                'years' => $this->getYearOfBirthOptions()
            ])
            ->add('phoneNr')
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons 4049
                        'max' => 40,
                    ]),
                ],
            ])
            ->add('terms', CheckboxType::class,[
                'label' =>'AGB'
                ] )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

    private function getYearOfBirthOptions(){
        $year = date("Y");
        return range($year-18, $year-99);
    }
}