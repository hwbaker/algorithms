<?php
/**
 * @desc 求一个数组的逆序对.
 * Created by PhpStorm.
 * User: hewei
 * Date: 17/4/20
 * Time: 下午6:32
 * cd /users/hewei/site/git/algorithms
 * /usr/local/bin/php mergeTest.php
 */

//计数num
$num = 0;

function mergeSort(array &$array)
{
    $n = count($array);
    __mergeSort($array, 0, $n - 1);
}

function __mergeSort(array &$array, $l, $r)
{
    if ($l >= $r ) {
//        echo 'l >= r:' ."$l >= $r \r\n";
        return false;
    }

    $mid = floor(($l + $r)/2);
    __mergeSort($array, $l, $mid);
    __mergeSort($array, $mid + 1, $r);
    __merge($array, $l, $mid, $r);
}

function __merge(array &$array, $l, $mid , $r)
{
    global $num;
    for ($i = $l; $i <= $r; $i++) {
        $aux[$i - $l] = $array[$i];
    }
//    echo 'aux:'.print_r($aux, true);

    $i = $l;
    $j = $mid + 1;
    $k = $l;
//    echo 'i:'.$i.',j:'.$j.',mid:'.$mid."\r\n";
    for ($k; $k <= $r; $k++) {
        if ($i > $mid) {
            $array[$k] = $aux[$j - $l];
            $num += ($mid - $i + 1);
            $j++;
        } elseif ($j > $r) {
            $array[$k] = $aux[$i - $l];
            $i++;
        } elseif ($aux[$i - $l] > $aux[$j - $l] ) {
            $array[$k] = $aux[$j - $l];
            $num += ($mid - $i + 1);
            $j++;
        } else {
            $array[$k] = $aux[$i - $l];
            $i++;
        }
    }
    unset($aux);
//    echo 'num:'.$num."\r\n";
}

$arr = array(1,40,22,13,10,3);
echo 'before:' . print_r($arr, true);
mergeSort($arr);
echo 'after:' . print_r($arr, true);
echo 'invertedPair:'.$num."\r\n";