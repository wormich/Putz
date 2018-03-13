<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
function caps() {
    $first = rand(1, 9); //получаем случайное значение
$second = rand(1, 7);

if ($first == $second) { //убираем возможность одинаковости первого и второго числа и исключаем тем самым нулевой результат
    $first = rand(1, 5);
    $second = rand(1, 5);
}

$t = time(); //инициализируем переменную для смены операций временем в секундах на момент запроса
$result = 0;

if ($t % 2) {

    $action = '+';
    $lbl = 'плюс';

} else {


    $action = '-';
    $lbl = 'минус';

}

if ($first < $second) {
    $first = $first + $second;


}

if ($first > 9) {

    $firs = 9;
}

if ($action == '+') {

    $result = $first + $second;

} else {
    $result = $first - $second;

}
$_SESSION["primer"] = $result;
$str = $first . ' ' . $lbl . ' ' . $second . ' = ';

echo $str;
}
?>