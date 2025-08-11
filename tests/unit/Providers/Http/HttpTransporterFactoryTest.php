<?php

declare(strict_types=1);

namespace WordPress\AiClient\Tests\Providers\Http;

use PHPUnit\Framework\TestCase;
use WordPress\AiClient\Providers\Http\HttpTransporterFactory;
use WordPress\AiClient\Providers\Http\Contracts\HttpTransporterInterface;

/**
 * Tests for HttpTransporterFactory class.
 *
 * @since n.e.x.t
 *
 * @covers \WordPress\AiClient\Providers\Http\HttpTransporterFactory
 */
class HttpTransporterFactoryTest extends TestCase
{
    /**
     * Tests creating an HTTP transporter.
     *
     * @since n.e.x.t
     *
     * @covers ::createTransporter
     *
     * @return void
     */
    public function testCreateTransporter(): void
    {
        $transporter = HttpTransporterFactory::createTransporter();

        $this->assertInstanceOf(HttpTransporterInterface::class, $transporter);
    }
}
