<?php

/**
 * Created by PhpStorm.
 * User: hewei
 * Date: 17/5/9
 * Time: 下午9:02
 *
 * cd /users/hewei/site/git/algorithms
 * /usr/local/bin/php MaxHeap.php num 100
 */
require("common.php");

class MaxHeap
{
    private $data;

    public function __construct()
    {
        $this->data = array();
    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
        unset($this->data);
    }

    public function size()
    {
        return count($this->data);
    }

    public function isEmpty()
    {
        return $this->size() == 0;
    }

    public function printData()
    {
        print_r($this->data);
    }

    /**
     * @desc 元素入堆
     * @param $item
     */
    public function insert($item)
    {
        $n = $this->size();
        $n++;
        $this->data[$n] = $item;

        $this->shiftUp($n);
    }

    /**
     * @desc 堆上浮
     * @param $k
     */
    private function shiftUp($k)
    {
        // 父结点 小于 叶子结点
        while ($k > 1 && $this->data[floor($k / 2)] < $this->data[$k]) {
            common::swap($this->data, floor($k / 2), $k);
            $k = floor($k / 2);
        }
    }

    /**
     * @desc 堆顶元素出堆
     */
    public function extractMax()
    {
        $item = $this->data[1];

        $n = $this->size();
        common::swap($this->data, 1, $n);
        unset($this->data[$n]);
        $this->shiftDown(1);

        return $item;
    }

    /**
     * @desc 下沉操作
     * @param $k
     */
    private function shiftDown($k)
    {
        $n = $this->size();
        while (2 * $k <= $n) {
            $j = 2 * $k; //在此轮循环中,data[k]和data[j]交换位置
            if ($j+1 <= $n && $this->data[$j+1] > $this->data[$j]) {
                $j++;
            }
            if ($this->data[$k] > $this->data[$j]) {
                break;
            }
            common::swap($this->data, $j, $k);
            $k = $j;
        }
    }

    /**
     * @desc 最大堆排序
     * @param array $arr
     * @return array
     */
    public function maxHeapSort1(array $arr)
    {
        $n = count($arr);
        for ($i = 0; $i < $n; $i++) {
            $this->insert($arr[$i]);
        }

        for ($i = $n - 1; $i >= 0; $i--) {
            $arr[$i] = $this->extractMax();
        }
        return $arr;
    }

    /**
     * @desc 给定一个数组,使数组的排序形成"堆形状".该过程称为"Heapify"
     * @param array $arr
     */
    public function heapify(array $arr)
    {
        $n = count($arr);
        for ($i = 0; $i < $n; $i++) {
            $this->data[$i + 1] = $arr[$i];
        }

        for ($i = floor($n/2); $i >= 1; $i--) {
            $this->shiftDown($i);
        }
    }

    /**
     * @desc Heapify方式进行堆排序
     * @param array $arr
     * @return array
     */
    public function maxHeapSort2(array $arr)
    {
        $n = count($arr);
        $this->heapify($arr);
        for ($i = $n - 1; $i >= 0; $i--) {
            $arr[$i] = $this->extractMax();
        }
        return $arr;
    }

    /**
     * @desc 优化的堆索引
     */
    function heapSort(array $arr)
    {
        $n = count($arr);
        for ($i = floor($n/2) - 1; $i >= 0; $i--) {
            __shiftDown($arr, $n, $i);
        }

        for ($i = $n - 1; $i > 0; $i++) {
            common::swap($arr, 0, $i);
            __shiftDown($arr, $i, 0);
        }
    }
}

$maxHeap = new MaxHeap();
//$maxHeap->insert(2);
//$maxHeap->insert(20);
//$maxHeap->insert(22);
//$maxHeap->insert(5);
//$maxHeap->printData();

$arr = array(44, 1, 10, 113, 555, 7);
$arrResult = $maxHeap->maxHeapSort1($arr);
print_r($arrResult);

//$arrResult = $maxHeap->maxHeapSort2($arr);
//print_r($arrResult);

//$maxHeap->heapify($arr);
//$maxHeap->printData();

