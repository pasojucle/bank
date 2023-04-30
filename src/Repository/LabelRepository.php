<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Label;
use Doctrine\ORM\Query\Expr;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Label>
 *
 * @method Label|null find($id, $lockMode = null, $lockVersion = null)
 * @method Label|null findOneBy(array $criteria, array $orderBy = null)
 * @method Label[]    findAll()
 * @method Label[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LabelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Label::class);
    }

    public function save(Label $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Label $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    /**
    * @return Label[] Returns an array of Label objects
    */
    public function findByUser(User $user): array
    {
        return $this->createQueryBuilder('l')
            ->andWhere(
                (new Expr)->eq('l.user', ':user')
            )
            ->setParameter('user', $user)
            ->orderBy('l.name', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
}
