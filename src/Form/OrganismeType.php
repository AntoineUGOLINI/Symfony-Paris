<?php

namespace App\Form;

use App\Entity\Organisme;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type as SFType;
use Symfony\Bridge\Doctrine\Tests\Form\Type\EntityTypeTest;
use Symfony\Bridge\Doctrine\Tests\Form\Type\EntityTypePerformanceTest;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;

class OrganismeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            #->add('crea_auto')
            #->add('modif_auto')
            ->add('nom_off')
            ->add('nom_farm')
            ->add('nom_siege')
            ->add('mouvance')
            ->add('rue')
            ->add('cp')
            ->add('ville')
            ->add('cedex')
            ->add('pays')
            ->add('acces')
            ->add('tel')
            ->add('tel2')
            ->add('fax')
            ->add('mail')
            ->add('web')
            #->add('res_web')
            #->add('res_det')
            #->add('rem')
            #->add('id_rubweb')
            #->add('id_edb')
            #->add('valid_edb')
            #->add('valid_web')
            #->add('modif_date')
            #->add('_id_rub')
                ->add('resume')
            ->add('confidentiel')
            #->add('id_referent')
            ->add('code_siege')
            ->add('bonus')
            #->add('user',EntityType::class,array('class'=>'App\Entity\User','choice_label'=>'id',))
            #->add('save',SFType\SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Organisme::class,
        ]);
    }
}
