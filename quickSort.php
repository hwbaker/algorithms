<?php
/**
 * @desc 快速排序算法
 * Created by PhpStorm.
 * User: hewei
 * Date: 17/2/10
 * Time: 上午10:08
 */
require("common.php");
/**
 * @param $arr
 */
function quickSort(&$arr)
{
    $n = count($arr);
    quickSortDetail($arr, 0, $n - 1);
}

/**
 * @desc 快速排序部分,对l和r部分进行快速排序
 * @param $arr
 * @param $l
 * @param $r
 * @return bool
 */
function quickSortDetail(&$arr, $l, $r)
{
    if ($l >= $r) {
        return false;
    }

    $p = partition($arr, $l, $r);
    quickSortDetail($arr, $l, $p - 1);
    quickSortDetail($arr, $p + 1, $r);
}

function partition (&$arr, $l, $r)
{
    $v = $arr[$l];

    $j = $l; // arr[l+1...j] < v ; arr[j+1...i) > v
    for( $i = $l + 1 ; $i <= $r ; $i ++ ) {
        if ($arr[$i] < $v) {
            $j++;

            $tmp  = $arr[$i];
            $arr[$i] = $arr[$j];
            $arr[$j] = $tmp;
        }
    }

    $tmp  = $arr[$j];
    $arr[$j] = $arr[$l];
    $arr[$l] = $tmp;

    return $j;
}

/**
 * 网上搜索-sta
 * 实现原理:
 * 找到当前数组中的任意一个元素(一般选择第一个元素),作为标准,新建两个空数组,遍历整个数组元素,如果遍历到的元素比当前的元素要小,
 * 那么就放到左边的数组,否则放到右面的数组,然后再对新数组进行同样的操作,不难发现,这里符合递归的原理,所以我们可以用递归来实现.
 *
 * 使用递归,则需要找到递归点和递归出口:
 * 递归点:如果数组的元素大于1，就需要再进行分解,所以递归点就是新构造的数组元素个数大于1
 * 递归出口:当数组元素个数变成1的时候,所以这就是递归的出口
 *
 */

$common = new common();
$num = isset($argv[1]) && $argv[1] == 'num' && isset($argv[2]) ? $argv[2] : 10; //数组大小
$arr = $common->generateRandomArray($num, 1, 2000);
//$arr = array(1,40,2,36,3);
echo 'before:' . implode(',', $arr) . "\r\n";
$timeSta = $common->getMillisecond();
quickSort($arr);
echo 'after:' . implode(',', $arr) . "\r\n";
echo  $common->timeDiff($timeSta);