<?php
/**
 * @desc 冒泡排序
 * Created by PhpStorm.
 * User: hewei
 * Date: 17/1/5
 * Time: 下午3:02
 */

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

echo "<pre>";
$arr = generateRandomArray(10, 1, 50);
$n = count($arr);
echo 'before:' . print_r($arr, true);
do {
    // 标记是否交换,初始为false
    $swapped = false;
    for ($i = 1; $i < $n; $i++) {
        if ($arr[$i-1] > $arr[$i]) {
            $tmp = $arr[$i];
            $arr[$i] = $arr[$i-1];
            $arr[$i-1] = $tmp;
            // 交换
            $swapped = true;
        }
        echo 'i:' . $i . ';swapped:' . $swapped . ';array:' .print_r($arr, true) . "\n\r";
    }
    echo "<br>". ';swapped:' . $swapped."\n\r";
} while ($swapped);
echo 'after:' . print_r($arr, true);