<?php

declare(strict_types=1);

namespace CurrencyExchangeTest\Uri;

use CurrencyExchange\Http\Request;
use InvalidArgumentException;
use CurrencyExchange\Uri\AbstractUri;

class AbstractUriTest extends \PHPUnit\Framework\TestCase
{
    public function testSetTypeThrowsInvalidArgumentExceptionWhenPassingUnknownMethod(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->getMockForAbstractClass(AbstractUri::class, ['unknown-method']);
    }

    public function testSetTypeSetHttpMethodUppercased(): void
    {
        $stub1 = $this->getMockForAbstractClass(AbstractUri::class, [Request::HTTP_GET]);
        $stub2 = $this->getMockForAbstractClass(AbstractUri::class, [Request::HTTP_POST]);
        
        $this->assertMatchesRegularExpression('/[A-Z]/', $stub1->getType());
        $this->assertMatchesRegularExpression('/[A-Z]/', $stub2->getType());
    }
}