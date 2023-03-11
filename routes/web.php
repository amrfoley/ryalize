<?php

use App\Action\Web\TransactionAction;

$app->get('/transactions', [TransactionAction::class, 'index']);
