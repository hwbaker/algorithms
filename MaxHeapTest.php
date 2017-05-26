<?php

/**
 * @desc 堆的基本存储.最大推实现,堆中每个父结点的元素值都大于等于其孩子结点(如果存在),这样的堆就是一个最大堆(二叉堆<=>完全二叉树,可用数组表示)
 * Created by PhpStorm.
 * User: hewei
 * Date: 17/2/14
 * Time: 下午6:09
 *
 * cd /users/hewei/site/git/algorithms
 * /usr/local/bin/php MaxHeapTest.php num 100
 */
require("common.php");

class MaxHeapTest
{
    private $data;
    /**
     * @desc 构造函数
     * MaxHeapTest constructor.
     */
    public function __construct()
    {
        $this->data = array();
    }

    /**
     * @desc 析构函数
     */
    public function __destruct()
    {
        unset($this->data);
    }

    /**
     * @desc 返回数组大小
     * @return int
     */
    public function size()
    {
        return count($this->data);
    }

    /**
     * @desc 判断数组是否为空
     * @return bool
     */
    public function isEmpty()
    {
        return $this->size() == 0;
    }

    /**
     * @desc 打印数组
     */
    public function printData()
    {
        echo 'printData:'.print_r($this->data, true) . "\r\n";
    }

    /**
     * @desc 堆上浮
     * @param $k,入队元素坐标
     */
    private function shiftUp($k)
    {
        $fNode = $k>>1; //k看做是右叶子结点坐标,找寻k的父结点坐标$k>>1 或用 floor(($k - 1) / 2);
//        $lNode = $k<<1; //左子结点
//        $rNode = ($k<<1) + 1; //右子结点
//        echo "k:{$k} \t fNode:{$fNode} \t lNode:{$lNode} \t rNode:{$rNode} \r\n";
        while ($fNode > 0 && $this->data[$fNode] < $this->data[$k]) {
            common::swap($this->data, $fNode, $k);
            $k = $fNode;
            $fNode = $k>>1;
//            echo 'k:' . $k . ';fNode:' . $fNode . "\r\n";
        }
    }

    /**
     * @desc 堆下沉
     * @param $k,堆顶出队元素坐标
     */
    private function shiftDown($k)
    {
        $j = $k<<1; //k看作是父结点,找寻k的左子结点坐标$j = $k<<1 或用 $j = 2*$k 
        $count = $this->size();
        // 完全二叉树k结点判断是否有孩子标准:是否有左子结点
        while ($j <= $count) {
            // 判断k结点是否有右子结点 && 右子结点 是否大于 左子结点
            if ($j + 1 <= $count && $this->data[$j + 1] > $this->data[$j]) {
                // data[lNode] 是 data[2*k]和data[2*k+1]中的最大值
                $j++;
            }
            // 父结点最大,无需交换,退出循环
            if ($this->data[$k] > $this->data[$j]) {
                break;
            }
            common::swap($this->data, $j, $k);

            $k = $j;
            $j = $k<<1;
        }
    }

    /**
     * @desc 原地堆排序,且数组索引从0开始
     * @param $arr
     * @param $n   需处理数组长度
     * @param $k   父结点坐标[索引]
     */
    private function shiftDownIndexZero(&$arr, $n, $k)
    {
        // 左子结点是 2 * $k + 1
        while (2 * $k + 1 < $n) {
            $j = 2 * $k + 1;
            if ($j+1 < $n && $arr[$j + 1] > $arr[$j]) {
                $j++;
            }
            if ($arr[$k] > $arr[$j]) {
                break;
            }
            common::swap($arr, $j, $k);
            $k = $j;
        }
    }

    /**
     * @desc 原地堆排序"优化",且数组索引从0开始
     * @param $arr
     * @param $n   需处理数组长度
     * @param $k   父结点坐标[索引]
     */
    private function shiftDownIndexZeroAve(&$arr, $n, $k)
    {
        // 左子结点是 2 * $k + 1
        $ele = $arr[$k];
        while (2 * $k + 1 < $n) {
            $j = 2 * $k + 1;
            if ($j+1 < $n && $arr[$j + 1] > $arr[$j]) {
                $j++;
            }
            if ($arr[$k] > $arr[$j]) {
                break;
            }
            $arr[$k] = $arr[$j];
            $k = $j;
        }
        $arr[$k]= $ele;
    }

    /**
     * @desc 原地堆排序
     * @param $arr
     * @param $n
     */
    public function heapSort(&$arr, $n)
    {
        for ($i = floor(($n - 1 )/2) ; $i >= 0 ; $i--) {
            $this->shiftDownIndexZeroAve($arr, $n, $i);
        }

        for($i = $n - 1; $i > 0 ; $i--){
            common::swap($arr,0, $i);
            $this->shiftDownIndexZeroAve($arr, $i, 0);
        }
    }

    /**
     * @desc 堆插入元素,入队
     * @param $item
     */
    public function insert($item)
    {
        $count = $this->size();
        $count++;
        // 尾插入元素
        $this->data[$count] = $item;
        // 上浮,使数组满足最大堆定义
        $this->shiftUp($count);
    }

    /**
     * @desc 堆取出元素,堆顶元素出队
     */
    public function extractMax()
    {
        $count = $this->size();
        // 返回堆顶元素
        $reItem = $this->data[1];
        // 交换 堆顶 和 末位元素
        common::swap($this->data, 1, $count);
        // 销毁数组最后元素,数组长度-1
        unset($this->data[$count]);
//        array_pop($this->data); // 删除数组最后一个元素
        // 下沉,使数组满足最大堆定义
        $this->shiftDown(1);

        return $reItem;
    }


    /**
     * @desc 给定一个数组,使数组的排列形成'堆形状'
     * Heapify
     * @param array $arr
     */
    public function makeMaxHeap(array &$arr)
    {
        // 重新赋值数组,是索引从1开始
        $n = count($arr);
        for ($i = 0 ; $i < $n; $i++) {
            $this->data[$i + 1] = $arr[$i];
        }

        // 找寻二叉树最后一个叶子结点的父结点=>最后一个非叶子结点,或 $fNode = floor($n/2)
        for ($i = $n>>1; $i >= 1; $i--) {
            $this->shiftDown($i);
        }
    }
}

$maxHeap = new MaxHeapTest();
echo 'size before:' . $maxHeap->size() . "\r\n";
$maxHeap->printData();
$num = isset($argv[1]) && $argv[1] == 'num' && isset($argv[2]) ? $argv[2] : 10; //数组大小

//srand(time(0)); // 设置种子,并生成伪随机序列
//for ($i = 0; $i < $num; $i++) {
//    $maxHeap->insert(rand() % 100);
//}

// 元素入堆
$maxHeap->insert(2);
$maxHeap->insert(20);
$maxHeap->insert(22);
$maxHeap->insert(5);

$maxHeap->printData();
exit;

// 按倒序输出
while (!$maxHeap->isEmpty()) {
    $itemOne = $maxHeap->extractMax();
    echo $itemOne . "\n";
}

//$common = new common();
//$arr = $common->generateRandomArray($num, 1, 2000);
$arr = array(1211, 28, 108, 1839, 483);
echo "构建数组成堆...\r\narr:" . print_r($arr, true);
$maxHeap->makeMaxHeap($arr);


echo 'size after:' . $maxHeap->size() . "\r\n";
$maxHeap->printData();

echo "原地堆排序\n";
$n = count($arr);
$maxHeap->heapSort($arr, $n);
print_r($arr);



