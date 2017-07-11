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

    private function shiftUp($k)
    {
        while ($k > 1 && $this->data[$this->indexes[floor($k/2)]] < $this->data[$this->indexes[$k]]) {
            echo 'k:'.floor($k/2) . '_' . $k. "\r\n";
            echo 'i:' . $this->indexes[floor($k/2)] . '_' . $this->indexes[$k] . "\r\n";
//            common::swap($this->indexes, $this->indexes[floor($k/2)], $this->indexes[$k]);
            common::swap($this->indexes, floor($k/2), $k);
            $k = floor($k/2);
        }
    }

    /**
     * @desc
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

    public function printData()
    {
        echo 'indexes:'.implode('  ',$this->indexes)."\r\n";
        echo 'data   :'.implode(' ',$this->data)."\r\n";

    }

}

$indexMaxHeap = new IndexMaxHeap();
$arr = array(15,17,19,13,22,16,28,30,41,62); // 15,17,19,13,22,16,28,30,41,62

echo implode(' ', $arr) . "\r\n";
foreach ($arr as $k=>$v){
    $indexMaxHeap->insert($k,$v);
}


$indexMaxHeap->printData();