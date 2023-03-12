<?php

namespace App\Repository;

use App\Entity\Account;
use App\Entity\Transaction;
use Doctrine\ORM\Query\Expr;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Transaction>
 *
 * @method Transaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Transaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Transaction[]    findAll()
 * @method Transaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transaction::class);
    }

    public function save(Transaction $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Transaction $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    /**
    * @return Transaction[] Returns an array of Transaction objects
    */
    public function findAllDESC(): array
    {
        return $this->createQueryBuilder('t')
            ->orderBy('c.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }


    public function getActualBalanceByAccount(Account $account): int
    {
        $credit = $this->createQueryBuilder('t')
            ->select('SUM(t.amount) AS credit')
            ->andWhere(
                (new Expr())->eq('t.creditAccount', ':account'),
            )
            ->setParameter('account', $account)
            ->getQuery()
            ->getSingleScalarResult()
            ?? 0
        ;

        $debit = $this->createQueryBuilder('t')
            ->select('SUM(t.amount) AS debit')
            ->andWhere(
                (new Expr())->eq('t.debitAccount', ':account'),
            )
            ->setParameter('account', $account)
            ->getQuery()
            ->getSingleScalarResult()
            ?? 0
        ;
        return $credit - $debit;
    }
}
