<?php

namespace App\Form;

use App\Entity\Diploma;
use App\Entity\Registration;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DiplomaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', BirthdayType::class, array(
                'label' => 'Diploma issue date',
                'years' => range(date('Y'), date('Y')+10),
                'required' => false
            ))
            ->add('number')
            ->add('result', ResultType::class)
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


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Diploma::class,
        ]);
    }
}
