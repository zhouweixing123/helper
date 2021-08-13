<?php

namespace Zwx\Helper\Tests;

use PHPUnit\Framework\TestCase;
use Zwx\Helper\Helper;

class HelperTest extends TestCase
{
    public function testFilterCheckIp()
    {
        $this->assertTrue(Helper::FilterCheckIp('47.105.126.28'));
    }

    public function testFilterCheckIpv4()
    {
        $this->assertTrue(Helper::FilterCheckIpv4('47.105.126.28'));
    }
}
