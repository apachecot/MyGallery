<?php

namespace AppBundle\Form\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;

/**
 * Form to create a user
 */
class UserDetailType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('imageFile', VichImageType::class, array(
                    'required' => false,
                    'allow_delete' => true,
                ))
                ->add('name', TextType::class, array(
                    'required'=> true,
                    'attr' => array('placeholder' => 'admin.name.placeholder'),
                ))
                ->add('surname', TextType::class, array(
                    'required' => true,
                    'attr' => array('placeholder' => 'admin.surname.placeholder'),
                ))
                ->add('username', TextType::class, array(
                    'required' => true,
                    'attr' => array('placeholder' => 'admin.username.placeholder'),
                ))
                ->add('email', EmailType::class, array(
                    'label' => 'Email',
                    'attr' => array('placeholder' => 'admin.email.placeholder'),
                ))
                ->add('url', TextType::class, array(
                    'required'=> false,
                    'attr' => array('placeholder' => 'admin.url.placeholder'),
                ));
    }

    public function getBlockPrefix() {
        
        return 'user_type';
        
    }

}
