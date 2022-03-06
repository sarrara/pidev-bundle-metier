<?php

namespace App\Form;

use App\Entity\Activitie;
use App\Entity\Categorie;
use App\Entity\randonnee;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class RandonneeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prix')
            ->add('localisation')
            ->add('dateDeb')
            ->add('file',VichImageType::class)
            ->add('nbrPlace')
            ->add('idActivite',EntityType::class, array(
                'class' => Activitie::class,
                'choice_label' => 'nom',
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => randonnee::class,
        ]);
    }
}
