<?php

namespace App\Form;

use App\Entity\Reservation;
use App\Entity\Utilisateur;
use App\Entity\Terrain;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nbrMembre')
            ->add('dateDebut')
            ->add('dateFin')
            ->add('idUtilisateur',EntityType::class,
            ['class'=>Utilisateur::class,'choice_label'=>'idUtilisateur',
            'expanded'=>true
        ])
            ->add('idTerrain',EntityType::class,
            ['class'=>Terrain::class,'choice_label'=>'idTerrain',
            'expanded'=>true
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
    /**
     * @return Reservation[]
     */
    public function findAll(): array
    {
        return $this->ReservationRepository->findAll();
    }

    public function findAllSortedByStartDate()
    {
    return $this->createQueryBuilder('r')
        ->orderBy('r.dateDebut', 'ASC')
        ->getQuery()
        ->getResult();
    }

}
