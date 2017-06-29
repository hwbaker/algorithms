<?php

/**
 * Created by PhpStorm.
 * User: hewei
 * Date: 17/6/29
 * Time: 下午3:27
 *
 * cd /users/hewei/site/git/algorithms
 * /usr/local/bin/php unionFind3.php
 */

/**
 * Class unionFind3 并查集:基于size的优化
 */
class unionFind3
{
    private $parent = array();
    private $sz = array();

    function __construct($n)
    {
        for ($i = 0; $i < $n; $i++) {
            $this->parent[$i] = $i;
            $this->sz[$i] = 1; // sz[i]表示以i为根的集合中元素个数
        }
    }

    function __destruct()
    {
        // TODO: Implement __destruct() method.
        unset($this->parent);
        unset($this->sz);
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
            var_dump($p);
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
     * @desc 合并操作.根据元素个数有选择性的找到指向节点,使数的层数尽量低
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

        if ($this->sz[$pRoot] < $this->sz[$qRoot]) {
            $this->parent[$pRoot] = $qRoot;
            $this->sz[$qRoot] += $this->sz[$pRoot];
        } else {
            $this->parent[$qRoot] = $pRoot;
            $this->sz[$pRoot] += $this->sz[$qRoot];
        }

    }

}

$unionFind = new UnionFind3(10);
$unionFind->printData();
$unionFind->unionElements(1,2);
$unionFind->printData();
//var_dump($unionFind->isConnected(1,2));