<?php

namespace AppBundle\Form\Image;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;

/**
 * Form to create a image
 */
class ImageType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('imageFile', VichImageType::class, array(
                    'required' => false,
                    'allow_delete' => true,
                ))
                ->add('category', EntityType::class, array(
                    'class' => 'AppBundle\Entity\Category',
                    'required' => true,
                ))
                ->add('description', TextareaType::class, array(
                    'required'=> true,
                    'attr' => array('placeholder' => 'admin.description.placeholder'),
                ))
                ->add('private', CheckboxType::class, array(
                    'required'=> false,
                ));
    }

    public function getBlockPrefix() {
        
        return 'image_type';
        
    }

}
