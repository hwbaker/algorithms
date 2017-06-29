<?php

/**
 * Created by PhpStorm.
 * User: hewei
 * Date: 17/6/29
 * Time: 下午3:27
 *
 * cd /users/hewei/site/git/algorithms
 * /usr/local/bin/php unionFind2.php
 */

/**
 * Class unionFind2 并查集的另外一种实现方式
 */
class unionFind2
{
    private $parent = array();

    function __construct($n)
    {
        for ($i = 0; $i < $n; $i++) {
            $this->parent[$i] = $i;
        }
    }

    function __destruct()
    {
        // TODO: Implement __destruct() method.
        unset($this->parent);
    }

    /**
     * @desc 获取大小
     * @return int
     */
    public function getCount()
    {
        return count($this->parent);
    }

    /**
     * @desc 打印
     */
    public function printData()
    {
        print_r($this->parent);
    }

    /**
     * @desc 查找
     * @param $p
     * @return mixed
     */
    public function find($p)
    {
        $n = $this->getCount();
        if ($p >= 0 && $p < $n) {
            while ($p != $this->parent[$p]) {
                $p = $this->parent[$p];
            }
            return $p;
        }
    }

    /**
     * @desc 判断两个节点是否属于同一个集合
     * @param $p
     * @param $q
     * @return bool
     */
    public function isConnected($p, $q)
    {
        return $this->find($p) == $this->find($q);
    }

    /**
     * @desc 合并操作
     * @param $p
     * @param $q
     * @return bool
     */
    public function unionElements($p, $q)
    {
        $pRoot = $this->find($p);
        $qRoot = $this->find($q);

        if ($pRoot == $qRoot) {
            return false;
        }

        $this->parent[$pRoot] = $qRoot;
    }

}

$unionFind = new UnionFind2(10);
$unionFind->printData();
$unionFind->unionElements(1,2);
$unionFind->printData();
var_dump($unionFind->isConnected(1,0));