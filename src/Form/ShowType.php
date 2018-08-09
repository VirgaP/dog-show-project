<?php

namespace App\Form;

use App\Entity\Judges;
use App\Entity\Show;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShowType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateShow', BirthdayType::class, array(
                'label' => 'Date of the show',
                'years' => range(date('Y'), date('Y')+10),
                'required' => true
            ))
            ->add('showName', \Symfony\Component\Form\Extension\Core\Type\TextType::class,[
                'required'=>false,
                'label'=>'Name of the show'
            ])
            ->add('city')
            ->add('country')
            ->add('judges', EntityType::class, [
                'label' =>'Select judge for this show',
                'class' => Judges::class,
                'choice_label' => 'fullName',
                'required'=> false,
                'multiple' => true,
                'expanded' => true,
            ])
        ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Show::class,
        ]);
    }
}
