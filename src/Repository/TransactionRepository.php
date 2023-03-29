<?php

namespace App\Repository;

use App\Entity\Account;
use App\Entity\Transaction;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
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
    public function findByAccount(Account $account): array
    {
        return $this->createQueryBuilder('t')
            ->orWhere(
                (new Expr())->eq('t.creditAccount', ':account'),
                (new Expr())->eq('t.debitAccount', ':account'),
            )
            ->setParameter('account', $account)
            ->orderBy('t.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }


    public function getActualBalanceByAccount(Account $account): int
    {
        return $this->getCredit($account) - $this->getDebit($account);
    }


    public function getCheckedBalanceByAccount(Account $account): int
    {
        return $this->getCredit($account, true) - $this->getDebit($account, true);
    }

    private function getDebit(Account $account, bool $checked = false)
    {
        $credit = $this->createQueryBuilder('t')
            ->select('SUM(t.amount) AS debit')
            ->andWhere(
                (new Expr())->eq('t.debitAccount', ':account'),
            )
            ->setParameter('account', $account);
        if ($checked) {
            $credit = $this->addCriteriaCheked($credit);
        }

        return $credit->getQuery()->getSingleScalarResult() ?? 0;
    }

    private function getCredit(Account $account, bool $checked = false)
    {
        $credit = $this->createQueryBuilder('t')
            ->select('SUM(t.amount) AS credit')
            ->andWhere(
                (new Expr())->eq('t.creditAccount', ':account'),
            )
            ->setParameter('account', $account);
        if ($checked) {
            $credit = $this->addCriteriaCheked($credit);
        }

        return $credit->getQuery()->getSingleScalarResult() ?? 0;
    }

    private function addCriteriaCheked(QueryBuilder $qb): QueryBuilder
    {
        return $qb->andWhere(
            (new Expr())->eq('t.checked', ':cheked')
        )
        ->setParameter('cheked', true);
    }
}
