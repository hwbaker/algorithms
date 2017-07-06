<?php

/**
 * Created by PhpStorm.
 * User: hewei
 * Date: 17/7/4
 * Time: 下午6:05
 *
 * cd /users/hewei/site/MyIterator/algorithms
 * /usr/local/bin/php MyIterator.php
 */

/**
 * @desc 迭代器工作流程
 * 执行顺序:
 * rewind->valid->current->key->***
 * next->valid->current->key->***
 * next->valid->current->key->***
 * 如果检查valid无效
 * next->valid
 *
 *
    Iterator::current — 返回当前元素
    Iterator::key — 返回当前元素的键
    Iterator::next — 向前移动到下一个元素
    Iterator::rewind — 返回到迭代器的第一个元素
    Iterator::valid — 检查当前位置是否有效
 */
class MyIterator implements Iterator
{
    private $var = array();

    public function __construct($array)
    {
        if (is_array($array)) {
            $this->var = $array;
        }
    }

    public function rewind() {
        echo "倒回第一个元素\n";
        reset($this->var);
    }

    public function current() {
        $var = current($this->var);
        echo "当前元素: $var\n";
        return $var;
    }

    public function key() {
        $var = key($this->var);
        echo "当前元素的键: $var\n";
        return $var;
    }

    public function next() {
        $var = next($this->var);
        echo "移向下一个元素: $var\n";
        return $var;
    }

    public function valid() {
        $var = $this->current() !== false;
        echo "检查有效性: {$var}\n";
        return $var;
    }
}

$values = array(1,2,3);
$it = new MyIterator($values);

foreach ($it as $k => $v) {
    print "此时键值对 -- key $k: value $v\n\n";
}
// 输出结果
/**
倒回第一个元素
当前元素: 1
检查有效性: 1
当前元素: 1
当前元素的键: 0
此时键值对 -- key 0: value 1

移向下一个元素: 2
当前元素: 2
检查有效性: 1
当前元素: 2
当前元素的键: 1
此时键值对 -- key 1: value 2

移向下一个元素: 3
当前元素: 3
检查有效性: 1
当前元素: 3
当前元素的键: 2
此时键值对 -- key 2: value 3

移向下一个元素:
当前元素:
检查有效性:
 */

/**
 * @desc PHP迭代器实现菲波那切数列
 * 关键是next
 * Class Fibonacci
 */
class Fibonacci implements Iterator {
    private $previous = 1;
    private $current = 0;
    private $key = 0;

    public function current() {
        return $this->current;
    }

    public function key() {
        return $this->key;
    }

    public function next() {
        // 关键在这里
        // 将当前值保存到  $newPrevious
        $newPrevious = $this->current;
        // 将上一个值与当前值的和赋给当前值
        $this->current += $this->previous;
        // 前一个当前值赋给上一个值
        $this->previous = $newPrevious;
        $this->key++;
    }

    public function rewind() {
        $this->previous = 1;
        $this->current = 0;
        $this->key = 0;
    }

    public function valid() {
        return true;
    }
}

$seq = new Fibonacci;
$i = 0;
foreach ($seq as $key => $f) {
    echo "$key=>$f ";
    if ($i++ === 3) {
        break;
    }
}
