<?php

namespace App\Form;

use App\Entity\Dog;
use App\Entity\Owner;
use App\Entity\Title;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime;

class DogType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('registered_name')
            ->add('owner', EntityType::class, array(
                'class' => Owner::class,
                'by_reference' => true,
                'attr'=> array('style'=>'display:none'))) //setOwner
            ->add('pedigree_reg_no')
            ->add('sex', ChoiceType::class, array(
                'choices'  => array(
                    'Female' => 'female',
                    'Male' => 'male',
                )))
            ->add('color')
            ->add('date_of_birth', BirthdayType::class, array(
                'label' => 'Date of birth',
                'format' => 'yyy MM dd',
                'years' => range(date('Y') -18, date('Y')),
                'required' => true
            ))
            ->add('titles', CollectionType::class,[
                'entry_type' => TitleType::class,
                'allow_delete' => true,
                'allow_add' => true,
                'by_reference' => false,
                'prototype' => true,
                'attr' => array(
                    'class' => 'my-selector',
                ),
            ])
//            ->add('files', CollectionType::class,[
//                'entry_type' => ImageType::class,
//                'allow_delete' => true,
//                'allow_add' => true,
//                'by_reference' => false,
//                'prototype' => true,
//                'attr' => array(
//                    'class' => 'my-selector',
//                ),
//            ])
            ->add('chip_tattoo_no')
            ->add('sire')
            ->add('dam')
            ->add('breeder')
            ->add('name_of_club')
            ->add('save', SubmitType::class, array(
                'attr' => array('class' => 'save'),
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'      => Dog::class,
            // enable/disable CSRF protection for this form
            'csrf_protection' => true,
            // the name of the hidden HTML field that stores the token
            'csrf_field_name' => '_token',
            // an arbitrary string used to generate the value of the token
            // using a different string for each form improves its security
            'csrf_token_id'   => 'task_item',
        ));
    }
}
