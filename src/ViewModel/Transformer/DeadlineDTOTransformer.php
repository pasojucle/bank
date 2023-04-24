<?php

declare(strict_types=1);

namespace App\ViewModel\Transformer;

use App\Entity\Deadline;
use App\Service\TransactionService;
use App\ViewModel\DeadlineViewModel;

class DeadlineDTOTransformer
{
    public function __construct(
        private AccountDTOTransformer $accountDTOtransformer,
        private LabelDTOTransformer $labelDTOTransformer,
        private CategoryDTOTransformer $categoryDTOTransformer,
        private TransactionService $transactionService
    )
    {
        
    }

    public function fromDeadline(Deadline $deadline): DeadlineViewModel
    {
        $deadlineView = new DeadlineViewModel;

        $deadlineView->entityName = get_class($deadline);
        $deadlineView->id = $deadline->getId();
        $deadlineView->label = $this->labelDTOTransformer->fromLabel($deadline->getLabel());
        $deadlineView->category = $this->categoryDTOTransformer->fromCategory($deadline->getCategory());
        $deadlineView->debitAccount = ($deadline->getDebitAccount()) ? $this->accountDTOtransformer->fromAccount($deadline->getDebitAccount()) : null;
        $deadlineView->creditAccount = ($deadline->getCreditAccount()) ?  $this->accountDTOtransformer->fromAccount($deadline->getCreditAccount()) : null;
        $account = match(true) {
            (null !== $deadline->getDebitAccount() && null === $deadline->getCreditAccount()) => $deadline->getDebitAccount(),
            (null === $deadline->getDebitAccount() && null !== $deadline->getCreditAccount()) =>  $deadline->getCreditAccount(), 
            default => null
        };
        $deadlineView->amount = $this->transactionService->getAmount($deadline, $account);


        return $deadlineView;
    }

    public function fromDeadlines(array $deadlines): array
    {
        $deadlinesView = [];

        foreach($deadlines as $deadline) {
            $deadlinesView[] = $this->fromDeadline($deadline);
        }

        return $deadlinesView;
    }
}
