<?php
/**
 * @desc 插入排序算法,其增强版算法为希尔排序
 * Created by PhpStorm.
 * User: hewei
 * Date: 17/1/4
 * Time: 下午6:02
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

$arr = generateRandomArray(10, 1, 500);
echo "<pre>";
echo 'before:' . print_r($arr, true);
$n = count($arr);
// 插入排序算法
//for ($i = 1; $i < $n; $i++ ) {
//    for ($j = $i; $j > 0; $j--) {
//        if ($arr[$j] < $arr[$j-1]) {
//            $tmp = $arr[$j];
//            $arr[$j] = $arr[$j-1];
//            $arr[$j-1] = $tmp;
//        } else {
//            break; // 不满足条件提前退出
//        }
//        echo 'i:' . $i .';'.'j:' . $j .';'.print_r($arr, true);
//    }
//}

// 简化写法
//for ($i = 1; $i < $n; $i++) {
//    for ($j = $i; $j> 0 && $arr[$j] < $arr[$j-1]; $j--) { // && 关联同时满足
//        $tmp = $arr[$j];
//        $arr[$j] = $arr[$j-1];
//        $arr[$j-1] = $tmp;
//    }
//}

//插入算法的改进:第二层循环的"3步交换"比赋值更加耗费性能,因此简化"交换"操作
for ($i = 1; $i < $n; $i++) {
    // 寻找arr[i]元素合适的位置
    $element = $arr[$i];
    // j保存元素element应该插入的位置
    for ($j = $i; $j > 0 && $arr[$j-1] > $element; $j--) {
        $arr[$j] = $arr[$j-1];
    }
    $arr[$j] = $element;
}
echo 'after:' . print_r($arr, true);

//内层循环while形式
for ($i = 1; $i < $n; $i++) {
    // 寻找arr[i]元素合适的位置
    $element = $arr[$i];
    // j保存元素element应该插入的位置
    $j = $i;
    while ($j > 0 && $arr[$j-1] > $element) {
        $arr[$j] = $arr[$j-1];
        $j--;
    }
    $arr[$j] = $element;
}
echo 'after:' . print_r($arr, true);