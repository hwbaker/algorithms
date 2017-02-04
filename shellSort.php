<?php
/**
 * @desc 希尔排序,希尔排序是插入排序的改进版
 * Created by PhpStorm.
 * User: hewei
 * Date: 17/1/5
 * Time: 下午5:27
 */

/**
 * @desc 插入排序-while
 * @param $arr 数组
 * @param $d   偏移量
 */
function shellInsertSortWhile(&$arr, $d)
{
    $n = count($arr);
    echo 'n:'.$n . ';d:' . $d . "\n\r";
    for ($i = $d; $i < $n; $i++) {
       $element = $arr[$i];
        $j = $i - $d;
        echo 'element:'.$element.';arr[j]:'.$arr[$j].';i:'.$i . ';j:' . $j . "\n\r";
        while ($j >= 0 && $arr[$j] > $element) {
            $arr[$j+$d] = $arr[$j];
            $j -= $d;
        }
        $arr[$j+$d] = $element;
    }
}

/**
 * @desc 插入排序-for
 * @param $arr 数组
 * @param $d   偏移量
 */
function shellInsertSortFor(&$arr, $d)
{
    $n = count($arr);
    echo 'n:'.$n . ';d:' . $d . "\r\n";
    for ($i = $d; $i < $n; $i++) {
        $element = $arr[$i];
        for ($j = $i; $j >= $d && $arr[$j-$d] > $element; $j -= $d) {
            $arr[$j] = $arr[$j-$d];
        }
        $arr[$j] = $element;
    }
}

/**
 * @desc SHELL排序,偏移量$size
 * @param array $arr
 * @param $size
 */
function shellSortOffSet(array $arr, $size)
{
    $n = count($arr);
    $d = 1;
    while ($d < $n/$size) {
        $d = $size * $d + 1;
    }

    while ($d >= 1) {
        echo $d . ":\r\n";
        //计算increment sequence:1,4,13,40,121,364,1093...
        for ($i = $d; $i < $n; $i++) {
            $element = $arr[$i];
            for ($j = $i; $j >= $d && $arr[$j-$d] > $element ; $j -= $d) {
                $arr[$j] = $arr[$j-$d];
            }
            $arr[$j] = $element;
        }
        $d = ($d-1) / $size;
        echo 'h/3:'.$d ."\r\n" ;
    }
}

// /usr/local/bin/php /users/hewei/site/git/algorithms/shellSort.php
$size = 3;
$arr = generateRandomArray(1000, 1, 1000);
$n = count($arr);
$d = 1;
while ($d < $n/$size) {
    $d = $size * $d + 1;
}
$time1= getMillisecond();
//echo 'before:' . implode(',', $arr) . "\r\n";
while ($d >= 1) {
    shellInsertSortFor($arr, $d);
    $d =  ($d-1) / $size;
}
$time2= getMillisecond();
$diffSecond = $time2 - $time1;
$diff = $diffSecond/3600;
//echo 'after:' . implode(',', $arr) . "\r\n";
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