<?php

namespace App\Form;

use App\Entity\Dog;
use App\Entity\Owner;
use App\Entity\User;
use App\Repository\DogRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;

class OwnerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('surname')
            ->add('user', EntityType::class, array(
                'class' => User::class,
                'by_reference' => true,
                'attr'=> array('style'=>'display:none'))) //setUser
            ->add('phone')
            ->add('address')
            ->add('city')
            ->add('country')
//            ->add('dogs', EntityType::class, array(
//                'class' => Dog::class,
//                'query_builder' => function (DogRepository $er) {
//                    return $er->createQueryBuilder('d')
//                        ->orderBy('d.registered_name', 'ASC');
//                },
//                'choice_label' => 'registered_name',
//                'required'=> true,
//                'multiple' => true,
//                'expanded' => true,
//            ))
            ->add('termsAccepted', CheckboxType::class, array(
                'label' => 'Check the box to accept the terms.',
                'mapped' => false,
                'constraints' => new IsTrue(),
            ))
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Owner::class,
        ]);
    }
}
