<?php
/**
 * @desc 双路快速排序算法
 * Created by PhpStorm.
 * User: hewei
 * Date: 17/2/13
 * Time: 下去4:08
 */

require("common.php");
/**
 * @param $arr
 */
function quickSort2Ways(&$arr)
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
function partition (&$arr, $l, $r)
{
    echo "partitionStart....\r\n";
    // 随机化快速排序算法-sta,快速排序算法的升级
    srand(time(0)); // 设置种子,并生成伪随机序列
    $randI = $l + rand() % ($r - $l + 1); // [r...l]之间产生随机数randI

    $randTemp = $arr[$l]; // 将l和randI数据交换
    $arr[$l] = $arr[$randI];
    $arr[$randI] = $randTemp;
    // 随机快速排序算法-end

    // arr[l+1...i) <= v; arr(j...r] >= v
    $v = $arr[$l];
    $i = $l + 1;
    $j = $r;
    while(true) {
        while ($i <= $r && $arr[$i] < $v) {
            $i++;
        }
        while ($j >= $l+1 && $arr[$j] > $v) {
            $j--;
        }
        if ($i > $j) {
            break;
        }

        $tmp  = $arr[$i];
        $arr[$i] = $arr[$j];
        $arr[$j] = $tmp;

        $i++;
        $j--;
    }

    $tmp  = $arr[$l];
    $arr[$l] = $arr[$j];
    $arr[$j] = $tmp;

    return $j;
}

$common = new common();
$num = isset($argv[1]) && $argv[1] == 'num' && isset($argv[2]) ? $argv[2] : 10; //数组大小
$arr = $common->generateRandomArray($num, 1, 2000);
//$arr = array(4,3,2,1);
echo 'before:' . implode(',', $arr) . "\r\n";
$timeSta = $common->getMillisecond();
quickSort2Ways($arr);
//sortWeb($arr);
echo 'after:' . implode(',', $arr) . "\r\n";
echo  $common->timeDiff($timeSta);