<?php

namespace App\Form;

use App\Entity\Rubrique;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type as SFType;
class RubriqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            #->add('id_fiche')
            #->add('_id_org')
            ->add('classement')
            #->add('fiche',EntityType::class,array('class'=>'App\Entity\Fiche','choice_label'=>'id',))
            #->add('organisme',EntityType::class,array('class'=>'App\Entity\Organisme','choice_label'=>'id',))
            #->add('save',SFType\SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Rubrique::class,
        ]);
    }

}
