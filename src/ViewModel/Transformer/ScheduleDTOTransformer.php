<?php

declare(strict_types=1);

namespace App\ViewModel\Transformer;

use App\Entity\Schedule;
use App\Service\TransactionService;
use App\ViewModel\ScheduleViewModel;

class ScheduleDTOTransformer
{
    public function __construct(
        private AccountDTOTransformer $accountDTOtransformer,
        private LabelDTOTransformer $labelDTOTransformer,
        private CategoryDTOTransformer $categoryDTOTransformer,
        private TransactionService $transactionService
    )
    {
        
    }

    public function fromSchedule(Schedule $schedule): ScheduleViewModel
    {
        $scheduleView = new ScheduleViewModel;

        $scheduleView->entityName = get_class($schedule);
        $scheduleView->id = $schedule->getId();
        $scheduleView->label = $this->labelDTOTransformer->fromLabel($schedule->getLabel());
        $scheduleView->category = $this->categoryDTOTransformer->fromCategory($schedule->getCategory());
        $scheduleView->debitAccount = ($schedule->getDebitAccount()) ? $this->accountDTOtransformer->fromAccount($schedule->getDebitAccount()) : null;
        $scheduleView->creditAccount = ($schedule->getCreditAccount()) ?  $this->accountDTOtransformer->fromAccount($schedule->getCreditAccount()) : null;
        $account = match(true) {
            (null !== $schedule->getDebitAccount() && null === $schedule->getCreditAccount()) => $schedule->getDebitAccount(),
            (null === $schedule->getDebitAccount() && null !== $schedule->getCreditAccount()) =>  $schedule->getCreditAccount(), 
            default => null
        };
        $scheduleView->amount = $this->transactionService->getAmount($schedule, $account);


        return $scheduleView;
    }

    public function fromSchedules(array $schedules): array
    {
        $schedulesView = [];

        foreach($schedules as $schedule) {
            $schedulesView[] = $this->fromSchedule($schedule);
        }

        return $schedulesView;
    }
}
