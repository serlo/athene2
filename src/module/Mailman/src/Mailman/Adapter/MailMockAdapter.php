<?php
namespace Mailman\Adapter;

use Mailman\Exception;
use Zend\Cache\Storage\StorageInterface;

class MailMockAdapter implements AdapterInterface
{
    protected static $instance;

    /**
     * @var StorageInterface
     */
    protected $storage;

    protected $queueKey = ':QUEUE:';
    protected $flushedKey = ':FLUSHED:';



    public function __construct(StorageInterface $storage)
    {
        if (self::$instance) {
            throw new Exception\RuntimeException('ZendMailAdapter does not allow multiple instances');
        }

        self::$instance    = $this;
        $this->storage = $storage;
        if(! $this->storage->hasItem($this->queueKey)) {
            $this->storage->setItem($this->queueKey, []);
        }
        if(! $this->storage->hasItem($this->flushedKey)) {
            $this->storage->setItem($this->flushedKey, []);
        }
    }

    public function addMail($to, $from, $mail)
    {
        $queue = $this->storage->getItem($this->queueKey);
        $queue[] = [
            'to' => $to,
            'from' => $from,
            'mail' => [
                'subject' => $mail->getSubject(),
                'body' => $mail->getHtmlBody(),
                'plain' => $mail->getPlainBody()
            ]
        ];
        $this->storage->setItem($this->queueKey, $queue);
    }

    public function flush()
    {
        $currentQueue = $this->storage->getItem($this->queueKey);
        $this->storage->setItem($this->flushedKey, $currentQueue);
        $this->storage->setItem($this->queueKey, []);
    }

    public function clear()
    {
        $this->storage->setItem($this->queueKey, []);
        $this->storage->setItem($this->flushedKey, []);
    }

    public function getQueue() {
        return $this->storage->getItem($this->queueKey);
    }

    public function getFlushed() {
        return $this->storage->getItem($this->flushedKey);
    }
}
