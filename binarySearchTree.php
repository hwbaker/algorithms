<?php

/**
 * @desc 二分搜索树
 * Created by PhpStorm.
 * User: hewei
 * Date: 17/6/4
 * Time: 下午4:29
 * cd /users/hewei/site/git/algorithms
 * /usr/local/bin/php binarySearchTree.php
 */
class Node
{
    public $key = null;
    public $value = null;
    public $left = null;
    public $right = null;
}

/**
 * Class BSR:Binary Search Tree
 */
class BST
{
    private $root;

    function __construct()
    {
        $this->root = null;
    }


    function __destruct()
    {
        // TODO: Implement __destruct() method.
        // 释放空间,销毁对象
        $this->destroy($this->root);
    }

    /**
     * @desc 打印树
     */
    public function printNode()
    {
        print_r($this->root);
    }

    /**
     * @desc 插入元素
     * @param $key
     * @param $value
     */
    public function insert($key, $value)
    {
        $this->root = $this->insertPrivate($this->root, $key, $value);
    }

    /**
     * @desc  查找二分搜索树中是否存在某个key值
     * @param $key
     * @return bool
     */
    public function contain($key)
    {
        return $this->containPrivate($this->root, $key);
    }

    /**
     * @desc  查找key所对应的val
     * @param $key
     * @return null
     */
    public function search($key)
    {
        return $this->searchPrivate($this->root, $key);
    }

    /**
     * 前序遍历
     */
    public function preOrder()
    {
        $this->preOrderPrivate($this->root);
    }

    /**
     * 中序遍历
     */
    public function inOrder()
    {
        $this->inOrderPrivate($this->root);
    }

    /**
     * 后序遍历
     */
    public function postOrder()
    {
        $this->postOrderPrivate($this->root);
    }

    /**
     * @desc 向以node为根的二叉搜索树中,插入节点(key, val)
     * 返回插入新节点后的二叉搜索树的根
     * @param $node
     * @param $key
     * @param $value
     * @return Node
     */
    private function insertPrivate($node, $key, $value)
    {
        // 根节点 空
        if ($node == null) {
            $root = new Node();
            $root->key = $key;
            $root->value = $value;
            return $root;
        }

        if ($key == $node->key ) {
            $node->value = $value;
        } else if ($key < $node->key ) { // key < node->key,左子节点
            $node->left = $this->insertPrivate( $node->left , $key, $value);
        } else { // key > node->key,右子节点
            $node->right = $this->insertPrivate( $node->right, $key, $value);
        }
        return $node;
    }

    /**
     * @param $node
     * @param $key
     * @return bool
     */
    private function containPrivate($node, $key)
    {
        if ($node == null) {
            return false;
        }

        if ($key == $node->key) {
            return true;
        } else if ($key < $node->key) {
            return $this->containPrivate($node->left, $key);
        } else {
            return $this->containPrivate($node->right, $key);
        }
    }

    /**
     * @desc  在以node为根的二叉搜索树中查找key所对应的value
     * @param $node
     * @param $key
     * @return null
     */
    private function searchPrivate($node, $key)
    {
        if ($node == null) {
            return null;
        }

        if ($key == $node->key) {
            return $node->value;
        } else if ($key < $node->key) {
            return $this->searchPrivate($node->left, $key);
        } else {// key > node->key
            return $this->searchPrivate($node->right, $key);
        }
    }

    /**
     * @desc 对以node为节点的二叉搜索树进行前序遍历
     * @param $node
     */
    private function preOrderPrivate($node)
    {
        if ($node != null) {
            var_dump($node->key);
            $this->preOrderPrivate($node->left);
            $this->preOrderPrivate($node->right);
        }
    }

    /**
     * @desc 对以node为节点的二叉搜索树进行中序遍历
     * @param $node
     */
    private function inOrderPrivate($node)
    {
        if ($node != null) {
            $this->inOrderPrivate($node->left);
            var_dump($node->key);
            $this->inOrderPrivate($node->right);
        }
    }

    /**
     * @desc 对以node为节点的二叉搜索树进行后序遍历
     * @param $node
     */
    private function postOrderPrivate($node)
    {
        if ($node != null) {
            $this->postOrderPrivate($node->left);
            $this->postOrderPrivate($node->right);
            var_dump($node->key);
        }
    }

    /**
     * @param $node
     */
    private function destroy($node)
    {
        if ($node != null) {
            $this->destroy($node->left);
            $this->destroy($node->right);

            //释放node todo...
            unset($node);
        }
    }

}
/**
 * @desc 初始化构建一个二分搜索树
 * 使用数组构建二分搜索树,将数组传递到函数中,遍历循环数组，将数组中的元素依次添加到二分搜索树中
 * @param array $arr
 * @return bool|Node
 */
function buildBinarySearchTree(array $arr)
{
    if (empty($arr)) {
        return false;
    }
    // 初始化根节点
    $root = new Node();
    $level = 1;
    foreach ($arr as $key => $value) {
        if ($level == 1 ) {
            $root->key = $key;
            $root->value = $value;
        } else {
            $newNode = new Node();
            $newNode->key = $key;
            $newNode->value = $value;
            //将新创建的节点，添加到初始化好的二分搜索树中
            /*
            添加操作，是初始化二分搜索树的关键操作
            因为在处理添加节点的过程之中要根据传入的数据的大小，不断的分析新节点需要存放的位置
            */
            insertBinarySearchTree($root, $newNode);
        }
        $level++;
    }

    return $root;
}

/**
 * @desc 添加节点到二分搜索树中
 * 思路如下:如果待添加的节点的key大于(小于)根节点,就将该节点与根节点的右(左)子节点继续比较
 * 如果根节点的右(左)节点为空,也就是说根节点并不存在右(左)子节点,就将该节点放置到根节点的右(左)子节点的位置上
 * 如果存在右(左)子节点,就将该新增的节点与右(左)子节点继续按照上面的方式比较,直到放置到合适的位置为止
 * @param $root
 * @param $newNode
 * @return bool
 */
function insertBinarySearchTree($root, $newNode)
{
    if ($root->key == $newNode->key) {
        $root->value = $newNode->value;
        return true;
    } else if ($root->key > $newNode->key) {
        if ($root->left == null) {
            $root->left = $newNode;
            return true;
        } else {
            $root = $root->left;
            insertBinarySearchTree($root, $newNode);
        }
    } else {
        if ($root->right == null) {
            $root->right = $newNode;
            return true;
        } else {
            $root = $root->right;
            insertBinarySearchTree($root, $newNode);
        }
    }
}

$BST = new BST();
$BST->insert(32,'32q');
$BST->insert(28,'28a');
$BST->insert(16,'16s');
$BST->insert(13,'13d');
$BST->insert(22,'22f');
$BST->insert(30,'30g');
$BST->insert(29,'29h');
$BST->insert(42,'42j');
$BST->insert(132,'132q');
$BST->printNode();

$exist = $BST->contain(4);
var_dump($exist);

$find = $BST->search(3);
var_dump($find);

echo "前序\r\n";
$BST->preOrder();

echo "中序\r\n";
$BST->inOrder();

echo "后序\r\n";
$BST->postOrder();


//$nodeArr = array(2 => "222", 1 => "111", 0 => "000", 4 => "444", 3 => "333");
//调用初始化函数，创建二分搜索树
//$result = buildBinarySearchTree($nodeArr);
//打印生成的二分搜索树
//print_r($result);