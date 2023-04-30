<?php

namespace App\Controller;

use App\Entity\Account;
use App\Entity\Transaction;
use App\Form\TransactionType;
use App\Repository\TransactionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\ViewModel\Transformer\AccountDTOTransformer;
use App\ViewModel\Transformer\TransactionDTOTransformer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/transaction')]
class TransactionController extends AbstractController
{
    public function __construct(
        private TransactionDTOTransformer $transactionDTOTransformer,
        private TransactionRepository $transactionRepository,
        private AccountDTOTransformer $accountDTOtransformer,
    ) {
        
    }
    
    #[Route('/{account}', name: 'transaction_index', methods: ['GET'], options: ['expose' => true])]
    public function index(Account $account): Response
    {
        return $this->render('transaction/index.html.twig', [
            'account' => $account,
        ]);
    }

    #[Route('/{account}/new', name: 'transaction_new', methods: ['GET', 'POST'], options: ['expose' => true])]
    public function new(Request $request, Account $account): Response
    {
        $transaction = new Transaction();
        $form = $this->createForm(TransactionType::class, $transaction, [
            'action' => $this->generateUrl($request->attributes->get('_route'), $request->attributes->get('_route_params')),
        ]);
        $form->handleRequest($request);

        if ($request->isMethod('POST') && $form->isSubmitted() && $form->isValid()) {
            $transactionType = $request->request->all('transaction')['transactionType'];
            $setAccount = (TransactionType::TRANSACTION_TYPE_DEBIT === (int)$transactionType) ? 'setDebitAccount' : 'setCreditAccount';
            $transaction->$setAccount($account);
            
            $this->transactionRepository->save($transaction, true);

            return new JsonResponse([
                [
                    'entity' => 'transaction',
                    'value' => $this->transactionDTOTransformer->fromTransaction($transaction, $account),
                    'sort' => 'createdAtDESC',
                ],
                [
                    'entity' => 'account',
                    'value' => $this->accountDTOtransformer->fromAccount($account),
                    'sort' => 'nameASC',
                ],
            ]);
        }

        return $this->render('modal/form.html.twig', [
            'title' => sprintf('Ajouter sur le comte %s', $account->getName()),
            'form' => $form->createView(),
        ]);
    }


    #[Route('/{id}/edit', name: 'transaction_edit', methods: ['GET', 'POST'], options: ['expose' => true])]
    public function edit(Request $request, Transaction $transaction): Response
    {
        $form = $this->createForm(TransactionType::class, $transaction, [
            'action' => $this->generateUrl($request->attributes->get('_route'), ['id' => $transaction->getId()]),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->transactionRepository->save($transaction, true);
            $account = $transaction->getDebitAccount() ?? $transaction->getCreditAccount();
            return new JsonResponse([
                [
                    'entity' => 'transaction',
                    'value' => $this->transactionDTOTransformer->fromTransaction($transaction, $account),
                    'sort' => 'createdAtDESC',
                ],
                [
                    'entity' => 'account',
                    'value' => $this->accountDTOtransformer->fromAccount($account),
                    'sort' => 'nameASC',
                ],
            ]);
        }

        $account = $transaction->getDebitAccount() ?? $transaction->getCreditAccount();

        return $this->render('modal/form.html.twig', [
            'title' => sprintf('Modifier sur le comte %s', $account->getName()),
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/check', name: 'transaction_check', methods: ['GET'], options: ['expose' => true])]
    public function check(Transaction $transaction): JsonResponse
    {
        $transaction->setChecked(true);
        $this->transactionRepository->save($transaction, true);
        $account = $transaction->getDebitAccount() ?? $transaction->getCreditAccount();

        return new JsonResponse([
            [
                'entity' => 'transaction',
                'value' => $this->transactionDTOTransformer->fromTransaction($transaction, $account),
                'sort' => 'createdAtDESC',
            ],
            [
                'entity' => 'account',
                'value' => $this->accountDTOtransformer->fromAccount($account),
                'sort' => 'nameASC',
            ],
        ]);
    }
}