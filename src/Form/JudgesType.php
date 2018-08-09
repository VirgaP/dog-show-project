<?php

namespace App\Form;

use App\Entity\Judges;
use App\Entity\Show;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JudgesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('surname')
            ->add('country')
            ->add('shows', EntityType::class, [
                'label' =>'Select show',
                'class' => Show::class,
                'choice_label' => 'PlaceAndTime',
                'required'=> false,
                'multiple' => true,
                'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Judges::class,
        ]);
    }
}
