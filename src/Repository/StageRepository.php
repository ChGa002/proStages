<?php

namespace App\Repository;

use App\Entity\Stage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Stage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stage[]    findAll()
 * @method Stage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stage::class);
    }



      /**
    * @return Stage[] Returns an array of Stage objects
    */
    
    public function findAllOptimise()
    {
        return $this->createQueryBuilder('s')
            ->addSelect('e')
            ->addSelect('f')
            ->join('s.entreprise','e')
            ->join('s.formation','f')
            ->getQuery()
            ->getResult()
        ;
    }


    /**
    * @return Stage[] Returns an array of Stage objects
    */
    
    public function findByEntreprise($nomEntreprise)
    {
        return $this->createQueryBuilder('s')
            ->addSelect('e')
            ->addSelect('f')
            ->join('s.entreprise','e')
            ->join('s.formation','f')
            ->andWhere('e.nom = :nomEntreprise')
            ->setParameter('nomEntreprise', $nomEntreprise)
            ->getQuery()
            ->getResult()
        ;
    }
    
    /**
    * @return Stage[] Returns an array of Stage objects
    */
    
    public function findByFormation($nomFormation)
    {
        // Recuperer le gestionnaire d'entité

        $entityManager = $this->getEntityManager();

        // Construction de la requete
        $requete = $entityManager->createQuery(
            'SELECT s, f, e
            FROM App\Entity\Stage s
            JOIN s.formation f
            JOIN s.entreprise e
            WHERE f.Formation = :nomFormation');

        // Definition de la valeur du parametre
        $requete->setParameter('nomFormation', $nomFormation);

        // Retourner les resultats

        return $requete->execute();
    }

    /*
    public function findOneBySomeField($value): ?Stage
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
