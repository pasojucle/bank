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
use App\ViewModel\Transaction\TransactionPresenter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/transaction')]
class TransactionController extends AbstractController
{
    public function __construct(private TransactionPresenter $transactionPresenter) {
        
    }
    
    #[Route('/', name: 'transaction_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('transaction/index.html.twig');
    }

    #[Route('/new/{account}', name: 'transaction_new', methods: ['GET', 'POST'], options: ['expose' => true])]
    public function new(Request $request, TransactionRepository $transactionRepository, Account $account): Response
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
            $transactionRepository->save($transaction, true);

            $this->transactionPresenter->present($transaction);
            return new JsonResponse([$this->transactionPresenter->viewModel()]);
        }

        return $this->render('modal/form.html.twig', [
            'title' => sprintf('Ajouter sur le comte %s', $account->getName()),
            'form' => $form->createView(),
        ]);
    }


    #[Route('/{id}/edit', name: 'transaction_edit', methods: ['GET', 'POST'], options: ['expose' => true])]
    public function edit(Request $request, Transaction $transaction, TransactionRepository $transactionRepository): Response
    {
        $form = $this->createForm(TransactionType::class, $transaction, [
            'action' => $this->generateUrl($request->attributes->get('_route'), ['id' => $transaction->getId()]),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $transactionRepository->save($transaction, true);

            $this->transactionPresenter->present($transaction);
            return new JsonResponse($this->transactionPresenter->viewModel());
        }
        $account = $transaction->getDebitAccount() ?? $transaction->getCreditAccount();

        return $this->render('modal/form.html.twig', [
            'title' => sprintf('Modifier sur le comte %s', $account->getName()),
            'form' => $form->createView(),
        ]);
    }
}