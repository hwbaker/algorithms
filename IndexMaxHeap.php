<?php

/**
 * Created by PhpStorm.
 * User: hewei
 * Date: 17/7/7
 * Time: 上午10:19
 * cd /users/hewei/site/git/algorithms
 * /usr/local/bin/php IndexMaxHeap.php num 100
 */
require("common.php");

/**
 * @desc 索引堆-未优化版
 * Class IndexMaxHeap
 */
class IndexMaxHeap
{
    private $data;

    public function __construct()
    {
        $this->data = array();
        $this->indexes =  array();
    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
        unset($this->data);
        unset($this->indexes);
    }

    /**
     * @desc 上浮操作
     * @param $k
     */
    private function shiftUp($k)
    {
        while ($k > 1 && $this->data[$this->indexes[floor($k/2)]] < $this->data[$this->indexes[$k]]) {
            common::swap($this->indexes, floor($k/2), $k);
            $k = floor($k/2);
        }
    }

    /**
     * @desc 下沉操作
     * @param $k
     */
    public function shiftDown($k)
    {
        $n = count($this->data);
        while (2 * $k <= $n) {
            $j = 2 * $k; //在此轮循环中,data[k]和data[j]交换位置
            if ($j+1 <= $n && $this->data[$this->indexes[$j+1]] > $this->data[$this->indexes[$j]]) {
                $j++;
            }
            if ($this->data[$this->indexes[$k]] > $this->data[$this->indexes[$j]]) {
                break;
            }
            common::swap($this->indexes, $j, $k);
            $k = $j;
        }
    }

    /**
     * @desc  索引,元素入堆
     * @param $i
     * @param $item
     */
    public function insert($i, $item)
    {
        $count = count($this->data);
        // 传入的i对用户而言从0开始,最大堆索引从1开始
        $i ++;
        $this->data[$i] = $item;
        $this->indexes[$count + 1] = $i;
        $count ++;

        $this->shiftUp($count);
    }

    /**
     * @desc 堆顶出堆
     * @return mixed
     */
    public function extractMax()
    {
        $item = $this->data[$this->indexes[1]];

        $n = count($this->data);
        common::swap($this->indexes, 1, $n);

        unset($this->data[$this->indexes[$n]]);
        unset($this->indexes[$n]);

        $this->shiftDown(1);

        return $item;
    }

    /**
     * @param array $arr
     */
    public function heapify(array $arr)
    {
        $n = count($arr);
        for ($i = 0; $i < $n; $i++) {
            $this->data[$i + 1] = $arr[$i];
            // 索引
            $this->indexes[$i + 1] = $i + 1;
        }

        for ($i = floor($n/2); $i >= 1; $i--) {
            $this->shiftDown($i);
        }
    }


    public function getMax()
    {
        return $this->data[$this->indexes[1]];
    }

    public function getMaxIndex()
    {
        return $this->indexes[1];
    }

    /**
     * @desc 根据索引i返回value
     * @param $i
     * @return mixed
     */
    public function getItem($i)
    {
        return $this->data[$i + 1];
    }

    /**
     * @desc 修改
     * @param $i
     * @param $item
     */
    public function change($i, $item)
    {
        $i += 1;
        $this->data[$i] = $item;

        $count = count($this->data);
        for ($j = 1; $j <= $count; $j++) {
            if ($this->indexes[$j] == $i) {
                $this->shiftUp($j);
                $this->shiftDown($j);
                return ;
            }

        }
    }

    public function printData()
    {
        echo 'indexes:'.implode('  ',$this->indexes)."\r\n";
        echo 'data   :'.implode(' ',$this->data)."\r\n";
    }

}

$indexMaxHeap = new IndexMaxHeap();
$arr = array(15,17,19,13,22,16,28,30,41,62); // 15,17,19,13,22,16,28,30,41,62

echo implode(' ', $arr) . "\r\n";
//foreach ($arr as $k=>$v){
//    $indexMaxHeap->insert($k,$v);
//}
//$indexMaxHeap->printData();

//for ($i = 1; $i < 2; $i++) {
//    $item = $indexMaxHeap->extractMax();
//    echo $item . ' ' ;
//}
//echo "\r\n";
$indexMaxHeap->heapify($arr);
$indexMaxHeap->printData();
$indexMaxHeap->change(4, 187);
$indexMaxHeap->printData();


