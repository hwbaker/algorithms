<?php

/**
 * @desc 堆的基本存储.最大推实现,堆中每个父节点的元素值都大于等于其孩子结点(如果存在),这样的堆就是一个最大堆(二叉堆<=>完全二叉树,可用数组表示)
 * Created by PhpStorm.
 * User: hewei
 * Date: 17/2/14
 * Time: 下午6:09
 */
require("common.php");

class MaxHeap
{
    private $data;
    private $count;

    /**
     * @desc 上浮
     * @param $k
     */
    private function shiftUp($k)
    {
        $fNode = $k>>1; //k看做是右叶子节点坐标,找寻k的父节点坐标$k>>1 或用 floor(($k - 1) / 2);
//        $lNode = $k<<1; //左子节点
//        $rNode = ($k<<1) + 1; //右子节点
//        echo "k:{$k} \t fNode:{$fNode} \t lNode:{$lNode} \t rNode:{$rNode} \r\n";
        while ($fNode > 0 && $this->data[$fNode] < $this->data[$k]) {
            common::swap($this->data, $fNode, $k);
            $k = $fNode;
            $fNode = $k>>1;
//            echo 'k:' . $k . ';fNode:' . $fNode . "\r\n";
        }
    }

    /**
     * @desc 堆顶元素出队
     * @param $k,堆顶坐标
     */
    private function shipDown($k)
    {
        $lNode = $k<<1; //左子节点 或 2*k
        $count = $this->size();
        // 完全二叉树k节点判断是否有孩子标准:是否有左子节点
        while ($lNode <= $count) {
            // 判断k节点是否有右子节点 && 右子节点 是否大于 左子节点
            if ($lNode+1 <= $count && $this->data[$lNode + 1] > $this->data[$lNode]) {
                // data[lNode] 是 data[2*k]和data[2*k+1]中的最大值
                $lNode++;
            }
            // 父节点最大,无需交换,退出循环
            if ($this->data[$k] > $this->data[$lNode]) {
                break;
            }
            common::swap($this->data, $lNode, $k);
            $k = $lNode;
            $lNode = $k<<1;
        }
    }

    /**
     * @desc 构造函数
     * MaxHeap constructor.
     */
    public function __construct()
    {
        $this->data = array();
        $this->count = 0;
    }

    /**
     * 析构函数
     */
    public function __destruct()
    {
        unset($this->data);
    }

    public function size()
    {
        return count($this->data);
    }

    public function isEmpty(){
        return $this->size() == 0;
    }

    /**
     * @desc 堆中插入元素,入队
     * @param $item
     */
    public function insert($item)
    {
        $this->data[$this->count + 1] = $item;
        $this->count++;
        $this->shiftUp($this->count);
    }

    /**
     * @desc 从堆中取出元素.最顶取出
     */
    public function extractMax()
    {
        $returnItem = $this->data[1]; // 堆顶返回值
        common::swap($this->data, 1, $this->count); // 交换 堆顶和 最后一位
        $this->count--; //数组长度-1
        array_pop($this->data); //首元素剔除
        $this->shipDown(1);
        return $returnItem;
    }

    /**
     * @desc 打印数组
     */
    public function printData()
    {
        echo 'printData:'.print_r($this->data, true) . "\r\n";
    }
}

$maxHeap = new MaxHeap();
echo 'size before:' . $maxHeap->size() . "\r\n";
$num = isset($argv[1]) && $argv[1] == 'num' && isset($argv[2]) ? $argv[2] : 10; //数组大小

srand(time(0)); // 设置种子,并生成伪随机序列
for ($i = 0; $i < $num; $i++) {
    $maxHeap->insert(rand() % 100);
}

//$maxHeap->insert(10);
//$maxHeap->insert(40);
//$maxHeap->insert(45);
//$maxHeap->insert(100);
//$maxHeap->insert(50);

$maxHeap->printData();

// 按序输出
while (!$maxHeap->isEmpty()) {
    echo $maxHeap->extractMax() . ',';
}
echo "\r\n";
//88,64,63,55,54,44,37,15,6,4,

echo 'size after:' . $maxHeap->size() . "\r\n";
$maxHeap->printData();