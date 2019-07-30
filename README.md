# Jalaali PHP

PHP implementation of [jalaali.js](https://github.com/jalaali/jalaali-js) which contains functions for converting Jalaali and Gregorian calendar systems to each other.

Jalaali calendar system has different names such as:

- Jalaali
- Khayyami
- Khorshidi
- Persian
- Shamsi

The base algorithm is a derived work of [Omar Khayyam](https://en.wikipedia.org/wiki/Omar_Khayy%C3%A1m), who _completed_ the calendar system more than 900 years ago.

## About

Jalaali calendar is a solar calendar that was used in Persia, variants of which today are still in use in Iran as well as Afghanistan. [Read more](http://en.wikipedia.org/wiki/Jalali_calendar) or see [Calendar Converter](http://www.fourmilab.ch/documents/calendar/).

Calendar conversion is based on the algorithm provided by [Kazimierz M. Borkowski](http://www.astro.uni.torun.pl/~kb/Papers/EMP/PersianC-EMP.htm) and has a very good performance.

## Install

`composer require jalaali/jalaali-php`

## API

Base Jalaali class is defined with 10 static methods inside Jalaali namespace, so there's no need for instantiation. For example, to convert Gregorian date to Jalaali use this code:

```php
// PHP 3.0.x date to Jalaali :)
\Jalaali\Jalaali::toJalaali(2000, 10, 20)
```

There is a complete documentation page for this project on `docs/api` folder but the list of methods is as follows:

`toJalaali($gy, $gm, $gd)` : Converts a Gregorian date to Jalaali

`toGregorian($jy, $jm, $jd)` : Converts a Jalaali date to Gregorian

`isValidJalaaliDate($jy, $jm, $jd)` : Checks whether a Jalaali date is valid or not

`isLeapJalaaliYear($jy)` : Checks whether this is a leap year or not

`jalaaliMonthLength($jy, $jm)` : Number of days in a given month in Jalaali year

`jalaaliCalendar($jy)` : Base Algorithm

`j2d($jy, $jm, $jd)` : Converts a date of the Jalaali calendar to the Julian Day Number

`d2j($jdn)` : Converts the Julian Day Number to a date in the Jalaali calendar

`g2d($gy, $gm, $gd)` : Calculates the Julian Day number from Gregorian or Julian calendar dates

`d2g($jdn)` : Calculates Gregorian and Julian calendar dates from the Julian Day number
