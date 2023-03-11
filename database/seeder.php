<?php

use App\Services\LocationService;
use App\Services\TransactionService;
use App\Services\UserService;

require __DIR__ . '/../vendor/autoload.php';

data_seed();

function data_seed()
{
    $faker = Faker\Factory::create();
    $usersNum = 200;
    $chunk = 500;

    for ($i = 0; $i < $usersNum; $i++) {
        $user = userData($faker);
        $userService = new UserService();
        $user_id = $userService->store($user)['result'];
        $randomLocationNum = $faker->randomDigitNotNull;
        $location_ids = [];
        for ($j = 0; $j <= $randomLocationNum; $j++) {
            $location = locationData($faker);
            $locationService = new LocationService();
            $location_id = $locationService->store($location)['result'];
            if (!empty($location_id)) {
                $location_ids[] = $location_id;
            }
        }
        if (!empty($user_id) && !empty($location_ids)) {
            echo 'Inserted new user' . PHP_EOL;
            echo "Inserted new {$randomLocationNum} locations" . PHP_EOL;
            $transactions = transactions($faker, intval($user_id), intval($location_ids[intval(array_rand($location_ids))]), $chunk);
            $transactionService = new TransactionService();
            $result = $transactionService->storeMany($transactions);
            if($result['result']) {
                echo "Inserted new {$chunk} transactions" . PHP_EOL;
            }
        }

        /** unset used variables and start fresh */
        unset(
            $user_id,
            $location_ids,
            $transactions,
            $user,
            $location,
            $randomLocationNum,
            $userService,
            $locationService,
            $transactionService
        );
    }
}

/**
 * @param mixed $faker
 * @param int $user_id
 * @param int $location_id
 * @param int $length
 * 
 * @return array
 */
function transactions(&$faker, int $user_id, int $location_id, int $length): array
{
    $data = [];
    for ($i = 0; $i < $length; $i++) {
        $data[] = [
            'user_id'       => $user_id,
            'location_id'   => $location_id,
            'amount'        => $faker->randomFloat(4, 1, 10000),
            'date'          => $faker->dateTimeThisYear->format('Y-m-d h:m:s'),
        ];
    }

    return $data;
}

/**
 * @param mixed $faker
 * 
 * @return array
 */
function userData(&$faker): array
{
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->email,
        'phone' => $faker->phoneNumber,
    ];
}

/**
 * @param mixed $faker
 * 
 * @return array
 */
function locationData(&$faker): array
{
    return [
        'country' => $faker->country,
        'state' => $faker->state,
        'city' => $faker->city
    ];
}
