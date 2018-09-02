<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 27.11.2017
 * Time: 17:11
 */

namespace Markdown\Service;

use DNode\DNode;
use Markdown\Exception;
use Markdown\Options\ModuleOptions;
use React\EventLoop\StreamSelectLoop;
use Zend\Cache\Storage\StorageInterface;

class OryRenderService implements RenderServiceInterface
{

    /**
     * @var StreamSelectLoop
     */
    protected $loop;

    /**
     * @var Donde
     */
    protected $dnode;

    /**
     * @var ModuleOptions
     */
    protected $options;

    /**
     * @var StorageInterface
     */
    protected $storage;

    /**
     * @param ModuleOptions    $options
     * @param StorageInterface $storage
     */
    public function __construct(ModuleOptions $options, StorageInterface $storage)
    {
        $this->loop    = new StreamSelectLoop();
        $this->dnode   = new DNode($this->loop);
        $this->options = $options;
        $this->storage = $storage;
    }
    /**
     * @see \Markdown\Service\RenderServiceInterface::render()
     */
    public function render($input)
    {
        $key = hash('sha512', $input);

        if ($this->storage->hasItem($key)) {
            //return $this->storage->getItem($key);
        }

        $rendered = null;

        $this->dnode->connect(
            '192.168.176.112',
            '7072',
            function ($remote, $connection) use ($input, &$rendered) {
                $remote->render(
                    $input,
                    function ($output, $exception = null, $error = null) use (&$rendered, $connection) {
                        if ($exception !== null) {
                            $connection->end();
                            throw new Exception\RuntimeException(sprintf(
                                'Bridge threw exception "%s" with message "%s".',
                                $exception,
                                $error
                            ));
                        }
                        $rendered = $output;
                        $connection->end();
                    }
                );
            }
        );
        $this->loop->run();

        if ($rendered === null) {
            throw new Exception\RuntimeException(sprintf('Broken pipe'));
        }

        $this->storage->setItem($key, $rendered);

        return $rendered;

    }
}
