<?php
/**
 * Jalaali PHP Unit Tests based on [JalaaliJS](https://github.com/jalaali/jalaali-js).
 * 
 * @author Navid Emami <me@novid.name>
 * @license MIT
 * @license https://opensource.org/licenses/MIT
 * @version 1.0.0 Initial Release
 */

require_once 'jalaali.php';

class JalaaliTest extends PHPUnit_Framework_Testcase
{
    public function testToJalaali()
    {
        $this->assertEquals(array('jy' => 1367, 'jm' => 11, 'jd' => 8), \Jalaali\Jalaali::toJalaali(1989, 1, 28));
        $this->assertEquals(array('jy' => 1394, 'jm' => 7, 'jd' => 18), \Jalaali\Jalaali::toJalaali(2015, 10, 10));
    }
    
    public function testToGregorian()
    {
        $this->assertEquals(array('gy' => 1989, 'gm' => 1, 'gd' => 28), \Jalaali\Jalaali::toGregorian(1367, 11, 8));
        $this->assertEquals(array('gy' => 2015, 'gm' => 10, 'gd' => 10), \Jalaali\Jalaali::toGregorian(1394, 7, 18));
    }
    
    public function testIsValidJalaaliDate()
    {
        $this->assertFalse(\Jalaali\Jalaali::isValidJalaaliDate(-62, 12, 29));
        $this->assertFalse(\Jalaali\Jalaali::isValidJalaaliDate(3178, 1, 1));
        $this->assertTrue(\Jalaali\Jalaali::isValidJalaaliDate(-61, 1, 1));
        $this->assertTrue(\Jalaali\Jalaali::isValidJalaaliDate(3177, 12, 29));
    }
    
    public function testIsLeapJalaaliYear()
    {
        $this->assertFalse(\Jalaali\Jalaali::isLeapJalaaliYear(1393));
        $this->assertFalse(\Jalaali\Jalaali::isLeapJalaaliYear(1394));
        $this->assertTrue(\Jalaali\Jalaali::isLeapJalaaliYear(1395));
        $this->assertFalse(\Jalaali\Jalaali::isLeapJalaaliYear(1396));
    }
    
    public function testJalaaliMonthLength()
    {
        $this->assertEquals(31, \Jalaali\Jalaali::jalaaliMonthLength(1393, 1));
        $this->assertEquals(31, \Jalaali\Jalaali::jalaaliMonthLength(1393, 3));
        $this->assertEquals(31, \Jalaali\Jalaali::jalaaliMonthLength(1393, 6));
        $this->assertEquals(30, \Jalaali\Jalaali::jalaaliMonthLength(1393, 8));
        $this->assertEquals(30, \Jalaali\Jalaali::jalaaliMonthLength(1393, 10));
        $this->assertEquals(29, \Jalaali\Jalaali::jalaaliMonthLength(1393, 12));
        $this->assertEquals(29, \Jalaali\Jalaali::jalaaliMonthLength(1394, 12));
        $this->assertEquals(30, \Jalaali\Jalaali::jalaaliMonthLength(1395, 12));
    }
}
