<?php

namespace App\Tests\Utils;

use App\Utils\TokenGenerator;
use PHPUnit\Framework\TestCase;

class TokenGeneratorTest extends TestCase
{
    public function testAlphaNumGeneration()
    {
        $generator = new TokenGenerator();
        $tokenAlpha = $generator->getAlpha(50);
        $tokenAlphaNum = $generator->getAlphaNum(75);

        $this->assertEquals(50, strlen($tokenAlpha));
        $this->assertEquals(75, strlen($tokenAlphaNum));
    }
}
