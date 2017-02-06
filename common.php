<?php

/**
 * Created by PhpStorm.
 * User: hewei
 * Date: 17/2/6
 * Time: 上午10:56
 * 公共方法调用类
 */
class common
{
    /**
     * @desc 随机生成算法测试用例,生成n个元素的随机数,每个元素的随机范围是[rangeL,rangeR]
     * @param $n
     * @param $rangeL
     * @param $rangeR
     * @return array
     */
    public function generateRandomArray($n = 100, $rangeL = 1, $rangeR = 100)
    {
        $count = 0;
        $result = array();
        while ($count < $n) {
            $result[] = mt_rand($rangeL, $rangeR);
            $result = array_flip(array_flip($result));
            $count = count($result);
        }
        shuffle($result);
        return $result;
    }

    /**
     * @desc 获取毫秒级时间戳
     * @return float
     */
    function getMillisecond() {
        list($microSeconds, $seconds) = explode(' ', microtime());//微秒 秒
        return (float)(floatval($microSeconds)+floatval($seconds))*1000;
    }

    /**
     * @desc  时间差
     * @param $timeSta
     * @param $timeEnd
     */
    function timeDiff($timeSta = '', $timeEnd = '')
    {
        $timeSta = $timeSta ? $timeSta : self::getMillisecond();
        $timeEnd = $timeEnd ? $timeEnd : self::getMillisecond();
        echo $timeEnd - $timeSta . "MicSec...\r\n";
    }
}