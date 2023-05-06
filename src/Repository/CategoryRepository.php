<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Label;
use App\Entity\Category;
use Doctrine\ORM\Query\Expr;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Category>
 *
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function save(Category $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Category $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
    * @return Category[] Returns an array of Category objects
    */
    public function findAllASC(): array
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.name', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findDefaultByLabel(Label $label, User $user)
    {
        return $this->createQueryBuilder('c')
        ->join('c.transactions', 't')
        ->leftJoin('t.creditAccount', 'credit')
        ->leftJoin('credit.users', 'creditUser')
        ->leftJoin('t.debitAccount', 'debit')
        ->leftJoin('debit.users', 'debitUser')
            ->andWhere(
                (new Expr())->eq('t.label', ':label'),
                (new Expr())->orX(
                    (new Expr())->eq('creditUser', ':user'),
                    (new Expr())->eq('debitUser', ':user'),
                )
            )
            ->setParameters([
                'label' => $label,
                'user' => $user,
            ])
            ->groupBy('t.category')
            ->setMaxResults(1)
            ->orderBy((new Expr())->count('t.id'), 'DESC')
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
