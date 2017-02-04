<?php
/**
 * @desc 希尔排序,希尔排序是插入排序的改进版
 * Created by PhpStorm.
 * User: hewei
 * Date: 17/1/5
 * Time: 下午5:27
 */

/**
 * @desc 插入排序-for
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
 * @desc 插入排序-while
 * @param $arr 数组
 * @param $d   偏移量
 */
function shellInsertSortFor(&$arr, $d)
{
    $n = count($arr);
    echo 'n:'.$n . ';d:' . $d . "\n\r";
    for ($i = $d; $i < $n; $i++) {
        $element = $arr[$i];
        for ($j = $i; $j >= $d && $arr[$j-$d] > $element; $j -= $d) {
            $arr[$j] = $arr[$j-$d];
        }
        $arr[$j] = $element;
    }
}

echo "<pre>";
$arr = generateRandomArray(10, 1, 500);
$n = count($arr);
echo 'before:' . print_r($arr, true);

//$h = $n/3;
//while ($h > 0) {
//    echo $h . ":\r\n";
//    //计算increment sequence:1,4,13,40,121,364,1093...
//    $h = 3 * $h + 1;
//    while ($h >= 1) {
//        echo $h . ';';
//        for ($i = $h; $i < $n; $i++) {
//            $element = $arr[$i];
//            for ($j = $i; $j >= $h && $arr[$j-$h] > $element ; $j -= $h) {
//                $arr[$j] = $arr[$j-$h];
//            }
//            $arr[$j] = $element;
//        }
//        $h = floor($h/3);
//        echo 'h/3:'.$h ."\r\n" ;
//    }
//}

$d = floor($n/2);
while ($d > 0) {
    shellInsertSortFor($arr, $d);
    $d = floor( $d /= 2);
}

echo 'after:' . print_r($arr, true);

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