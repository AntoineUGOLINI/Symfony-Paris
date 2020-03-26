<?php

namespace App\Form;

use App\Entity\Fiche;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type as SFType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class FicheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            #->add('modif_auto')
            ->add('titre')
            ->add('chapeau')
            #->add('rubriques')
            ->add('date_edition', \Symfony\Component\Form\Extension\Core\Type\DateType::class, [
        'widget' => 'single_text',
        'mapped'=> false,
        'required' => false,
        'empty_data' => '',
        ])
            ->add('date_pub', \Symfony\Component\Form\Extension\Core\Type\DateType::class, [
                'widget' => 'single_text',
                'mapped'=> false,
                'required' => false,
                'empty_data' => '',
            ])
            ->add('valid')
            ->add('voiraussi')
            ->add('classement')
            ->add('theme')
            ->add('numpage')
            ->add('numpagefin')
            ->add('partie')
            ->add('etoile')
            ->add('theme_web')
            #->add('user',EntityType::class,array('class'=>'App\Entity\User','choice_label'=>'id',))
           # ->SetMethod('GET')
           # $fiche->setReferent_id('$')
            #,$referent_id=("Select id from referent where id=referent_id";, IntegerType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Fiche::class,
        ]);
    }
}
