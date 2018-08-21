<?php

namespace Leon0399\MonologFlysystem;

use League\Flysystem\Adapter\Local as LocalAdapter;
use League\Flysystem\Filesystem;
use Leon0399\MonologFlysystem\Handler\FlysystemStreamHandler;
use Monolog\Logger;

class FlysystemStreamHandlerTest extends TestCase
{

    protected $root;

    protected $filename;

    /**
     * @var LocalAdapter
     */
    protected $adapter;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var FlysystemStreamHandler
     */
    protected $handler;

    public function setup()
    {
        $this->filename = 'logs/' . mt_rand() . '.log';

        $this->root = __DIR__ . '/files/';
        $this->adapter = new LocalAdapter($this->root);
        $this->filesystem = new Filesystem($this->adapter);

        $this->handler = new FlysystemStreamHandler($this->filesystem, $this->filename);
        $this->handler->setFormatter($this->getIdentityFormatter());
    }

    public function testWrite()
    {
        $this->handler->handle($this->getRecord(Logger::WARNING, 'test'));

        self::assertEquals('test', $this->readFile());
    }

    public function testMultipleWrite()
    {
        foreach ($this->getMultipleRecords() as $record) {
            $this->handler->handle($record);
        }

        $expected = [
            "debug message 1",
            "debug message 2",
            "information",
            "warning",
            "c"
        ];

        self::assertEquals(implode($this->handler->getSeparator(), $expected), $this->readFile());
    }

    public function testSetSeparator()
    {
        $separator = '' . mt_rand();
        $this->handler->setSeparator($separator);

        self::assertEquals($separator, $this->handler->getSeparator());
    }

    private function readFile()
    {
        return $this->filesystem->read($this->filename);
    }
}
