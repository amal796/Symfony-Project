<?php

namespace App\Repository;

use App\Entity\Terrain;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @method Terrain|null find($id, $lockMode = null, $lockVersion = null)
 * @method Terrain|null findOneBy(array $criteria, array $orderBy = null)
 * @method Terain[]    findAll()
 * @method Terrain[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TerrainRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, terrain::class);
    }

    public function save(Terrain $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Terrain $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function order_By_Nom()
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.nomTerrain', 'ASC')
            ->getQuery()->getResult();
    }
    public function order_By_Description()
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.descriptionTerrain', 'ASC')
            ->getQuery()->getResult();
    }


    public function searchByNom($nom)
    {
    return $this->createQueryBuilder('t')
        ->andWhere('t.nomTerrain LIKE :nom')
        ->setParameter('nom', '%'.$nom.'%')
        ->getQuery()
        ->getResult();
    }

}
