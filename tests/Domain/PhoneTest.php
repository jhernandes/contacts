<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Jhernandes\Contacts\Domain\Phone;

class PhoneTest extends TestCase
{
    public function testCanBeCreatedFromValidString(): void
    {
        $this->assertInstanceOf(
            Phone::class,
            Phone::fromString('11990901010')
        );
    }

    public function testCanBeCreatedFromValidFormattedString(): void
    {
        $this->assertInstanceOf(
            Phone::class,
            Phone::fromString('(11) 99090-1010')
        );
    }

    public function testCannotBeCreatedFromInvalidString(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        Phone::fromString('90901010');
    }

    public function testCannotBeCreatedFromInvalidStringSecondCase(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        Phone::fromString('11909010100000000');
    }

    public function testCannotBeCreatedFromInvalidAreaCode(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new Phone('1', '997101030');
    }

    public function testCanBeUsedAsString(): void
    {
        $this->assertEquals(
            '11990901010',
            Phone::fromString('11990901010')
        );
    }

    public function testCanBeFormattedWith10Numbers(): void
    {
        $this->assertEquals(
            '(11) 3090-1010',
            Phone::fromString('1130901010')->formatted()
        );
    }

    public function testCanBeFormattedWith11Numbers(): void
    {
        $this->assertEquals(
            '(11) 99090-1010',
            Phone::fromString('11990901010')->formatted()
        );
    }
}
