<?php

use App\Action\Api\TransactionAction;

$app->get('/api/v1/transactions', [TransactionAction::class, 'search'])->setName('transactions.search');