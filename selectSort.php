<?php
/**
 * @desc 选择排序算法
 * Created by PhpStorm.
 * User: hewei
 * Date: 16/12/30
 * Time: 下午4:46
 */
echo "<pre>";
$time1 = time();
$arr = generateRandomArray(100, 1, 100000);
echo 'before:' . print_r($arr, true);
$n = count($arr);
$time2 = time();
$diff = $time2 - $time1;
echo 'diff:' . $diff . "s\n\r";

for ($i = 0; $i < $n; $i++) {
    for ($j = $i + 1; $j < $n; $j++) {
        if ($arr[$j] < $arr[$i]) {
            $tmp = $arr[$i];
            $arr[$i] = $arr[$j];
            $arr[$j] = $tmp;
        }
    }
}

$time3 = time();
$diff = $time3 - $time2;
echo 'diff:' . $diff . "s\n\r";
echo 'after:' . print_r($arr, true);

/**
 * @desc 随机生成算法测试用例,生成n个元素的随机数,每个元素的随机范围是[rangeL,rangeR]
 * @param $n      数组元素个数
 * @param $rangeL 数组左范围
 * @param $rangeR 数组右范围
 * @return array
 */
function generateRandomArray($n, $rangeL, $rangeR)
{
    $count = 0;
    $return = array();
    while ($count < $n) {
        $return[] = mt_rand($rangeL, $rangeR);
        $return = array_flip(array_flip($return));
        $count = count($return);
    }
    shuffle($return);
    return $return;
}