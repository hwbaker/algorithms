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
    public $parent = null; // 父节点
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
     * @desc 前序遍历(深度遍历)
     */
    public function preOrder()
    {
        $this->preOrderPrivate($this->root);
    }

    /**
     * @desc 中序遍历(深度遍历)
     */
    public function inOrder()
    {
        $this->inOrderPrivate($this->root);
    }

    /**
     * @desc 后序遍历(深度遍历)
     */
    public function postOrder()
    {
        $this->postOrderPrivate($this->root);
    }

    /**
     * @desc 层序遍历(广度遍历)
     */
    public function levelOrder()
    {
        $queue[] = $this->root;
        $count = count($queue);
        while ($count >= 1) {
            $node = array_shift($queue); //队列，将数组开头的单元移出数组
            echo $node->key . '  ';

            if ($node->left) {
                $queue[] = $node->left;
            }
            if ($node->right) {
                $queue[] = $node->right;
            }
            $count = count($queue);
        }
    }

    /**
     * @desc 层序遍历-递归
     */
    public function levelOrderRecursive()
    {
        $arr = array();
        $this->levelOrderRecursivePrivate($this->root, $arr);
    }

    /**
     * @desc 寻找最小的键值,返回最小键值的二分搜索树
     * 可用非递归方式,todo...
     */
    public function minMum()
    {
        $minNode = $this->minMumPrivate($this->root);
        return $minNode;
    }

    /**
     * @desc  寻找最大的键值,返回最大键值的二分搜索树
     * 可用非递归方式,todo...
     * @return mixed
     */
    public function maxMum()
    {
        $maxNode = $this->maxMumPrivate($this->root);
        return $maxNode;
    }

    /**
     * @desc 从二分树中删除最小值所在节点
     */
    public function removeMin()
    {
        if ($this->root) {
            $this->root = $this->removeMinPrivate($this->root);
        }
    }

    /**
     * @desc 从二分树中删除最大值所在节点
     */
    public function removeMax()
    {
        if ($this->root) {
            $this->root = $this->removeMaxPrivate($this->root);
        }
    }

    /**
     * @desc 删除二分搜索树任意节点||右子树中最小key
     */
    public function remove($key)
    {
        $this->root = $this->removePrivate($this->root, $key);
    }

    /**
     * @desc 删除二分搜索树任意节点||左子树中最大key
     */
    public function removeSecond($key)
    {
        $this->root = $this->removeSecondPrivate($this->root, $key);
    }

    /**
     * @desc 向以node为根的二分搜索树中,插入节点(key, val)
     * 返回插入新节点后的二分搜索树的根
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
     * @desc  在以node为根的二分搜索树中查找key所对应的value
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
     * @desc 对以node为节点的二分搜索树进行前序遍历
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
     * @desc 对以node为节点的二分搜索树进行中序遍历
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
     * @desc 对以node为节点的二分搜索树进行后序遍历
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

    /**
     * @desc 在以node为根的二分搜索树中，返回最小键值的节点
     * @param $node
     * @return mixed
     */
    private function minMumPrivate($node)
    {
        if ($node->left == null) {
            return $node;
        }

        return $this->minMumPrivate($node->left);
    }

    /**
     * @desc 在以node为根的二分树中，返回最大键值的节点
     * @param $node
     * @return mixed
     */
    private function maxMumPrivate($node)
    {
        if ($node->right == null) {
            return $node;
        }

        return $this->maxMumPrivate($node->right);
    }

    /**
     * @desc 删除掉以node为根的二分搜索树的最小节点
     * 返回删除节点后新的二分搜索树的根
     * @param $node
     * @return mixed
     */
    private function removeMinPrivate($node)
    {
        if ($node->left == null) {
            $rightNode = $node->right;
//            unset($node);
            return $rightNode;
        }

        $node->left = $this->removeMinPrivate($node->left);
        return $node;
    }

    /**
     * @desc 删除掉以node为根的二分搜索树的最大节点
     * 返回删除节点后新的二分搜索树的根
     * @param $node
     * @return mixed
     */
    private function removeMaxPrivate($node)
    {
        if ($node->right == null) {
            $leftNode = $node->left;
//            unset($node);
            return $leftNode;
        }
        $node->right = $this->removeMaxPrivate($node->right);
        return $node;
    }

    /**
     * @desc 首先访问根节点,然后将根节点的两个子节点存放到queue()中,然后每次从queue()中取出一个没有遍历的节点,输出该节点的值,
     * 并将该节点的左右两个节点存储到queue()中.依次类推,直到取到到所有节点的都没有左右子节点为止
     * @param $node
     * @param $queue
     * @return bool
     */
    private function levelOrderRecursivePrivate($node, &$queue)
    {
        if ($node){
            echo $node->key . '  ';
        } else {
            return false;
        }

        if ($node->left) {
            $queue[] = $node->left;
        }
        if ($node->right) {
            $queue[] = $node->right;
        }

        $count = count($queue);
        if ($count >= 1) {
            $shiftNode = array_shift($queue);
            $this->levelOrderRecursivePrivate($shiftNode, $queue);
        }
    }

    /**
     * @desc 删除以node为节点二分搜索树的key节点,后继节点
     * @param $node
     * @param $key
     * @return bool
     */
    private function removePrivate($node, $key)
    {
        if ($node == null) {
            return false;
        }

        if ($key < $node->key) {
            $node->left = $this->removePrivate($node->left, $key);
            return $node;
        } elseif($key > $node->key) {
            $node->right = $this->removePrivate($node->right, $key);
            return $node;
        } else { // key == $node->key
            // 只有左子树
            if ($node->right == null) {
                $leftNode = $node->left;
                return $leftNode;
            }
            // 只有右子数
            if ($node->left == null) {
                $rightNode = $node->right;
                return $rightNode;
            }

            // 左右子树都有
            // 找node右子树的最小节点,作为后继节点
            $successor = $this->minMumPrivate($node->right);
            $successor->left = $node->left;
            // 删除node节点右子树的最小值 && 赋值给候机节点$successor的右子树
            $successor->right = $this->removeMinPrivate($node->right);
            return $successor;
        }
    }

    /**
     * @desc 删除以node为节点二分搜索树的key节点,前驱节点
     * @param $node
     * @param $key
     * @return bool|mixed
     */
    private function removeSecondPrivate($node, $key)
    {
        if ($node == null) {
            return false;
        }

        if ($key < $node->key) {
            $node->left = $this->removeSecondPrivate($node->left, $key);
            return $node;
        } elseif ($key > $node->key) {
            $node->right = $this->removeSecondPrivate($node->right, $key);
            return $node;
        } else {
            if ($node->right == null) {
               $leftNode = $node->left;
               return $leftNode;
            }
            if ($node->left == null) {
                $rightNode = $node->right;
                return $rightNode;
            }

            // 左右子树都有
            // 寻找node左子树的最大节点,作为前驱节点
            $precursor = $this->maxMumPrivate($node->left);
            $precursor->left = $this->removeMaxPrivate($node->left);
            $precursor->right = $node->right;
            return $precursor;
        }
    }

}

