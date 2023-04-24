<?php

namespace App\Command;

use App\Entity\Deadline;
use App\Entity\Transaction;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:write-deadlines',
    description: 'Write deadlines',
)]
class WriteDeadlinesCommand extends Command
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $deadlines = $this->entityManager->getRepository(Deadline::class)->findEnabled();

        $today = new DateTimeImmutable();
        foreach ($deadlines as $deadline) {
            $createdAt = sprintf('%s-%s-%s', $today->format('Y'), $today->format('m'), $deadline->getDay());
            $transaction = new Transaction();
            $transaction->setCreatedAt(new DateTimeImmutable($createdAt))
                ->setAmount($deadline->getAmount())
                ->setCreditAccount($deadline->getCreditAccount())
                ->setDebitAccount($deadline->getDebitAccount())
                ->setLabel($deadline->getLabel())
                ->setCategory($deadline->getCategory());
            $this->entityManager->persist($transaction);
        }
        $this->entityManager->flush();

        $io->success('All deadlines have been writed.');

        return Command::SUCCESS;
    }
}
