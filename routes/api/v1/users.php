<?php

use App\Action\Api\UserAction;
use Slim\Routing\RouteCollectorProxy;

$app->group('/api/v1/users', function (RouteCollectorProxy $group) {
    $group->get('', [UserAction::class, 'index'])->setName('users.index');
    $group->get('/{id}', [UserAction::class, 'show'])->setName('users.show');
    $group->post('', [UserAction::class, 'store'])->setName('users.store');
    $group->patch('/{id}', [UserAction::class, 'update'])->setName('users.update');
    $group->delete('/{id}', [UserAction::class, 'destroy'])->setName('users.destroy');
});
