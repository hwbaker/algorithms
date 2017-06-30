<?php

/**
 * Created by PhpStorm.
 * User: hewei
 * Date: 17/6/30
 * Time: 上午10:53
 *
 * cd /users/hewei/site/git/algorithms
 * /usr/local/bin/php unionFind4.php
 */

/**
 * Class unionFind4 基于rank的优化
 */
class unionFind4
{
    private $parent = array();
    private $rank = array();

    public function __construct($n)
    {
        for ($i = 0; $i < $n; $i++) {
            $this->parent[$i] = $i;
            $this->rank[$i] = 1; // rank[i]表示根节点为的树的高度
        }
    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
        unset($this->parent);
        unset($this->rank);
    }

    public function getCount()
    {
        return count($this->parent);
    }

    public function printData()
    {
        print_r($this->parent);
    }

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

    public function isConnected($p, $q)
    {
        return $this->find($p) == $this->find($q);
    }

    /**
     * @desc 合并操作.根据根节点树的层数,使低层数合并到高层数
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

        if ($this->rank[$pRoot] < $this->rank[$qRoot]) {
            $this->parent[$pRoot] = $qRoot;
        } elseif ($this->rank[$pRoot] > $this->rank[$qRoot]) {
            $this->parent[$qRoot] = $pRoot;
        } else { //rank[pRoot] == rank[qRoot]
            $this->parent[$pRoot] = $qRoot;
            $this->rank[$qRoot]++;
//             $this->rank[$qRoot] += $this->rank[$pRoot];
        }
    }
}

$unionFind = new UnionFind4(10);
$unionFind->printData();
$unionFind->unionElements(1,2);
$unionFind->printData();