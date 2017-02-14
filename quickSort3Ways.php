<?php
require("common.php");
/**
 * @desc 三路快速排序算法
 * Created by PhpStorm.
 * User: hewei
 * Date: 17/2/13
 * Time: 下午10:02
 * @param $arr
 */
function quickSort3Ways(array &$arr)
{
    $n = count($arr);
    quickSortDetail($arr, 0, $n - 1);
}

/**
 * @desc 对arr[l...r]进行处理
 * 将arr[l...r]分为 <v; ==v; >v三部分
 * 之后递归对 <v;>v 两部分继续进行三路快速排序
 * @param $arr
 * @param $l
 * @param $r
 * @return bool
 */
function quickSortDetail(array &$arr, $l, $r)
{
    if ($l >= $r) {
        echo 'l>=r => '."{$l}:{$r}\r\n";
        return false;
    }
//    if ($r - $l <= 15) {
//        // 插入排序:真对l和r区间
//        common::insertSortRange($arr, $l, $r);
//        return false;
//    }

    // partition
    srand(time(0));
    $randI = $l + rand() % ($r-$l+1);
    common::swap($arr, $l, $randI); // 将l和randI位置元素交换

    $v = $arr[$l];
    $lt = $l; // arr[l+1...lt] < v
    $gt = $r + 1; // arr[gt...r] > v
    $i = $l +1 ; // arr[lt+1...i) == v
    while ($i < $gt) {
        if ($arr[$i] < $v) {
            common::swap($arr, $i, $lt + 1);
            $lt++;
            $i++;
        } else if ($arr[$i] > $v) {
            common::swap($arr, $i, $gt - 1);
            $gt--;
        } else { // arr[i] == v
            $i++;
        }
    }
    common::swap($arr, $l, $lt);

    quickSortDetail($arr, $l, $lt - 1);
    quickSortDetail($arr, $gt, $r);
}


$common = new common();
$num = isset($argv[1]) && $argv[1] == 'num' && isset($argv[2]) ? $argv[2] : 10; //数组大小
$arr = $common->generateRandomArray($num, 1, 2000);
//$arr = array(4,3,2,1);
echo 'before:' . implode(',', $arr) . "\r\n";
$timeSta = $common->getMillisecond();
quickSort3Ways($arr);
//sortWeb($arr);
echo 'after:' . implode(',', $arr) . "\r\n";
echo  $common->timeDiff($timeSta);