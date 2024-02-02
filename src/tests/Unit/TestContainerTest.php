<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Testcontainers\TestContainer;

class TestContainerTest extends TestCase
{
//    private static TestContainer $redisContainer;
//
//    /**
//     * @throws TestContainerException
//     */
//    public static function setUpBeforeClass(): void
//    {
//        self::$redisContainer = new RedisContainer();
//        self::$redisContainer->start();
//    }
//
//    /**
//     * @throws TestContainerException
//     */
//    public static function tearDownAfterClass(): void
//    {
//        self::$redisContainer->stop();
//    }
//
//    public function testConnectSetAndGet(): void
//    {
//        $redis_client = new Client([
//            'host' => self::$redisContainer->getHost(),
//            'port' => self::$redisContainer->getFirstMappedPort(),
//        ]);
//
//        $redis_client->set('testcontainers', 'php');
//
//        $this->assertSame('php', $redis_client->get('testcontainers'));
//    }

}
