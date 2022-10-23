<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

// Route::get('/hello-world', function () {
//     echo "<pre>";
//     $arr = [1,2,3,4,5];
//     foreach($arr as $key => $val){
//         echo $val."<br/>";
//         $arr[2] = 'Jayesh';

//     }
//     print_r($arr);


//     112 42 83 119
//     56 125 56 49
//     15 78 101 43
//     62 98 114 108


//     $n = count($matrix) / 2;
//     $max = $total = 0;

//     for($i=0;$i<$n;$i++){
//         for($j=0;$j<$n;$j++){
//             $max = 0;
//             $max = $matrix[$i][$j];
//             $max = max($matrix[$i][2*$n-$j-1], $max);
//             $max = max($matrix[2*$n-$i-1][$j], $max);
//             $max = max($matrix[2*$n-$i-1][2*$n-$j-1], $max);
//             $total +=$max;
//         }
//     }

//     return $total;




// });


// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('{any}', function () {
//     return view('app');
// })->where('any', '.*');


// Route::post('/web/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
