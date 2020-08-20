<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::view('success','success');

function checkNumber($number)
{
    if (!is_numeric($number)) {
        abort(400, 'Must Be A Number');
    }
    if ($number < 1) {
        abort(400, 'Must Be at Least 1');
    }
}

Route::get('bilangan_prima/{number}', function ($number) {
    checkNumber($number);
    $isPrima = true;
    if ($number > 1) {
        for ($i = 2; $i < $number; $i++) {
            if ($number % $i === 0) {
                $isPrima = false;
                break;
            }
        }
    }
    if ($isPrima) {
        echo $number . " Merupakan bilangan Prima";
    } else {
        echo $number . " Bukanlah bilangan prima";
    }
});

Route::get('piramida/{number}', function ($number) {
    checkNumber($number);
    for ($i = 1; $i <= $number; $i++) {
        for ($j = 1; $j <= $number; $j++) {
            if ($i >= $j) {
                echo $j;
            }
        }
        echo "<br>";
    }
});
Route::get('soal5/{row}/{number}', function ($row, $number) {
    checkNumber($row);
    checkNumber($number);
    $numberOfColumn = ceil($number / $row);

    for ($i = 1; $i <= $row; $i++) {
        echo $i . ' ';
        for ($j = 1; $j < $numberOfColumn; $j++) {
            $value = $i + ($j * $row);
            if ($value <= $number)
                echo $i + ($j * $row) . ' ';
        }
        echo '<br>';


    }
});

function bubbleSort($array)
{
    $count = count($array);
    for ($i = 0; $i < $count; $i++) {
        for ($j = $count - 1; $j > $i; $j--) {
            if ($array[$j] < $array[$j - 1]) {
                $temporary = $array[$j];
                $array[$j] = $array[$j - 1];
                $array[$j - 1] = $temporary;
            }
        }
    }
    return $array;
}
