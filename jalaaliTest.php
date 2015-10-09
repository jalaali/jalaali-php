<?php

require_once 'jalaali.php';

class JalaaliTest extends PHPUnit_Framework_Testcase
{
    public function testToJalaali()
    {
        $this->assertEquals(toJalaali(1989, 01, 28), array('jy' => 1367, 'jm' => 11, 'jd' => 08));
    }
    
    public function testToGregorian()
    {
        $this->assertEquals(toGregorian(1367, 11, 08), array('gy' => 1989, 'gm' => 01, 'gd' => 28));
    }
    
    public function testIsValidJalaaliDate()
    {
        $this->assertFalse(isValidJalaaliDate(-62, 12, 29));
        $this->assertFalse(isValidJalaaliDate(3178, 01, 01));
        $this->assertTrue(isValidJalaaliDate(-61, 01, 01));
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
        $this->assertEquals(jalaaliMonthLength(1393, 01), 31);
        $this->assertEquals(jalaaliMonthLength(1393, 03), 31);
        $this->assertEquals(jalaaliMonthLength(1393, 06), 31);
        $this->assertEquals(jalaaliMonthLength(1393, 08), 30);
        $this->assertEquals(jalaaliMonthLength(1393, 10), 30);
        $this->assertEquals(jalaaliMonthLength(1393, 12), 29);
        $this->assertEquals(jalaaliMonthLength(1394, 12), 29);
        $this->assertEquals(jalaaliMonthLength(1395, 12), 30);
    }
}
