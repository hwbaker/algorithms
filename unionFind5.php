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
require("common.php");
class unionFind5
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

    public function isConnected($p, $q)
    {
        return $this->find($p) == $this->find($q);
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

$n = 100000;
$unionFind = new UnionFind5($n);
//$unionFind->printData();

$common = new common();
$timeSta = $common->getMillisecond();

srand(time(0));
for( $i = 0 ; $i < $n ; $i ++ ){
    $a = rand()% $n;
    $b = rand() % $n;
    $unionFind->unionElements($a, $b);
}
for($i = 0 ; $i < $n ; $i ++ ){
    $a = rand() % $n;
    $b = rand() % $n;
    $unionFind->isConnected($a, $b);
}


//$unionFind->unionElements(1,2);
echo  $common->timeDiff($timeSta);
//$unionFind->printData();

//$unionFind->find(1);