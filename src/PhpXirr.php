<?php
/**
 * 计算XIRR类.
 *
 * @author Guo Feng
 */

namespace phpXirr;

class PhpXirr
{
    private static $Max_Rate = 99999.9; //最大收益率
    private static $Min_Rate = -0.99999999; //最小收益率（赔光了）
    private static $Critical = 0.00000001; //精确值

    public static $Error_Null_List = -501; //代表传进来的list为空
    public static $Error_Less_Cash = -502; //少于一条现金流
    public static $Error_Date = -503; //传进来的现金流的第一条现金流记录的时间不是最早的时间
    public static $Error_First_Payment = -504; //第一条现金流的payment的值不为负

    /**
     * 第一条现金流具体某个时间点的差值天数，这个天数应该是所有现金流里面的差值天数最大的.
     */
    private static $startDay = 0;
    private $listUpbaa;

    public function getDaysFrom1970($date)
    {
        return intval(strtotime($date) / 86400);
    }

    public function XirrData($listUpbaa)
    {
        $this->listUpbaa = $listUpbaa;
        if (!empty($listUpbaa)) {
            try {
                $this->startDay = $this->getDaysFrom1970($listUpbaa[0]['date']);
            } catch (Exception $e) {
            }
        }
    }

    /**
     * 计算收益值
     *
     * @return float
     */
    public function getPal()
    {
        if (empty($this->listUpbaa)) {
            return 0.0;
        }

        return array_sum(array_column($this->listUpbaa, 'payment'));
    }

    /**
     * 通过传进来的多条现金流获得xirr值
     *
     * @return 返回收益率
     */
    public function getXirr()
    {
        if (empty($this->listUpbaa)) {
            return $this->Error_Null_List;
        }
        if (count($this->listUpbaa) <= 1) {
            return $this->Error_Less_Cash; // 如果只有一条现金流则返回Error_Less_Cash
        }

        if ($this->listUpbaa[0]['payment'] > 0) {
            return $this->Error_First_Payment;
        }

        for ($i = 0; $i < count($this->listUpbaa); ++$i) {
            if ($this->getDaysFrom1970($this->listUpbaa[$i]['date']) < $this->startDay) {
                return $this->Error_Date;
                // 如果不止一条现金流则判断第一条现金流是否为时间最早的，如果不是的话则返回ERROR_DATE
            }
        }
        $isEarn = $this->getXNPVByRate(0) > 0;
        // 记录是赚钱了还是亏本了
        $XIRR = 0;
        $tempMax = 0;
        $tempMin = 0;
        $calculateCount = 50;
        //var_dump(self::$Max_Rate);
        if ($isEarn) {
            $tempMax = self::$Max_Rate;
            $tempMin = 0;
            while ($calculateCount > 0) {
                $XIRR = ($tempMin + $tempMax) / 2;
                $xnvp = $this->getXNPVByRate($XIRR);
                if ($xnvp > 0) {
                    $tempMin = $XIRR;
                } else {
                    $tempMax = $XIRR;
                }
                //echo "[ $tempMax ,$XIRR, $tempMin  ]\n";
                if (abs($XIRR) < self::$Critical) {
                    break;
                }
                --$calculateCount;
            }
        } else {
            $tempMax = 0;
            $tempMin = self::$Min_Rate;
            while ($calculateCount > 0) {
                $XIRR = ($tempMin + $tempMax) / 2;
                $xnvp = $this->getXNPVByRate($XIRR);
                if ($xnvp > 0) {
                    $tempMin = $XIRR;
                } else {
                    $tempMax = $XIRR;
                }

                //echo "[ $tempMax ,$XIRR, $tempMin  ]\n";
                if (abs($XIRR) < self::$Critical) {
                    break;
                }
                --$calculateCount;
            }
        }

        return $XIRR;
    }

    private function getXNPVByRate($rate)
    {
        $result = 0;
        $size = count($this->listUpbaa);
        for ($i = 0; $i < $size; ++$i) {
            $result = $result
                    + $this->getOneValue($this->listUpbaa[$i]['payment'], $rate, $this->getDaysFrom1970($this->listUpbaa[$i]['date'])
                            - $this->startDay);
        }

        return $result;
    }

    private function getOneValue($payment, $rate, $dateDistance)
    {
        return $payment / ((pow((1 + $rate), $dateDistance / 365)));
    }
}