/**
 * @desc  二分查找树-父节点实现 todo...
 * @param $root
 * @param $iNode
 */
function insert($root, $iNode)
{
    $cNode = $root;
    $pNode = null;
    while ($cNode !== null) { #为iNode找到合适的插入位置
        $pNode = $cNode;
        if ($cNode->key > $iNode->key) {
            $cNode = $cNode->left;
        } else {
            $cNode = $cNode->right;
        }
    }

    $iNode->parent = $pNode->key;
    print_r($pNode);
    if ($pNode === null) { #pNode == null,说明是空树
        $root = $iNode;
    } else {
        if ($pNode->key > $iNode->key) {
            $pNode->left = $iNode;
      } else {
            $pNode->right = $iNode;
      }
    }
}
function build_iterative_tree($arr)
{
    $root = new Node();
    $root->key = $arr[0];
    $root->value = $arr[0];
     for ($i = 1; $i < count($arr); $i++) {
         $newNode = new Node();
         $newNode->key = $arr[$i];
         $newNode->value = $arr[$i];
         insert($root, $newNode);
     }
     return $root;
}
$r = build_iterative_tree(array(1,2,3));
print_r($r);
exit;

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

echo "层序\r\n";
//$BST->levelOrder();
$BST->levelOrderRecursive();

echo "\r\n最小键值\r\n";
var_dump($BST->minMum());

echo "最大键值\r\n";
var_dump($BST->maxMum());

//echo "删除最小节点";
//$BST->removeMin();
//$BST->printNode();

//echo "删除最大节点";
//$BST->removeMax();
//$BST->printNode();

echo "删除任意节点,后继做补充";
//$BST->remove(28);
//$BST->printNode();

echo "删除任意节点,前驱做补充";
$BST->removeSecond(28);
$BST->printNode();

//$nodeArr = array(2 => "222", 1 => "111", 0 => "000", 4 => "444", 3 => "333");
//调用初始化函数，创建二分搜索树
//$result = buildBinarySearchTree($nodeArr);
//打印生成的二分搜索树
//print_r($result);