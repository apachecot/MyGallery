<?php

namespace AppBundle\Form\User;

use Gregwar\CaptchaBundle\Type\CaptchaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Form to create a user
 */
class UserType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('name', TextType::class, array(
                    'required'=> true,
                    'attr' => array('placeholder' => 'login.name.placeholder'),
                ))
                ->add('surname', TextType::class, array(
                    'required' => true,
                    'attr' => array('placeholder' => 'login.surname.placeholder'),
                ))
                ->add('username', TextType::class, array(
                    'required' => true,
                    'attr' => array('placeholder' => 'login.username.placeholder'),
                ))
                ->add('email', EmailType::class, array(
                    'label' => 'Email',
                    'attr' => array('placeholder' => 'login.email.placeholder'),
                ))
                ->add('password', PasswordType::class, array(
                    'required'=> true,
                    'attr' => array('placeholder' => 'login.password.placeholder'),
                ))
                ->add('captcha', CaptchaType::class, array(
                    'required'=> true,
                    'attr' => array('placeholder' => 'login.captcha.placeholder'),
                ));

    }

    public function getBlockPrefix() {
        
        return 'user_type';
        
    }

}
