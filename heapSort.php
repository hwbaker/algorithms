<?php
/**
 * Created by PhpStorm.
 * User: hewei
 * Date: 17/2/14
 * Time: 下午3:12
 *
 * cd /users/hewei/site/git/algorithms
 * /usr/local/bin/php heapSort.php
 */
/**
 * 假设n为当前数组的key则,n的父结点为 n>>1 或者 n/2(整除);n的左子结点l= n<<1 或 l=n*2,n的右子结点r=(n<<1)+1 或 r=l+1
 * ^ 互斥(xor)
 * << 向左移位
 * >> 向右移位
 */
//$arr = array(1,8,7,2,3,4,6,5,9,10);
//array_unshift($arr, 0);
//echo "i结点 \t FatherNode \t leftNode \t rightNode \r\n";
//foreach ($arr as $n => $item) {
//    $fNode = $n>>1; //父结点
//    $lNode = $n<<1; //左子结点
//    $rNode = ($n<<1) + 1; //右子结点
//    echo "{$n} \t {$fNode} \t {$lNode} \t {$rNode} \r\n";
//}

class heep
{
    /**
     * @desc 入队
     * @param array $arr
     * @param $one
     */
    static function add(array &$arr, $one)
    {
        $arr[] = $one;
        $n = count($arr);
        self::up($arr, $n - 1);
    }

    /**
     * @desc 出队,堆顶数据
     * @param array $arr
     */
    static function del(array &$arr)
    {
        $arr[0] = array_pop($arr);
        $n = count($arr);
        self::down($arr, 0, $n - 1);
    }

    // 增加元素 上浮
    static function up(array &$arr, $i)
    {
        $p = floor(($i - 1) / 2); // 右叶子结点坐标i,找寻i的父结点坐标
        while( $p >= 0 && $i > 0 && $arr[$p] > $arr[$i] ){
            self::swap($arr, $i, $p);
            $i = $p;
            $p = floor(($i - 1) / 2);
        }
    }

    // 下沉 $i开始 $n结束
    static function down(array &$arr, $k, $n)
    {
        $j = 2 * $k + 1;
        while ($j <= $n) {
            if ($j + 1 <= $n && $arr[$j + 1] < $arr[$j]) {
                $j ;
            }
            if ($arr[$j] > $arr[$k]) {
                break;
            }
            self::swap($arr, $k, $j);
            $k = $j;
            $j = 2 * $k + 1;
        }
    }

    //将堆进行排序
    static function sort(&$arr)
    {
        $n = count($arr);
        for ($i = $n - 1; $i >= 0; $i--) {
            self::swap($arr, 0, $i);
            self::down($arr, 0, $i - 1);
        }
    }

    // 将数组变成堆
    static function make(array &$arr)
    {
        $n = count($arr);
        for ($i = ($n - 1)/2 - 1; $i >= 0; $i--) {
            self::down($arr, $i, $n);
        }
    }
    // 交换数组元素
    static function swap(array &$arr, $l, $r)
    {
        $tmp = $arr[$l];
        $arr[$l] = $arr[$r];
        $arr[$r] = $tmp;
    }
}

$arr = array();
// 假设n为当前数组的key则,n的父结点为 n>>1 或者 n/2(整除);n的左子结点l= n<<1 或 l=n*2,n的右子结点r=(n<<1)+1 或 r=l+1
//$arr = array(1,8,7,2,3,4,6,5,9);
//$arr = [40,10,30];
heep::add($arr,40);
heep::add($arr,10);
heep::add($arr,30);
heep::add($arr,15);
heep::add($arr,8);
heep::add($arr,50);
heep::add($arr,20);
heep::add($arr,3);
//heep::del($arr);
//heep::del($arr);
//heep::del($arr);
echo implode(',', $arr) . "\r\n";
heep::sort($arr);
//heep::make($arr);
//heapSort($arr);
echo implode(',', $arr);


function heapSort(array &$arr)
{
    //求最后一个元素位
    $last = count($arr);
    //堆排序中通常忽略$arr[0]
    array_unshift($arr, 0);
    //最后一个非叶子结点
    $i = $last>>1;
    echo 'i:'.$i.';last:'.$last."\r\n";
    //整理成大顶堆,最大的数整到堆顶,并将最大数和堆尾交换,并在之后的计算中忽略数组后端的最大数(last),直到堆顶(last=堆顶)
    while (true) {
        echo 'while->i:'.$i.';last:'.$last."\r\n";
        adjustNode($i, $last, $arr);
        if ($i > 1) {
            //移动结点指针,遍历所有非叶子结点
            $i--;
        } else {
            //临界点last=1,既所有排序完成
            if ($last == 1 ) {
                break;
            }
            //当i为1时表示每一次的堆整理都将得到最大数(堆顶,$arr[1]),重复在根结点调整堆
            swap($arr, $last, 1);
            //在数组尾部按大小顺序保留最大数,定义临界点last,以免整理堆时重新打乱数组后面已排序好的元素
            $last--;
        }
    }
    //弹出第一个数组元素
    array_shift($arr);
}

/**
 * @desc  整理当前树结点($n),临界点$last之后为已排序好的元素
 * 堆排序就是把堆顶的最大数取出,
 * 将剩余的堆继续调整为最大堆,具体过程在第二块有介绍,以递归实现
 * 剩余部分调整为最大堆后,再次将堆顶的最大数取出,再将剩余部分调整为最大堆,这个过程持续到剩余数只有一个时结束
 * @param $n    树结点n<=>i
 * @param $last
 * @param $arr
 */
function adjustNode($n, $last, &$arr)
{
    echo 'adjustNodeStart...' . print_r($arr, true) . "\r\n";
    $l = $n<<1; //$n的左孩子位
    echo  'n:' . $n . ';l:' . $l ."\r\n";;
    if (!isset($arr[$l]) || $l > $last) {
        return ;
    }
    $r = $l + 1; //$n的右孩子位
    echo 'r:' . $r ."\r\n";
    //如果右孩子比左孩子大,则让父结点的右孩子比
    if ($r <= $last && $arr[$r] > $arr[$l]) {
        $l = $r;
    }
    echo 'l:'.$l.';r:'.$r."\r\n";
    //如果其中子结点$l比父结点$n大,则与父结点$n交换
    if ($arr[$l] > $arr[$n]){
        //子结点($l)的值与父结点($n)的值交换
        swap($arr, $l, $n);
        //交换后父结点($n)的值($arr[$n])可能还小于原子结点($l)的子结点的值,所以还需对原子结点($l)的子结点进行调整,用递归实现
        adjustNode($l, $last, $arr);
    }
}

function swap(array &$arr, $l, $r)
{
    $tmp = $arr[$l];
    $arr[$l] = $arr[$r];
    $arr[$r] = $tmp;
}