<?php

namespace App\Form;

use App\Entity\Image;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('title', TextType::class, array (
        'required'   => true,
    ));
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $file = $event->getData();
            $form = $event->getForm();
            // checks if the Image object is "new"
            // If no data is passed to the form, the data is "null".
            // This should be considered a new "Image"
            if (!$file || null === $file->getId()) {
                $form
                    ->add('file', FileType::class, array(
                        'label' => 'File (JPEG/PNG/PDF file)',
                    ));
//                    ->get('file')->addModelTransformer(new CallBackTransformer(
//                        function($file) {
//                            return null;
//                        },
//                        function($fileName) {
//                            return $fileName;
//                        }
//                    ));
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
            'attr'=>array('novalidate'=>'novalidate')
        ]);
    }
}
