<?php

namespace App\Controller\API;

use App\Entity\Account;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/json/import')]
class ImportController extends AbstractController
{
    #[Route('/{filename}/{account}', name: 'json_import_list', methods: ['POST', 'GET'], options: ['expose' => true])]
    public function import(string $filename, Account $account): JsonResponse
    {
        $rows = explode(PHP_EOL, file_get_contents($this->getParameter('data_dir_path').$filename));
        $transactions = [];
        $balance = 0;
        foreach($rows as $key => $row) {
            $column = explode(';', $row);
            if (str_contains(strtolower($column[0]), 'solde')) {
                $balance = $column[1];
            }
            if (1 === preg_match('#^\d{2}\/\d{2}\/\d{4}$#', $column[0])) {
                preg_match('#^(-*)([0-9,]+)#', $column[2], $amount);
                $search = ['"', 'PRELEVEMENT DE','ACHAT CB','CREDIT CARTE BANCAIRE','VIREMENT INSTANTANE DE','VIREMENT INSTANTANE A','VIREMENT DE'];
                $label = trim(str_replace($search, '', $column[1]));
                $pattern = '#^([A-z0-9:.\-\s]*)\s*(REF.+|(\d{2}\.{1}\d{2}\.{1}\d{2}.+)|(.+SALAIRE.+))$#';
                if (1 === preg_match($pattern, $label, $labelMatches)) {
                    $label = $labelMatches[1];
                }
                $transaction = [
                    'id' => $key,
                    'createdAt' => $column[0],
                    'label' => ['name' => $label],
                    'creditAccount' => ('-' === $amount[1]) ? null : $account->getId(),
                    'debitAccount' => ('-' === $amount[1]) ? $account->getId() : null,
                    'amount' => $amount[0],
                    'transactionId' => null,
                ];
                $transactions[] = $transaction;
            }

        }
        return new JsonResponse([
            'list' => $transactions,
            'balance' => $balance,
        ]);

    }
}