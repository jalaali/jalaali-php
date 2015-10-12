<?php
/**
 * Jalaali PHP Implementation based on [JalaaliJS](https://github.com/jalaali/jalaali-js).
 * 
 * @author Navid Emami <me@novid.name>
 * @license MIT
 * @license https://opensource.org/licenses/MIT
 * @version 0.1 Development Release
 */

/**
 * Converts a Gregorian date to Jalaali.
 * 
 * @param integer $gy Gregorian Year
 * @param integer $gm Gregorian Month
 * @param integer $gd Gregorian Day
 * 
 * @return array The converted Jalaali date
 */
function toJalaali($gy, $gm, $gd) {
  return d2j(g2d($gy, $gm, $gd));
}

/**
 * Converts a Jalaali date to Gregorian.
 * 
 * @param integer $jy Jalaali Year
 * @param integer $jm Jalaali Month
 * @param integer $jd Jalaali Day
 * 
 * @return array The converted Gregorian date
 */
function toGregorian($jy, $jm, $jd) {
  return d2g(j2d($jy, $jm, $jd));
}

/**
 * Checks whether a Jalaali date is valid or not.
 *
 * @param integer $jy Jalaali Year.
 * @param integer $jm Jalaali Month.
 * @param integer $jd Jalaali Day.
 * 
 * @return boolean is date valid?
 */
function isValidJalaaliDate($jy, $jm, $jd) {
  $yearIsValid = ($jy >= -61 && $jy <= 3177);
  $monthIsValid = ($jm >= 1 && $jm <= 12);
  $dayIsValid = ($jd >= 1 && $jd <= jalaaliMonthLength($jy, $jm));

  return $yearIsValid && $monthIsValid && $dayIsValid;
}

/**
 * Checks whether this is a leap year or not.
 * 
 * @param integer $jy Jalaali Year.
 * 
 * @return boolean is leap year?
 */
function isLeapJalaaliYear($jy) {
  $result = jalaaliCalendar($jy);
  return $result['leap'] == 0;
}

/**
 * Number of days in a given month in Jalaali year.
 * 
 * @param integer $jy Jalaali Year.
 * @param integer $jm Jalaali Month.
 * 
 * @return integer
 */
function jalaaliMonthLength($jy, $jm) {
  if ($jm <= 6) return 31;
  if ($jm <= 11) return 30;
  if (isLeapJalaaliYear($jy)) return 30;

  return 29;
}

/**
 * This function determines if the Jalaali (Persian) year is
 * leap (366-day long) or is the common year (365 days), and
 * finds the day in March (Gregorian calendar) of the first
 * day of the Jalaali year (jy).
 * 
 * @param integer $jy Jalaali Year (-61 to 3177).
 * 
 * @return array Containing leap, gy and march.
 * 
 * @see http://www.astro.uni.torun.pl/~kb/Papers/EMP/PersianC-EMP.htm
 * @see http://www.fourmilab.ch/documents/calendar
 */
function jalaaliCalendar($jy) {
  // jalaali years starting the 33 - year rule.
  $breaks = array(-61 ,9 ,38 ,199 ,426 ,686 ,756 ,818 ,1111 ,1181 ,1210 ,1635 ,2060 ,2097 ,2192 ,2262 ,2324 ,2394 ,2456 ,3178);
  $bl = count($breaks);
  $gy = $jy + 621;
  $leapJ = -14;
  $jp = $breaks[0];

  if ($jy < $jp || $jy >= $breaks[$bl - 1]) {
    throw new Exception('Invalid Jalaali Year: ' . $jy);
  }

  // find the limiting years for the jalaali year jy.
  for ($i = 1; $i < $bl; $i++) {
    $jm = $breaks[$i];
    $jump = $jm - $jp;
    if ($jy < $jm) {
      break;
    }
    $leapJ = $leapJ + div($jump, 33) * 8 + div(mod($jump, 33), 4);
    $jp = $jm;
  }
  $n = $jy - $jp;

  // find the number of leap years from AD 621 to the beginning of the current jalaali year in the persian calendar.
  $leapJ = $leapJ + div($n, 33) * 8 + div(mod($n, 33) + 3, 4);
  if (mod($jump, 33) == 4 && ($jump - $n) == 4) {
    $leapJ += 1;
  }

  // and the same in the gregorian calendar (until the year gy).
  $leapG = div($gy, 4) - div((div($gy, 100) + 1) * 3, 4) - 150;

  // determine the gregorian date of Farvardin the 1st.
  $march = 20 + $leapJ - $leapG;

  // find how many years have passed since the last leap year.
  if ($jump - $n < 6) {
    $n = $n - $jump + div($jump + 4, 33) * 33;
  }
  $leap = mod(mod($n + 1, 33) - 1, 4);
  if ($leap == -1) {
    $leap = 4;
  }

  $result = array('leap' => $leap, 'gy' => $gy, 'march' => $march);
  return $result;
}

