<?php

/**
 * @category  Eclipse
 * @package  Eclipse_AiCore
 * @subpackage   Test
 * @author  Szymon Łukaszewicz <szymon.lukaszewicz@eclipsegroup.co.uk>
 * @copyright 2023 Eclipse
 * @since     1.0.0
 */

declare(strict_types=1);


namespace Eclipse\AiCore\Test\Unit\Model\Config\Source;

use Eclipse\AiCore\Api\Client\ConnectionInterface;
use Eclipse\AiCore\Model\Config\Source\Engine;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\CacheInterface;
use Magento\Framework\Serialize\SerializerInterface;
use PHPUnit\Framework\TestCase;

class EngineTest extends TestCase
{
    private $connection;
    private $cache;
    private $cacheTypeList;
    private $serializer;
    private Engine $engineUnderTest;

    public function testToOptionArrayWithCachedData(): void
    {
        $cachedData = 'cached_data_content';
        $expectedOptions = [['value' => '1', 'label' => '1'], ['value' => '2', 'label' => '2']];

        $this->cache->expects($this->once())
            ->method('load')
            ->with('eclipse_model_options')
            ->willReturn($cachedData);

        $this->serializer->expects($this->once())
            ->method('unserialize')
            ->with($cachedData)
            ->willReturn($expectedOptions);


        $this->assertEquals($expectedOptions, $this->engineUnderTest->toOptionArray());
    }

    protected function setUp(): void
    {
        $this->connection = $this->createMock(ConnectionInterface::class);
        $this->cache = $this->createMock(CacheInterface::class);
        $this->cacheTypeList = $this->createMock(TypeListInterface::class);
        $this->serializer = $this->createMock(SerializerInterface::class);

        $this->engineUnderTest = new Engine($this->connection, $this->cache, $this->cacheTypeList, $this->serializer);
    }
}
