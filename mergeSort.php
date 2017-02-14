<?php
/**
 * @desc 归并排序 O*Nlog(N)算法
 * Created by PhpStorm.
 * User: hewei
 * Date: 17/1/6
 * Time: 下午6:05
 */

require("common.php");

/**
 * @desc 归并排序算法-总函数
 * @param array $arr
 */
function mergeSort(array &$arr)
{
    $n = count($arr);
    mergeSortDetail($arr, 0, $n - 1);
}

/**
 * @desc 递归使用归并排序,对arr[l...r]的范围进行排序.l和r前闭后闭
 * @param array $arr
 * @param $l
 * @param $r
 * @return bool
 */
function mergeSortDetail(array &$arr, $l, $r)
{
    // 递归出口:对递归到底的情况进行处理
    // 若l<r,则当前处理元素至少有两个;若l>=r,则当前处理元素只有一个或一个也没有,直接返回不做任何操作.
    // 当l和r差距非常小的时候,改用插入排序,屏蔽以下代码.
//    if ($l >= $r) {
//        echo 'l>r => '."{$l}:{$r}\r\n";
//        return false;
//    }

    // 归并排序优化二:当l和r非常小的时候,改用插入排序.具体实现如下:
    if ($r - $l <= 15) {
        // 插入排序:真对l和r区间
        common::insertSortRange($arr, $l, $r);
        return false;
    }


    // 二分查找算法,当l和r特别大,有可能发生溢出错误
    $mid = floor(($l + $r)/2);
    echo 'l:'.$l.';r:'.$r.';mid:'.$mid."\r\n";
    mergeSortDetail($arr, $l, $mid);
    echo 'mergeSortDetail(l,mid):mergeSortDetail('.$l.','.$mid.")\r\n";
    mergeSortDetail($arr, $mid + 1, $r);
    echo 'mergeSortDetail(mid+1,r):mergeSortDetail('.($mid+1).','.$r.")\r\n";
    // 归并算法优化一:当第mid比mid+1个元素大的时候,才进行归并
    if ($arr[$mid] > $arr[$mid + 1]) {
        sortDetail($arr, $l, $mid, $r);
    }
}

/**
 * @desc 将arr[l...m]和arr[m+1...r]两部分进行归并
 * @param array $arr
 * @param $l
 * @param $mid
 * @param $r
 */
function sortDetail(array &$arr, $l, $mid, $r)
{
    echo "sortDetailStart....\r\n";
    echo 'l:'.$l.';r:'.$r.';mid:'.$mid."\r\n";
    // aux[r-l+1];
    for ($i = $l; $i <= $r; $i++) {
        $aux[$i-$l] = $arr[$i];
    }
    echo 'aux:' . print_r($aux,true);
    $i = $l;
    $j = $mid + 1;
    for ($k = $l; $k <= $r; $k++) {
        if ($i > $mid) {
            $arr[$k] = $aux[$j-$l];
            $j++;
        } elseif ($j > $r){
            $arr[$k] = $aux[$i-$l];
            $i++;
        } elseif ($aux[$i-$l] < $aux[$j-$l]) {
            $arr[$k] = $aux[$i-$l];
            $i++;
        } else {
            $arr[$k] = $aux[$j-$l];
            $j++;
        }
    }
    unset($aux);
    echo 'arr:' . print_r($arr,true);
    echo "sortDetailEnd....\r\n";
}

/**
 * 网上搜索PHP算法-sta
 * @param array $arr
 */
// 归并算法总函数
function mergeSortWeb(array &$arr)
{
    $n = count($arr);
    MSort($arr, 0, $n-1);
}
// 归并递归函数
function MSort(array &$arr, $start, $end)
{
    //当子序列长度为1时，$start == $end，不用再分组
    if($start < $end){
        $mid = floor(($start + $end) / 2);	//将 $arr 平分为 $arr[$start - $mid] 和 $arr[$mid+1 - $end]
        MSort($arr,$start,$mid);			//将 $arr[$start - $mid] 归并为有序的$arr[$start - $mid]
        MSort($arr, $mid + 1, $end);			//将 $arr[$mid+1 - $end] 归并为有序的 $arr[$mid+1 - $end]
        Merge($arr, $start, $mid, $end);       //将$arr[$start - $mid]部分和$arr[$mid+1 - $end]部分合并起来成为有序的$arr[$start - $end]
    }
}
// 归并具体实现函数
function Merge(array &$arr, $start, $mid, $end)
{
    $i = $start;
    $j = $mid + 1;
    $k = $start;
    $tempArr = array();

    while ($i != $mid+1 && $j != $end+1)
    {
        if ($arr[$i] >= $arr[$j]){
            $tempArr[$k++] = $arr[$j++];
        } else {
            $tempArr[$k++] = $arr[$i++];
        }
    }

    // 将第一个子序列的剩余部分添加到已经排好序的 $tempArr 数组中
    while ($i != $mid+1) {
        $tempArr[$k++] = $arr[$i++];
    }
    // 将第二个子序列的剩余部分添加到已经排好序的 $tempArr 数组中
    while ($j != $end+1) {
        $tempArr[$k++] = $arr[$j++];
    }

    for ($i = $start; $i <= $end; $i++) {
        $arr[$i] = $tempArr[$i];
    }
}

$common = new common();
$num = isset($argv[1]) && $argv[1] == 'num' && isset($argv[2]) ? $argv[2] : 10; //数组大小
$arr = $common->generateRandomArray($num, 1, 2000);
//$arr = array(40,36,11,2);
echo 'before:' . implode(',', $arr) . "\r\n";
$timeSta = $common->getMillisecond();
mergeSort($arr);
echo 'after:' . implode(',', $arr) . "\r\n";
echo  $common->timeDiff($timeSta);