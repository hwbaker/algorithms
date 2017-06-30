<?php

/**
 * Created by PhpStorm.
 * User: hewei
 * Date: 17/6/30
 * Time: 下午4:48
 *
 * cd /users/hewei/site/git/algorithms
 * /usr/local/bin/php unionFind5.php
 */

/**
 * Class unionFind5 并查集 压缩路径
 */
class unionFind5
{
    private $parent = array();
    private $rank = array();

    public function __construct($n)
    {
        $this->parent[0] = 0;
        $this->rank[0] = $n+1;
        for ($i = 1; $i < $n; $i++) {
            $this->parent[$i] = $i+1;
            $this->rank[$i] = $i; // rank[i]表示根节点为的树的高度
        }
        $this->parent[$n] = 0;
        $this->rank[$n] = $n;
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
        echo 'parent:' . print_r($this->parent, true);
        echo 'rank:' . print_r($this->rank, true);
    }

    public function find($p)
    {
        $n = $this->getCount();

        if ($p >= 0 && $p < $n) {

            // 路径压缩版本1: path compression1
//            while ($p != $this->parent[$p]) {
//                $this->parent[$p] = $this->parent[$this->parent[$p]];
//                $p = $this->parent[$p];
//            }
//            return $p;

            // 路径压缩版本2: path compression2
            if ($p != $this->parent[$p]) {
//                echo 'parentP1:'.$this->parent[$p]."\r\n";
                $this->parent[$p] = $this->find($this->parent[$p]);
//                echo 'p:'.$p."\r\n";
//                echo 'parentP2:'.$this->parent[$p]."\r\n";
            }
            return $this->parent[$p];

        }
    }

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

$unionFind = new UnionFind5(4);
$unionFind->printData();
//$unionFind->unionElements(1,2);
//$unionFind->printData();

$unionFind->find(1);