<?php

namespace App\Repository;

use App\Entity\Deadline;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Deadline>
 *
 * @method Deadline|null find($id, $lockMode = null, $lockVersion = null)
 * @method Deadline|null findOneBy(array $criteria, array $orderBy = null)
 * @method Deadline[]    findAll()
 * @method Deadline[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeadlineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Deadline::class);
    }

    public function save(Deadline $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Deadline $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Deadline[] Returns an array of Deadline objects
     */
    public function findAllAsc(): array
    {
        return $this->createQueryBuilder('d')
            ->orderBy('d.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Deadline[] Returns an array of Deadline objects
     */
    public function findEnabled(): array
    {
        return $this->createQueryBuilder('d')
            ->join('d.months', 'm')
            ->andWhere(
                (new Expr)->orX(
                    (new Expr)->lte('d.endAt', 'CURRENT_DATE()'),
                    (new Expr)->isNull('d.endAt'),
                ),
                (new Expr)->eq('m.id', 'MONTH(CURRENT_DATE())')
            )
            ->getQuery()
            ->getResult()
        ;
    }
}
