<?php
/**
 * This file is part of Athene2.
 *
 * Copyright (c) 2013-2018 Serlo Education e.V.
 *
 * Licensed under the Apache License, Version 2.0 (the "License")
 * you may not use this file except in compliance with the License
 * You may obtain a copy of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @copyright Copyright (c) 2013-2018 Serlo Education e.V.
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Markdown\Service;

use DNode\DNode;
use Markdown\Exception;
use Markdown\Options\ModuleOptions;
use React\EventLoop\StreamSelectLoop;
use Zend\Cache\Storage\StorageInterface;

class HtmlRenderService implements RenderServiceInterface
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
        $key = 'html-renderer-' . hash('sha512', $input);

        if ($this->storage->hasItem($key)) {
            return $this->storage->getItem($key);
        }

        $rendered = null;

        $this->dnode->connect(
            $this->options->getHost(),
            $this->options->getPort(),
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
