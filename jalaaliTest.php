<?php

require_once 'jalaali.php';

class JalaaliTest extends PHPUnit_Framework_Testcase
{
    public function testToJalaali()
    {
        $this->assertEquals(Jalaali::toJalaali(1989, 01, 28), array('jy' => 1367, 'jm' => 11, 'jd' => 08));
    }
    
    public function testToGregorian()
    {
        $this->assertEquals(Jalaali::toGregorian(1367, 11, 08), array('gy' => 1989, 'gm' => 01, 'gd' => 28));
    }
    
    public function testIsValidJalaaliDate()
    {
        $this->assertFalse(Jalaali::isValidJalaaliDate(-62, 12, 29));
        $this->assertFalse(Jalaali::isValidJalaaliDate(3178, 01, 01));
        $this->assertTrue(Jalaali::isValidJalaaliDate(-61, 01, 01));
        $this->assertTrue(Jalaali::isValidJalaaliDate(3177, 12, 29));
    }
    
    public function testIsLeapJalaaliYear()
    {
        $this->assertFalse(Jalaali::isLeapJalaaliYear(1393));
        $this->assertFalse(Jalaali::isLeapJalaaliYear(1394));
        $this->assertTrue(Jalaali::isLeapJalaaliYear(1395));
        $this->assertFalse(Jalaali::isLeapJalaaliYear(1396));
    }
    
    public function testJalaaliMonthLength()
    {
        $this->assertEquals(Jalaali::jalaaliMonthLength(1393, 01), 31);
        $this->assertEquals(Jalaali::jalaaliMonthLength(1393, 03), 31);
        $this->assertEquals(Jalaali::jalaaliMonthLength(1393, 06), 31);
        $this->assertEquals(Jalaali::jalaaliMonthLength(1393, 08), 30);
        $this->assertEquals(Jalaali::jalaaliMonthLength(1393, 10), 30);
        $this->assertEquals(Jalaali::jalaaliMonthLength(1393, 12), 29);
        $this->assertEquals(Jalaali::jalaaliMonthLength(1394, 12), 29);
        $this->assertEquals(Jalaali::jalaaliMonthLength(1395, 12), 30);
    }
}
