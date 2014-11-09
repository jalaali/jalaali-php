<?php

class Jalaali
{
    
    public static function toJalaali($gy, $gm, $gd)
    {
        return Jalaali::d2j(Jalaali::g2d($gy, $gm, $gd));
    }
    
    public static function toGregorian($jy, $jm, $jd)
    {
        return Jalaali::d2g(Jalaali::j2d($jy, $jm, $jd));
    }
    
    public static function isValidJalaaliDate($jy, $jm, $jd)
    {
        $yearIsValid = ($jy >= -61 && $jy <= 3177);
        $monthIsValid = ($jm >= 1 && $jm <= 12);
        $dayIsValid = ($jd >= 1 && $jd <= Jalaali::jalaaliMonthLength($jy, $jm));
        
        return $yearIsValid && $monthIsValid && $dayIsValid;
    }
    
    public static function isLeapJalaaliYear($jy)
    {
        return Jalaali::jalaaliCalendar($jy)['leap'] === 0;
    }

    public static function jalaaliMonthLength($jy, $jm)
    {
        if ($jm <= 6) return 31;
        if ($jm <= 11) return 30;
        if (Jalaali::isLeapJalaaliYear($jy)) return 30;
        
        return 29;
    }
    
    public static function jalaaliCalendar($jy)
    {
        // Jalaali years starting the 33-year rule.
        $breaks = array(-61 ,9 ,38 ,199 ,426 ,686 ,756 ,818 ,1111 ,1181 ,1210 ,1635 ,2060 ,2097 ,2192 ,2262 ,2324 ,2394 ,2456 ,3178);
        $bl = count($breaks);
        $gy = $jy + 621;
        $leapJ = -14;
        $jp = $breaks[0];

        if ($jy < $jp || $jy >= $breaks[$bl - 1]) {
            throw new Exception('Invalid Jalaali year: ' + $jy);
        }

        // Find the limiting years for the Jalaali year jy.
        for ($i = 1; $i < $bl; $i += 1) {
            $jm = $breaks[$i];
            $jump = $jm - $jp;
            if ($jy < $jm) break;
            $leapJ = $leapJ + ($jump / 33) * 8 + (($jump % 33) / 4);
            $jp = $jm;
        }
        $n = $jy - $jp;

        // Find the number of leap years from AD 621 to the beginning
        // of the current Jalaali year in the Persian calendar.
        $leapJ = $leapJ + ($n / 33) * 8 + ((($n % 33) + 3) / 4);
        if (($jump % 33) === 4 && $jump - $n === 4) $leapJ += 1;

        // And the same in the Gregorian calendar (until the year gy).
        $leapG = ($gy / 4) - (((($gy / 100) + 1) * 3) / 4) - 150;

        // Determine the Gregorian date of Farvardin the 1st.
        $march = 20 + $leapJ - $leapG;

        // Find how many years have passed since the last leap year.
        if ($jump - $n < 6) {
            $n = $n - $jump + (($jump + 4) / 33) * 33;
        }
        $leap = ((($n + 1 % 33) - 1) % 4);
        if ($leap === -1) {
            $leap = 4;
        }

        $result = array('leap' => $leap, 'gy' => $gy, 'march' => $march);
        return  $result;
    }
    
    public static function j2d($jy, $jm, $jd)
    {
        $result = Jalaali::jalaaliCalendar($jy);
        return Jalaali::g2d($result['gy'], 3, $result['march']) + ($jm - 1) * 31 - ($jm / 7) * ($jm - 7) + $jd - 1;
    }
    
    public static function d2j($jdn)
    {
        // Calculate Gregorian year
        $result = Jalaali::d2g($jdn);
        $gy = $result['gy'];
        $jy = $gy - 621;
        $result = Jalaali::jalaaliCalendar($jy);
        $jdn1f = Jalaali::g2d($gy, 3, $result['march']);

        // Find number of days that passed since 1 Farvardin.
        $k = $jdn - $jdn1f;
        if ($k >= 0) {
            if ($k <= 185) {
                // The first 6 months.
                $jm = 1 + ($k / 31);
                $jd = ($k % 31) + 1;
                $date = array($jy, $jm, $jd);
                return $date;
            } else {
                // The remaining months.
                $k -= 186;
            }
        } else {
            // Previous Jalaali year.
            $jy -= 1;
            $k += 179;
            if ($result['leap'] === 1) $k += 1;
        }
        $jm = 7 + ($k / 30);
        $jd = ($k % 30) + 1;
        $date = array('jy' => $jy, 'jm' => $jm, 'jd' => $jd);
        
        return $date;
    }
    
    public static function g2d($gy, $gm, $gd)
    {
        $jdn = ((($gy + (($gm - 8) / 6) + 100100) * 1461) / 4) + ((153 * (($gm + 9) % 12) + 2) / 5) + $gd - 34840408;
        $jdn = $jdn - ((($gy + 100100 + (($gm - 8) / 6) / 100) * 3) / 4) + 752;
        
        return $jdn;
    }
    
    public static function d2g($jdn)
    {
        $j = 4 * $jdn + 139361631;
        $j = $j + ((((4 * $jdn + 183187720) / 146097) * 3) / 4) * 4 - 3908;
        $i = (($j % 1461) / 4) * 5 + 308;
        $gd = (($i % 153) / 5) + 1;
        $gm = (($i / 153) % 12) + 1;
        $gy = ($j / 1461) - 100100 + ((8 - $gm) / 6);
        $date = array('gy' => $gy, 'gm' => $gm, 'gd' => $gd);
        
        return $date;
    }

}
