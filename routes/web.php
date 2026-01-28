<?php

use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Concurrency;



Route::get('/test-join', function () {
    info(Order::all());
    info(User::all());
    $user = User::first();
    info($user);
    info($user->orders);
    $escapeIdentifier = function ($name) {
        return '`' . str_replace('`', '``', $name) . '`';
    };
    $ordersDb = $escapeIdentifier(DB::connection('mysql')->getDatabaseName());
    info('orderDB', [$ordersDb]);
    // info(
    //     User::query()
    //         ->join(DB::raw($ordersDb.'.orders'), 'users.id', '=', DB::raw($ordersDb.'.orders.user_id'))
    //         ->get()
    // );
    info(
        User::query()
            ->join(DB::raw($ordersDb.'.orders_fed'), 'users.id', '=', DB::raw($ordersDb.'.orders_fed.user_id'))
            ->get()
    );

    return Order::all();
});
