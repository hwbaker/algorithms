<?php
/**
 * @desc 希尔排序,希尔排序是插入排序的改进版
 * Created by PhpStorm.
 * User: hewei
 * Date: 17/1/5
 * Time: 下午5:27
 */

/**
 * @desc 希尔排序-while形式
 * @param $arr  数组
 * @param $size 偏移量
 */
function shellInsertSortWhile(&$arr, $size)
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
 * @param $arr  数组
 * @param $size 偏移量
 */
function shellInsertSortFor(&$arr, $size)
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

// /usr/local/bin/php /users/hewei/site/git/algorithms/shellSort.php
$size = 3;
$arr = generateRandomArray(10, 1, 100);
$time1 = getMillisecond();
echo 'before:' . implode(',', $arr) . "\r\n";
shellInsertSortFor($arr, $size);
$time2 = getMillisecond();
$diffSecond = $time2 - $time1;
$diff = $diffSecond/3600;
echo 'after:' . implode(',', $arr) . "\r\n";
echo $diffSecond;

/**
 * @desc 随机生成算法测试用例,生成n个元素的随机数,每个元素的随机范围是[rangeL,rangeR]
 * @param $n
 * @param $rangeL
 * @param $rangeR
 * @return array
 */
function generateRandomArray($n, $rangeL, $rangeR)
{
    $count = 0;
    $result = array();
    while ($count < $n) {
        $result[] = mt_rand($rangeL, $rangeR);
        $result = array_flip(array_flip($result));
        $count = count($result);
    }
    shuffle($result);
    return $result;
}

/**
 * @desc 网上搜索的方法
 * @param $arr
 */
function shellSort(&$arr)
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

/**
 * @desc 获取毫秒级时间戳
 * @return float
 */
function getMillisecond() {
    list($t1, $t2) = explode(' ', microtime());
    return (float)(floatval($t1)+floatval($t2))*1000;
}