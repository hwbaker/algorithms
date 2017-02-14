<?php
/**
 * @desc 希尔排序,希尔排序是插入排序的改进版
 * Created by PhpStorm.
 * User: hewei
 * Date: 17/1/5
 * Time: 下午5:27
 *
 * cd /users/hewei/site/git/algorithms
 * /usr/local/bin/php shellSort.php num 200
 */

require("common.php");
/**
 * @desc 希尔排序-while形式
 * @param $arr  数组
 * @param $size 偏移量
 */
function shellInsertSortWhile(array &$arr, $size)
{
    $n = count($arr);
    $d = 1;
    while ($d < $n/$size) {
        $d = $size * $d + 1;
    }
    echo 'n:'.$n . ';d:' . $d . "\r\n";
    while ($d >= 1) {
        //计算increment sequence:1,4,13,40,121,364,1093...
        for ($i = $d; $i < $n; $i++) {
            $element = $arr[$i];
            $j = $i - $d;
            echo 'element:'.$element.';arr[j]:'.$arr[$j].';i:'.$i . ';j:' . $j . "\r\n";
            while ($j >= 0 && $arr[$j] > $element) {
                $arr[$j+$d] = $arr[$j];
                $j -= $d;
            }
            $arr[$j+$d] = $element;
        }
        $d =  ($d-1) / $size;
    }
}

/**
 * @desc shell排序-for形式
 * @param array $arr
 * @param $size
 */
function shellInsertSortFor(array &$arr, $size)
{
    $n = count($arr);
    $d = 1;
    while ($d < $n/$size) {
        $d = $size * $d + 1;
    }
    echo 'n:'.$n . ';d:' . $d . "\r\n";
    while ($d >= 1) {
        //计算increment sequence:1,4,13,40,121,364,1093...
        for ($i = $d; $i < $n; $i++) {
            $element = $arr[$i];
            echo 'element:'.$element.';i:'.$i . "\r\n";
            for ($j = $i; $j >= $d && $arr[$j-$d] > $element; $j -= $d) {
                $arr[$j] = $arr[$j-$d];
            }
            $arr[$j] = $element;
        }
        $d =  ($d-1) / $size;
    }
}

$common = new common;
$num = isset($argv[1]) && $argv[1] == 'num' && isset($argv[2]) ? $argv[2] : 10; // 数组大小
$size = 3; //偏移量
$arr = $common->generateRandomArray($num, 1, 500);
echo 'before:' . implode(',', $arr) . "\r\n";
$timeSta = $common->getMillisecond();
shellInsertSortFor($arr, $size);
echo $common->timeDiff($timeSta);
echo 'after:' . implode(',', $arr) . "\r\n";

/**
 * @desc 网上搜索的方法
 * @param $arr
 */
function shellSort(array &$arr)
{
    $n = count($arr);
    for($gap = floor($n/2); $gap > 0; $gap = floor($gap /= 2))
    {
        for($i = $gap; $i < $n; ++$i)
        {
            for($j = $i-$gap; $j >= 0 && $arr[$j+$gap] < $arr[$j]; $j -= $gap)
            {
                $temp = $arr[$j];
                $arr[$j] = $arr[$j+$gap];
                $arr[$j+$gap] = $temp;
            }
        }
    }
}