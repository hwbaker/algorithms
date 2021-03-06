<?php

/**
 * Created by PhpStorm.
 * User: hewei
 * Date: 17/7/4
 * Time: 下午3:39
 *
 * cd /users/hewei/site/git/algorithms
 * /usr/local/bin/php MGraph.php
 */

/**
 * Class MGraph.
 * 图的邻接矩阵表示以及几种简单遍历算法
 */
class MGraph{
    private $vertexArray; // 顶点数组
    private $graph; // 边邻接矩阵,即二维数组
    private $graphData; // 边的数组信息
    private $direct; // 图的类型(无向或有向):0:无向 ; 1:有向
    private $hasList; // 尝试遍历时存储遍历过的结点
    private $queue; // 广度优先遍历时存储孩子结点的队列,用数组模仿
    private $infinity = 65535;// 代表无穷,即两点无连接,建带权值的图时用,本示例不带权值
    private $primVertex; // prim算法时保存顶点
    private $primArc; // prim算法时保存边
    private $krus;// kruscal算法时保存边的信息

    public function __construct($vertexArray, $graph, $direct = 0){
        $this->vertexArray = $vertexArray;
        $this->graphData = $graph;
        $this->direct = $direct;
        // 初始化图
        $this->initializeGraph();
        // 创建图
        $this->createGraph();
    }

    /**
     * @desc 初始化图[邻接矩阵]
     */
    private function initializeGraph(){
        foreach($this->vertexArray as $value){
            foreach($this->vertexArray as $cValue){
                $this->graph[$value][$cValue] = ($value == $cValue ? 0 : $this->infinity);
            }
        }
    }

    /**
     * @desc 创建图
     * $direct 0:无向图 ; 1:有向图
     */
    private function createGraph(){
        foreach($this->graphData as $key=>$value){
            $strArr = str_split($key);
            $first = $strArr[0];
            $last = $strArr[1];
            $this->graph[$first][$last] = $value;

            if(!$this->direct){
                $this->graph[$last][$first] = $value;
            }
        }
    }

    /**
     * @desc 最短路径:floyd算法[佛洛依德算法]
     * 主要是在顶点集内,按点与点相邻边的权重做遍历,如果两点不相连则权重无穷大,这样通过多次遍历可以得到点到点的最短路径,
     * 逻辑上最好理解,实现也较为简单,时间复杂度为O(n^3);
     * @return array
     */
    public function floyd(){
        $path = array();//路径数组
        $distance = array();//距离数组
        foreach($this->graph as $key=>$value){
            foreach($value as $k=>$v){
                $path[$key][$k] = $k;
                $distance[$key][$k] = $v;
            }
        }
        for($j = 0; $j < count($this->vertexArray); $j ++){
            for($i = 0; $i < count($this->vertexArray); $i ++){
                for($k = 0; $k < count($this->vertexArray); $k ++){
                    if($distance[$this->vertexArray[$i]][$this->vertexArray[$k]] > $distance[$this->vertexArray[$i]][$this->vertexArray[$j]] + $distance[$this->vertexArray[$j]][$this->vertexArray[$k]]){
                        $path[$this->vertexArray[$i]][$this->vertexArray[$k]] = $path[$this->vertexArray[$i]][$this->vertexArray[$j]];
                        $distance[$this->vertexArray[$i]][$this->vertexArray[$k]] = $distance[$this->vertexArray[$i]][$this->vertexArray[$j]] + $distance[$this->vertexArray[$j]][$this->vertexArray[$k]];
                    }
                }
            }
        }
        return array('path' => $path, 'distance' => $distance);
    }

