<?php
use App\Jobs\ReconcileAccount;
use Illuminate\Pipeline\Pipeline;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // $user = App\User::first();

    // ReconcileAccount::dispatch($user)->onQueue('high');

    // return 'Finished';
    $pipeline = app(Pipeline::class);

    $pipeline->send('hello freaking world')
        ->through([
            function ($string, $next) {
                $string = ucwords($string);

                return $next($string);
            },

            function ($string, $next) {
                $string = str_ireplace('freaking', '', $string);

                return $next($string);
            },

            ReconcileAccount::class,
        ])
        ->then(function ($string) {
            dump($string);
        });

    return 'Done';
});
