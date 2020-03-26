<?php

namespace App\Form;

use App\Entity\Organisme;
use App\Entity\Rubrique;
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
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class Affect extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('organisme',EntityType::class,array('class'=>'App\Entity\Organisme','choice_label'=>'nom_off',
                'expanded' => true,
                'multiple' => true))
            #->add('save',SFType\SubmitType::class)
        ;
       /* $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event){
            $form = $event->getForm();
            $data=$event->getData();
            $rubrique=$data->getRubrique();
            $organismes=null ===$rubrique ? [] : $rubrique->getAvailablePositions();

            $form->add('organisme', OrganismeType::class, [
                'class' => 'App\Entity\Organisme',
                'placeholder' => '',
                'choices' => $organismes
            ]);
            //if(null !==$event->getData()->getOrganisme()){
            //}
        });*/
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Rubrique::class,
        ]);
    }
}
