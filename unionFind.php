<?php

/**
 * Created by PhpStorm.
 * User: hewei
 * Date: 17/6/8
 * Time: 下午8:04
 *
 * cd /users/hewei/site/git/algorithms
 * /usr/local/bin/php unionFind.php
 */

/**
 * Class UnionFind 并查集
 * 并查集是一种树型的数据结构，用于处理一些不相交集合(Disjoint Sets)的合并及查询问题
 *
 * 并查集是用来处理集合的,其在计算机世界中被广泛的用于处理网络连接的问题(PS:这里所说的网络连接问题并不是仅仅是计算机网络).
 * 其至少支持两种操作—合并(Join)以及查询(Find)操作.一个集合中存在一个或者多个元素,为了描述多个元素属于同一个集合,我们一般规定:
 * 集合中的每一个元素都含有一个指针用于指向其父节点,依此类推,那么一个集合中必定含有一个根节点,该节点的指针指向自身,也就是说如果一个节点的指针指向自身,那么该节点就是该集合的根节点.
 */
class UnionFind
{
    private $id = array();

    function __construct($n)
    {
        for($i = 0; $i < $n; $i++){
            $this->id[$i] = $i + $i*$i;
        }
    }

    function __destruct()
    {
        unset($id);
        // TODO: Implement __destruct() method.
    }

    function getCount()
    {
        return count($this->id);
    }

    /**
     * 打印
     */
    function printData()
    {
        print_r($this->id);
    }

    /**
     * @desc 并查集中元素的查找
     * @param $p
     * @return mixed
     */
    function find($p)
    {
        if ($p >= 0 && $p < $this->getCount()) {
            return $this->id[$p];
        }
    }

    /**
     * @desc 判断两个节点是否属于同一个集合
     * @param $p
     * @param $q
     * @return bool
     */
    function isConnected($p, $q)
    {
        return $this->find($p) == $this->find($q);
    }

    /**
     * @desc 将两个集合进行合并操作
     * @param $p
     * @param $q
     * @return bool
     */
    function unionElements($p, $q)
    {
        $pId = $this->find($p);
        $qId = $this->find($q);

        if ($pId == $qId) {
            return false;
        }

        $count = $this->getCount();
        for ($i = 0; $i < $count; $i++) {
            if ($this->id[$i] == $pId) {
                $this->id[$i] = $qId;
            }
        }
    }
}

$unionFind = new UnionFind(10);
$unionFind->printData();
$unionFind->unionElements(1,2);
$unionFind->printData();
var_dump($unionFind->isConnected(1,0));