    /**
     * @desc 最短路径:dijkstra算法[迪杰斯特拉算法],OSPF中实现最短路由所用到的经典算法,
     * 其算法的本质是贪心算法,不断的遍历扩充顶点路径集合S,一旦发现更短的点到点路径就替换S中原有的最短路径,完成所有遍历后S便是所有顶点的最短路径集合了.
     * 时间复杂度为O(n^2)
     * @return array
     */
    public function dijkstra(){
        $final = array();
        $pre = array();//要查找的结点的前一个结点数组
        $weight = array();//权值和数组
        foreach($this->graph[$this->vertexArray[0]] as $k=>$v){
            $final[$k] = 0;
            $pre[$k] = $this->vertexArray[0];
            $weight[$k] = $v;
        }
        $final[$this->vertexArray[0]] = 1;
        for($i = 0; $i < count($this->vertexArray); $i ++){
            $key = 0;
            $min = $this->infinity;
            for($j = 1; $j < count($this->vertexArray); $j ++){
                $temp = $this->vertexArray[$j];
                if($final[$temp] != 1 && $weight[$temp] < $min){
                    $key = $temp;
                    $min = $weight[$temp];
                }
            }
            $final[$key] = 1;
            for($j = 0; $j < count($this->vertexArray); $j ++){
                $temp = $this->vertexArray[$j];
                if($final[$temp] != 1 && ($min + $this->graph[$key][$temp]) < $weight[$temp]){
                    $pre[$temp] = $key;
                    $weight[$temp] = $min + $this->graph[$key][$temp];
                }
            }
        }
        return $pre;
    }

    /**
     * @desc 最短路径:kruskal算法[克鲁斯卡尔算法]
     * 在图内构造最小生成树,达到图中所有顶点联通,从而得到最短路径
     * 时间复杂度为O(N*logN)
     */
    private function kruskal(){
        $this->krus = array();
        foreach($this->vertexArray as $value){
            $krus[$value] = 0;
        }
        foreach($this->graph as $key=>$value){
            $begin = $this->findRoot($key);
            foreach($value as $k=>$v){
                $end = $this->findRoot($k);
                if($begin != $end){
                    $this->krus[$begin] = $end;
                }
            }
        }
    }

    /**
     * @desc 查找子树的尾结点
     * @param $node
     * @return mixed
     */
    private function findRoot($node){
        while($this->krus[$node] > 0){
            $node = $this->krus[$node];
        }
        return $node;
    }

    /**
     * @desc 最小生成树:prim算法[普里姆算法]
     * @return array
     */
    public function prim(){
        $this->primVertex = array();
        $this->primArc = array($this->vertexArray[0]=>0);
        for($i = 1; $i < count($this->vertexArray); $i ++){
            $this->primArc[$this->vertexArray[$i]] = $this->graph[$this->vertexArray[0]][$this->vertexArray[$i]];
            $this->primVertex[$this->vertexArray[$i]] = $this->vertexArray[0];
        }
        for($i = 0; $i < count($this->vertexArray); $i ++){
            $min = $this->infinity;
            $key;
            foreach($this->vertexArray as $k=>$v){
                if($this->primArc[$v] != 0 && $this->primArc[$v] < $min){
                    $key = $v;
                    $min = $this->primArc[$v];
                }
            }
            $this->primArc[$key] = 0;
            foreach($this->graph[$key] as $k=>$v){
                if($this->primArc[$k] != 0 && $v < $this->primArc[$k]){
                    $this->primArc[$k] = $v;
                    $this->primVertex[$k] = $key;
                }
            }
        }
        return $this->primVertex;
    }

    /**
     * @desc 最小生成树:一般算法
     * @return array
     */
    public function bst(){
        $this->primVertex = array($this->vertexArray[0]);
        $this->primArc = array();
        next($this->graph[key($this->graph)]);
        $key = NULL;
        $current = NULL;
        while(count($this->primVertex) < count($this->vertexArray)){
            foreach($this->primVertex as $value){
                foreach($this->graph[$value] as $k=>$v){
                    if(!in_array($k, $this->primVertex) && $v != 0 && $v != $this->infinity){
                        if($key == NULL || $v < current($current)){
                            $key = $k;
                            $current = array($value . $k=>$v);
                        }
                    }
                }
            }
            $this->primVertex[] = $key;
            $this->primArc[key($current)] = current($current);
            $key = NULL;
            $current = NULL;
        }
        return array('vertexArray'=>$this->primVertex, 'graph'=>$this->primArc);
    }

