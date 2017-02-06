<?php
/**
 * @desc 选择排序算法
 * Created by PhpStorm.
 * User: hewei
 * Date: 16/12/30
 * Time: 下午4:46
 *
 * cd /users/hewei/site/git/algorithms
 * /usr/local/bin/php selectSort.php num 200
 */

require("common.php");
$common = new common();
$num = isset($argv[1]) && $argv[1] == 'num' && isset($argv[2]) ? $argv[2] : 10; // 数组大小
$arr = $common->generateRandomArray($num, 1, 100000);
//echo 'before:' . print_r($arr, true);
$timeSta = $common->getMillisecond();
$n = count($arr);

for ($i = 0; $i < $n; $i++) {
    for ($j = $i + 1; $j < $n; $j++) {
        if ($arr[$j] < $arr[$i]) {
            $tmp = $arr[$i];
            $arr[$i] = $arr[$j];
            $arr[$j] = $tmp;
        }
    }
}
echo $common->timeDiff($timeSta);
//echo 'after:' . print_r($arr, true);