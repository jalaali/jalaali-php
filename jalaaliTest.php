<?php
/**
 * Jalaali PHP Unit Tests based on [JalaaliJS](https://github.com/jalaali/jalaali-js).
 * 
 * @author Navid Emami <me@novid.name>
 * @license MIT
 * @license https://opensource.org/licenses/MIT
 * @version 0.1 Development Release
 */

require_once 'jalaali.php';

class JalaaliTest extends PHPUnit_Framework_Testcase
{
    public function testToJalaali()
    {
        $this->assertEquals(array('jy' => 1367, 'jm' => 11, 'jd' => 8), toJalaali(1989, 1, 28));
        $this->assertEquals(array('jy' => 1394, 'jm' => 7, 'jd' => 18), toJalaali(2015, 10, 10));
    }
    
    public function testToGregorian()
    {
        $this->assertEquals(array('gy' => 1989, 'gm' => 1, 'gd' => 28), toGregorian(1367, 11, 8));
        $this->assertEquals(array('gy' => 2015, 'gm' => 10, 'gd' => 10), toGregorian(1394, 7, 18));
    }
    
    public function testIsValidJalaaliDate()
    {
        $this->assertFalse(isValidJalaaliDate(-62, 12, 29));
        $this->assertFalse(isValidJalaaliDate(3178, 1, 1));
        $this->assertTrue(isValidJalaaliDate(-61, 1, 1));
        $this->assertTrue(isValidJalaaliDate(3177, 12, 29));
    }
    
    public function testIsLeapJalaaliYear()
    {
        $this->assertFalse(isLeapJalaaliYear(1393));
        $this->assertFalse(isLeapJalaaliYear(1394));
        $this->assertTrue(isLeapJalaaliYear(1395));
        $this->assertFalse(isLeapJalaaliYear(1396));
    }
    
    public function testJalaaliMonthLength()
    {
        $this->assertEquals(31, jalaaliMonthLength(1393, 1));
        $this->assertEquals(31, jalaaliMonthLength(1393, 3));
        $this->assertEquals(31, jalaaliMonthLength(1393, 6));
        $this->assertEquals(30, jalaaliMonthLength(1393, 8));
        $this->assertEquals(30, jalaaliMonthLength(1393, 10));
        $this->assertEquals(29, jalaaliMonthLength(1393, 12));
        $this->assertEquals(29, jalaaliMonthLength(1394, 12));
        $this->assertEquals(30, jalaaliMonthLength(1395, 12));
    }
}
