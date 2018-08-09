<?php

namespace App\Form;

use App\Entity\Competition;
use App\Entity\Dog;
use App\Entity\Owner;
use App\Entity\Registration;
use App\Entity\Show;
use App\Entity\ShowClass;
use App\Repository\DogRepository;
use App\Repository\ShowRepository;
use App\Validation\UniqueDogInShow;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class RegistrationType extends AbstractType
{

//    protected $em;
//    public function __construct(EntityManagerInterface $em)
//    {
//        $this->em = $em;
//    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $owner = $options['owner'];
        $builder
            ->add('dog', EntityType::class, array(
                'class' => Dog::class,
                'choice_label' => 'registered_name',
                'multiple'=>false,
                'required' => !$options['update'],
                'query_builder' => function (DogRepository $repo) use ($owner) {
                return $repo->getdDogsByOwnerQuery($owner);
                },
            ))
            ->add('class', EntityType::class, array(
                'class' => ShowClass::class,
                'choice_label' => 'classTitle',
                'multiple'=>false,
        ))
            ->add('show', EntityType::class, [
                'class' => Show::class,
//                'query_builder' => function(ShowRepository $repo) {
//                    return $repo->createDateQueryBuilder();
//                },
            //return shows by date no later then todays date
                'query_builder' => function(EntityRepository $repo) {
                    $qb = $repo->createQueryBuilder('s');
                    return $qb
                        ->andWhere('s.dateShow >= :today')
                        ->setParameter('today', new \DateTime('now'))
                        ->orderBy('s.dateShow', 'ASC');
                },
                'choice_label' => 'PlaceAndTime',
                'multiple'=>false,
            ])

            ->add('competitions', EntityType::class, [
                'label' =>'Choose competition(s)(optional)',
                'class' => Competition::class,
                'choice_label' => 'competitionTitle',
                'required'=> false,
                'multiple' => true,
                'expanded' => true,
//                'by_reference'=>false
           ])
                ->add('inCatalogue', CheckboxType::class, [
                    'label'=>'Please check this box if you wish to appear in show\'s catalogue',
                    'value' => 'true',
                    'required' => false
                ])
                ->add('files', CollectionType::class,[
                    'entry_type' => ImageType::class,
                    'allow_delete' => true,
                    'allow_add' => true,
                    'by_reference' => false,
                    'prototype' => true,
//                    'disabled' => $options['is_edit'],
//                    'required' => !$options['update'],
                    'attr' => array(
                        'class' => 'my-selector',
                        'compound' => false,
                    ),
                ]);

             }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Registration::class,
            'is_edit' => false,
            'error_bubbling' => true,
            'update'                => false,
            'validation_groups'     => function (FormInterface $form) {
                $data = $form->getData();

                if ($data->getDog() == '' && $form->getConfig()->getOption('update')) {
                    return ['Default'];
                }
                return ['Default', 'Update'];
            },

            'attr'=>array('novalidate'=>'novalidate'),
            ])
            ->setRequired('owner');
    // type validation - User instance or int, you can also pick just one.
//    $resolver->setAllowedTypes('user', array(Owner::class, 'int'));
        ;
    }
}
