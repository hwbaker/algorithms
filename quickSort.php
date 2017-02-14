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
 * 该算法来自算法导论,叫作Nico Lomuto方法,使用最经典的单方向一次遍历找到中值。
 * 但这种算法在最坏情况下(例如值相同的数组,需要n-1次划分,每一次划分需要O(n) 时间去掉一个元素)最坏情况下为O(n*n)
 * @param $arr
 */
function quickSort(array &$arr)
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
function quickSortDetail(array &$arr, $l, $r)
{
    if ($l >= $r) {
        echo 'l>=r => '."{$l}:{$r}\r\n";
        return false;
    }
    echo 'quickSortDetail(l,r):quickSortDetail('.$l.','.$r.")\r\n";
    $p = partition($arr, $l, $r);
    echo 'p:'.$p."\r\n";
    quickSortDetail($arr, $l, $p - 1);
    echo 'partition(l,p-1):partition('.$l.','.($p - 1).")\r\n";
    quickSortDetail($arr, $p + 1, $r);
    echo 'partition(p+1,r):partition('.($p+1).','.$r.")\r\n";
}

/**
 * @param $arr
 * @param $l
 * @param $r
 * @return mixed
 */
function partition (array &$arr, $l, $r)
{
    echo "partitionStart....\r\n";
    // 随机化快速排序算法-sta,快速排序算法的升级
    srand(time(0)); // 设置种子,并生成伪随机序列
    $randI = $l + rand() % ($r - $l + 1); // [r...l]之间产生随机数randI
    common::swap($arr, $l, $randI); // 将$arr数组l和randI位置元素交换
    // 随机快速排序算法-end

    $v = $arr[$l];
    $j = $l; // arr[l+1...j] < v ; arr[j+1...i) > v
    echo 'l:' . $l .';r:' . $r . "\r\n";
    for( $i = $l + 1 ; $i <= $r ; $i ++ ) {
        echo 'i:' . $i . "\r\n";
        if ($arr[$i] < $v) {
            echo 'j:' . $j . "\r\n";
            $j++;
            echo 'j++:' . $j . "\r\n";

            common::swap($arr, $i, $j);
            $tmp  = $arr[$i];
            $arr[$i] = $arr[$j];
            $arr[$j] = $tmp;
            echo 'j<->i:'.print_r($arr,true);
        }
    }
    echo 'j:' . $j . ';l:' . $l . ";" . print_r($arr,true);

    common::swap($arr, $l, $j);
    echo  'j<->l:' . print_r($arr, true);
    echo "partitionEnd....\r\n";
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
/**
 * @desc 比较直观,但以大量的空间为代价,使用了效率较低的merge函数
 * @param array $arr
 * @return bool
 */
function sortWeb(array &$arr)
{
    $n = count($arr);
    if ($n <= 1) {
        return $arr;
    }
    $sta = $arr[0];
    $leftArr = $rightArr = array();
    for ($i = 1; $i < $n; $i++) {
        echo 'i:' . $i ."\r\n";
        if ($arr[$i] < $sta) {
            $leftArr[] = $arr[$i];
        } else {
            $rightArr[] = $arr[$i];
        }
    }

    $leftArr = sortWeb($leftArr);
    $rightArr = sortWeb($rightArr);
    $arr = array_merge($leftArr, array($sta), $rightArr);
    return $arr;
}

$common = new common();
$num = isset($argv[1]) && $argv[1] == 'num' && isset($argv[2]) ? $argv[2] : 10; //数组大小
$arr = $common->generateRandomArray($num, 1, 2000);
//$arr = array(4,3,2,1);
echo 'before:' . implode(',', $arr) . "\r\n";
$timeSta = $common->getMillisecond();
quickSort($arr);
//sortWeb($arr);
echo 'after:' . implode(',', $arr) . "\r\n";
echo  $common->timeDiff($timeSta);