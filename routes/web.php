<?php

use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Concurrency;

// Route::get('/', function () {
//     [$test, $test2] = Concurrency::run([
//         fn () => (new TestController)->test(),
//         fn () => (new TestController)->test2(),
//     ]);

//     info('test', [$test]);
//     info('test2', [$test2]);
// });


Route::get('/test-join', function () {
    // Query from DB1
    // $users = DB::connection('mysql')->table('users')->get();

    // // Query from DB2
    // $orders = DB::connection('mysql2')->table('orders')->get();

    // // Attempt join in PHP
    // $result = [];
    // foreach ($users as $user) {
    //     foreach ($orders as $order) {
    //         if ($user->id == $order->user_id) {
    //             $result[] = [
    //                 'user' => $user->name,
    //                 'product' => $order->product
    //             ];
    //         }
    //     }
    // }
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
