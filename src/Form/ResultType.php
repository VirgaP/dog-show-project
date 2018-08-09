<?php

namespace App\Form;

use App\Entity\Result;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResultType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('grade', TextType::class, [
                'label'=>'Evaluation/grade',
                'required'=>true
            ])
            ->add('place', TextType::class, [
                'label'=>'Place',
                'required'=>true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Result::class,
        ]);
    }
}
