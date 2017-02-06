<?php
/**
 * @desc 冒泡排序
 * Created by PhpStorm.
 * User: hewei
 * Date: 17/1/5
 * Time: 下午3:02
 *
 * cd /users/hewei/site/git/algorithms
 * /usr/local/bin/php bubbleSort.php num 200
 */
require("common.php");
$common = new common();
$num = isset($argv[1]) && $argv[1] == 'num' && isset($argv[2]) ? $argv[2] : 10; //数组大小
echo 'num:' . print_r($num, true);
$arr = $common->generateRandomArray($num, 1, 2000);
$n = count($arr);
echo 'before:' . implode(',', $arr) . "\r\n";
$timeSta = $common->getMillisecond();
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
//        echo 'i:' . $i . ';swapped:' . $swapped . ';array:' .print_r($arr, true) . "\n\r";
    }
    echo "<br>". ';swapped:' . $swapped."\r\n";
} while ($swapped);
echo  $common->timeDiff($timeSta);
echo 'after:' . implode(',', $arr) . "\r\n";