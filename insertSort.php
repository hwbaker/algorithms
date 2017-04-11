<?php
/**
 * @desc 插入排序算法,其增强版算法为希尔排序.对近乎有序数组排序,算法效率近乎O(N)
 * Created by PhpStorm.
 * User: hewei
 * Date: 17/1/4
 * Time: 下午6:02
 *
 * cd /users/hewei/site/git/algorithms
 * /usr/local/bin/php insertSort.php num 100
 */
require("common.php");

/**
 * @desc 插入排序未优化
 * @param array $arr
 */
function insertSortComplex(array &$arr)
{
    $n = count($arr);
    // 假设第一个元素有序,因此外层循环从i=1开始
    for ($i = 1; $i < $n; $i++) {
        echo 'i:' . $i . ';';
//        for ($j = $i; $j > 0; $j--) {
//            echo 'j:' . $j . ' ';
//            if ($arr[$j-1] > $arr[$j]) {
//                $tmp = $arr[$j];
//                $arr[$j] = $arr[$j-1];
//                $arr[$j-1] = $tmp;
//            } else {
//                break; //不满足交换条件,退出内层循环
//            }
//        }
        // 简化写法
        for ($j = $i; $j > 0 && $arr[$j-1] > $arr[$j]; $j--) { // && $arr[$j-1] > $arr[$j],&&关联符号满足交换条件
            echo 'j:' . $j . ' ';
            $tmp = $arr[$j];
            $arr[$j] = $arr[$j-1];
            $arr[$j-1] = $tmp;
        }
        echo "\r\n";
    }

}

/**
 * @desc 插入排序算法,改进版.第二层循环的"3步交换"比赋值更加耗费性能,因此简化"交换"操作
 * @param array $arr
 */
function insertSortAdv(array &$arr)
{
    $n = count($arr);
    // 假设第一个元素有序,因此外层循环从i=1开始
    for ($i = 1; $i < $n; $i++) {
        // 寻找arr[i]元素合适的位置
        $element = $arr[$i];
        // j保存元素element应该插入的位置
        $j = $i;
        for ($j; $j > 0 && $arr[$j-1] > $element; $j--) {
            // j元素值依次向后移一位
            $arr[$j] = $arr[$j-1];
        }
        $arr[$j] = $element;
    }
}

/**
 * @desc 第二层循环$j = $i - 1
 * @param array $arr
 */
function insertSortTest(array &$arr)
{
    $n = count($arr);
    for ($i = 1; $i < $n; $i++) {
        $element = $arr[$i];
        for ($j = $i - 1; $j >= 0 && $arr[$j] > $element; $j--) {
            $arr[$j + 1] = $arr[$j];
        }
        $arr[$j + 1] = $element;
    }

}

/**
 * @desc 插入排序算法,改进版.内层循环while形式
 * @param array $arr
 */
function insertSortAdvWhile(array &$arr)
{
    $n = count($arr);
    for ($i = 1; $i < $n; $i++) {
        $element = $arr[$i];
        $j = $i;
        while ($j > 0 && $arr[$j-1] > $element) {
            $arr[$j] = $arr[$j-1];
            $j--;
        }
        $arr[$j] = $element;
    }
}

$common = new common;
$num = isset($argv[1]) && $argv[1] == 'num' && isset($argv[2]) ? $argv[2] : 10; //数组大小
$arr = $common->generateRandomArray($num, 1, 2000);
$timeSta = $common->getMillisecond();
echo 'before:' . implode(',', $arr) . "\r\n";
insertSortTest($arr);
echo  $common->timeDiff($timeSta);
echo 'after:' . implode(',', $arr) . "\r\n";