    /**
     * @desc 遍历:一般遍历
     * @return string
     */
    public function reserve(){
        $this->hasList = array();
        foreach($this->graph as $key=>$value){
            if(!in_array($key, $this->hasList)){
                $this->hasList[] = $key;
            }
            foreach($value as $k=>$v){
                if($v == 1 && !in_array($k, $this->hasList)){
                    $this->hasList[] = $k;
                }
            }
        }
        foreach($this->vertexArray as $v){
            if(!in_array($v, $this->hasList))
                $this->hasList[] = $v;
        }
        return implode($this->hasList);
    }

    /**
     * @desc 遍历:广度优先遍历 broad first spanning
     * @return string
     */
    public function bfs(){
        $this->hasList = array();
        $this->queue = array();
        foreach($this->graph as $key => $value){
            if(!in_array($key, $this->hasList)){
                $this->hasList[] = $key;
                $this->queue[] = $value;
                while(!empty($this->queue)){
                    $child = array_shift($this->queue);
                    foreach($child as $k=>$v){
                        if($v == 1 && !in_array($k, $this->hasList)){
                            $this->hasList[] = $k;
                            $this->queue[] = $this->graph[$k];
                        }
                    }
                }
            }
        }
        return implode($this->hasList);
    }

    /**
     * @desc 遍历:深度优先遍历 depth first spanning
     * @return string
     */
    public function dfs(){
        $this->hasList = array();
        foreach($this->vertexArray as $key){
            if(!in_array($key, $this->hasList))
                $this->executeDfs($key);
        }
        return implode($this->hasList);
    }

    /**
     * @desc 执行深度优先遍历
     * @param $key
     */
    public function executeDfs($key){
        $this->hasList[] = $key;
        foreach($this->graph[$key] as $k=>$v){
            if($v == 1 && !in_array($k, $this->hasList)) {
                $this->executeDfs($k);
            }
        }
    }

    /**
     * @desc 图的表示.二维数组矩阵
     * @return mixed
     */
    public function showArc(){
//        return $this->graph;
        echo '  ';
        foreach ($this->graph as $vertexFather => $edgeFather) {
            echo str_pad($vertexFather, 6);
        }
        echo "\r\n";

        foreach ($this->graph as $vertexFather => $edgeFather) {
            echo $vertexFather . ' ';
            foreach ($edgeFather as $vertex => $edge) {
                echo str_pad($edge, 6);
            }
            echo "\r\n";
        }
    }

    /**
     * @desc 顶点的二维数组表示
     * @return int
     */
    public function getVertex(){
        return $this->vertexArray;
    }
}

// 顶点
$vertex = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i');
// 键为边, 值权值
$graph = array(
    'ab'=>'10', 'af'=>'11',
    'bg'=>'16', 'bc'=>'18', 'bi'=>'12',
    'ci'=>'8', 'cd'=>'22',
    'di'=>'21', 'dg'=>'24', 'dh'=>'16', 'de'=>'20',
    'eh'=>'7',
    'fg'=>'17', 'fe'=>'26',
    'gh'=>'19',
);
$MGraph = new MGraph($vertex, $graph);
echo  $MGraph->showArc();
echo  '顶点:' . implode( ' ', $MGraph->getVertex()) . "\r\n";

echo 'reverse():'.print_r($MGraph->reserve(),true) . "\r\n";
echo 'bfs()    :'.print_r($MGraph->bfs(),true) . "\r\n";
echo 'dfs()    :'.print_r($MGraph->dfs(),true) . "\r\n";

//echo 'floyd() :'.print_r($MGraph->floyd(),true) . "\r\n";
echo 'dijkstra():'.print_r($MGraph->dijkstra(),true) . "\r\n";