/**
 * Converts a date of the Jalaali calendar to the Julian Day Number.
 * 
 * @param integer $jy Jalaali Year (1 to 3100)
 * @param integer $jm Jalaali Month (1 to 12)
 * @param integer $jd Jalaali Day (1 to 29/31)
 * 
 * @return $jdn Julian Day Number
 */
function j2d($jy, $jm, $jd) {
  $result = jalaaliCalendar($jy);
  return g2d($result['gy'], 3, $result['march']) + ($jm - 1) * 31 - div($jm, 7) * ($jm - 7) + $jd - 1;
}

/**
 * Converts the Julian Day Number to a date in the Jalaali calendar.
 * 
 * @param integer $jdn Julian Day Number
 * 
 * @return array Containing $jy, $jm and $jd
 */
function d2j($jdn) {
  // calculate gregorian year
  $result = d2g($jdn);
  $gy = $result['gy'];
  $jy = $gy - 621;
  $result = jalaaliCalendar($jy);
  $jdn1f = g2d($gy, 3, $result['march']);

  // find number of days that passed since 1 farvardin.
  $k = $jdn - $jdn1f;
  if ($k >= 0) {
    if ($k <= 185) {
      // The first 6 months.
      $jm = div($k, 31) + 1;
      $jd = mod($k, 31) + 1;
      $date = array('jy' => $jy, 'jm' => $jm, 'jd' => $jd);
      return $date;
    } else {
      // The remaining months.
      $k -= 186;
    }
  } else {
    // previous jalaali year.
    $jy -= 1;
    $k += 179;
    if ($result['leap'] == 1) $k += 1;
  }
  $jm = div($k, 30) + 7;
  $jd = mod($k, 30) + 1;
  $date = array('jy' => $jy, 'jm' => $jm, 'jd' => $jd);

  return $date;
}

/**
 * Calculates the Julian Day number from Gregorian or Julian
 * calendar dates. This integer number corresponds to the noon of
 * the date (i.e. 12 hours of Universal Time).
 * The procedure was tested to be good since 1 March, -100100 (of both
 * calendars) up to a few million years into the future.
 * 
 * @param integer $gy Gregorian Year
 * @param integer $gm Gregorian Month (1 to 12)
 * @param integer $gd Gregorian Day (1 to 28/29/30/31)
 * 
 * @return $jdn Julian Day Number
 */
function g2d($gy, $gm, $gd) {
  $jdn = div(($gy + div($gm - 8, 6) + 100100) * 1461, 4) + div(153 * mod($gm + 9, 12) + 2, 5) + $gd - 34840408;
  $jdn = $jdn - div(div($gy + 100100 + div($gm - 8, 6), 100) * 3, 4) + 752;

  return $jdn;
}

/**
 * Calculates Gregorian and Julian calendar dates from the Julian Day number
 * (jdn) for the period since jdn=-34839655 (i.e. the year -100100 of both
 * calendars) to some millions years ahead of the present.
 * 
 * @param integer $jdn Julian Day Number
 * 
 * @return array Containing $gy, $gm and $gd
 */
function d2g($jdn) {
  $j = 4 * $jdn + 139361631 + div(div(4 * $jdn + 183187720, 146097) * 3, 4) * 4 - 3908;
  $i = div(mod($j, 1461), 4) * 5 + 308;
  $gd = div(mod($i, 153), 5) + 1;
  $gm = mod(div($i, 153), 12) + 1;
  $gy = div($j, 1461) - 100100 + div(8 - $gm, 6);
  $date = array('gy' => $gy, 'gm' => $gm, 'gd' => $gd);

  return $date;
}

/**
 * helper function for division.
 * 
 * @param integer $first First Parameter
 * @param integer $second Second Parameter
 * 
 * @return integer division result
 */
function div($first, $second) {
  return ~~($first / $second);
}

/**
 * helper function for modulo.
 * 
 * @param integer $first First Parameter
 * @param integer $second Second Parameter
 * 
 * @return integer modulo result
 */
function mod($first, $second) {
  return $first - ~~($first / $second) * $second;
}
