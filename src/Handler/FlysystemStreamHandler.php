<?php

namespace Leon0399\MonologFlysystem\Handler;

use League\Flysystem\FilesystemInterface;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

/**
 * Stores Monolog records into Flysystem file
 *
 * @package Leon0399\MonologFlysystem\Handler
 * @author Leonid Meleshin <leon.03.99@gmail.com>
 */
class FlysystemStreamHandler extends AbstractProcessingHandler
{
    const DEFAULT_SEPARATOR = PHP_EOL;

    private $separator = self::DEFAULT_SEPARATOR;

    protected $filesystem;
    protected $path;

    /**
     * @param FilesystemInterface $filesystem Filesystem to write into
     * @param String $path Filename to write
     * @param int $level The minimum logging level at which this handler will be triggered
     * @param bool $bubble Whether the messages that are handled can bubble up the stack or not
     */
    public function __construct(FilesystemInterface $filesystem, String $path, int $level = Logger::DEBUG, bool $bubble = true)
    {
        $this->filesystem = $filesystem;
        $this->path = $path;

        parent::__construct($level, $bubble);
    }

    /**
     * Sets the separator between two records.
     *
     * @param string $separator
     * @return FlysystemStreamHandler
     */
    public function setSeparator(string $separator): FlysystemStreamHandler
    {
        $this->separator = $separator;
        return $this;
    }

    /**
     * @return string
     */
    public function getSeparator(): string
    {
        return $this->separator;
    }

    /**
     * {@inheritdoc}
     */
    protected function write(array $record): void
    {
        if (is_array($record['formatted'])) {
            $record['formatted'] = json_encode($record['formatted']);
        }

        $formated = $record['formatted'];

        $this->append($this->path, $formated);
    }

    /**
     * Append to a file.
     *
     * @param  string $path
     * @param  string $data
     * @param  string $separator
     * @return int
     */
    private function append($path, $data, $separator = self::DEFAULT_SEPARATOR)
    {
        if (is_array($data)) {
            $data = implode('', $data);
        }

        if ($this->filesystem->has($path)) {
            return $this->filesystem->put($path, $this->filesystem->read($path) . $separator . $data);
        }

        return $this->filesystem->put($path, $data);
    }
}
