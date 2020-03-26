<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('roles',ChoiceType::class, [
                'choices' => [
                    'User' =>  'ROLE_USER',
                    'Admin' => 'ROLE_ADMIN',
                    'Super' => 'ROLE_SUPER_ADMIN',
                ],
                'expanded'  => false, // liste déroulante
                'multiple'  => true, // choix multiple
            ])
            /*->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat Password'),
                'mapped'=> false,
                'required' => false,
            ))*/
            #->add('password')
            ->add('nom_off')
            ->add('nom_farm')
            ->add('contact')
            ->add('tel')
            ->add('mail')
            ->add('admin')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
