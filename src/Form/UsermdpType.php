<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotCompromisedPassword;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Context\ExecutionContextInterface;


class UsermdpType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat Password'),
                'mapped'=> true,
                'required' => true,
                ));
              //$builder->add('check_password', CheckboxType::class, ['required' => false]);

    }

    /**
     * Conditional validation depending on the checkbox.
     */
    /*public function validate(array $data, ExecutionContextInterface $context): void
    {
        // Not checked so continue.
        if (!$data['check_password']) {
            return;
        }

        $violations = $context->getValidator()->validate($data['plainPassword'], [
            new NotCompromisedPassword(),
        ]);

        // If compromised assign the error to the password field
        if ($violations instanceof ConstraintViolationList && $violations->count()) {
            $password = $context->getRoot()->get('plainPassword');
            if ($password instanceof Form) {
                $password->addError(new FormError((string) $violations));
            }
        }
    }*/
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            //'constraints' => [
              //  new Callback([$this, 'validate']),
        ]);
    }
}
