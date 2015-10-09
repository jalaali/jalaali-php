<?php

require 'jalaali.php';

echo 'Convert 2015/10/09 To Jalaali: ';
echo '<pre>';print_r(toJalaali(2015, 10, 09));echo '</pre>';
echo '<br>';

echo 'Convert 1394/07/17 To Gregorian: ';
echo '<pre>';print_r(toGregorian(1394, 07, 17));echo '</pre>';
echo '<br>';

echo 'Jalaali Calendar : ';
echo '<pre>';print_r(jalaaliCalendar(1394));echo '</pre>';
echo '<br>';

echo 'Is Valid? : ';
echo isValidJalaaliDate(1394, 07, 17) ? 'Yes' : 'No';
echo '<br>';

echo 'Is Leap? : ';
echo isLeapJalaaliYear(1394) ? 'Yes' : 'No';
echo '<br>';

echo 'Month Length : ';
echo jalaaliMonthLength(1394, 07);
echo '<br>';
