<?php
/**
 * Created by PhpStorm.
 * User: hewei
 * Date: 17/6/4
 * Time: 上午10:15
 * cd /users/hewei/site/git/algorithms
 * /usr/local/bin/php binarySearch.php
 */
require("common.php");

class binarySearch
{
    private $data;
    function __construct()
    {
        // 有序数组,升序
        $this->data = array(1,3,5,6,8,10);
    }

    function __destruct()
    {
        // TODO: Implement __destruct() method.
        unset($this->data);
    }

    public function printData()
    {
        echo 'data:' . print_r($this->data, true);
    }

    /**
     * @desc 二分查找
     * @param $target
     * @return bool|float
     */
    public function binarySearchCommon($target)
    {
        $arr = $this->data;
        $n = count($arr);
        // 在有序数组$arr[l...r]之间寻找 $target
        $l = 0;
        $r = $n - 1;

        while ($l <= $r) {
            $mid = floor(($l + $r)/2);
//            echo 'mid:'.$mid. "\r\n";
//            echo 'target:' . $arr[$mid] . "\r\n";
            if ($target == $arr[$mid]) {
                return $mid;
            }

            if ($target < $arr[$mid]) {
                $r = $mid - 1;
//                echo 'r:'.$r. "\r\n";
            } else {
                $l = $mid + 1;
//                echo 'l:'.$l. "\r\n";
            }

        }

        return -1;

    }

    /**
     * @desc 二分查找-递归
     * @param array $arr
     * @param $l
     * @param $r
     * @param $target
     * @return bool|float
     */
    private function __binarySearchRecursive(array $arr, $l, $r, $target)
    {
        if ($l > $r) {
            return false;
        }

        $mid = floor(($l + $r)/2);
        if ($target == $arr[$mid]) {
            return $mid;
        } else if ($target < $arr[$mid]) {
            $this->binarySearchRecursive($l, $mid - 1, $target);
        } else {
            $this->binarySearchRecursive($mid + 1, $r, $target);
        }
    }

    /**
     * @desc 二分查找-递归
     * @param $target
     */
    public function binarySearchRecursive($target)
    {
        $arr = $this->data;
        $n = count($arr);
        $this->__binarySearchRecursive($arr, 0, $n - 1, $target);
    }

}

$binaryModel = new binarySearch();
$binaryModel->printData();
$index = $binaryModel->binarySearchCommon(8);

echo 'index:' . $index."\n";
echo 'recursive Follow...' . "\n";
$index = $binaryModel->binarySearchCommon(8);
echo 'index:' . $index."\n";
