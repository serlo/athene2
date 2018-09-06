<?php
namespace Markdown\Service;

use Markdown\Exception;
use Zend\Cache\Storage\StorageInterface;

class OryRenderService implements RenderServiceInterface
{
    protected $url;

    /**
     * @var StorageInterface
     */
    protected $storage;

    /**
     * @param string           $url
     * @param StorageInterface $storage
     */
    public function __construct($url, StorageInterface $storage)
    {
        $this->url     = $url;
        $this->storage = $storage;
    }
    /**
     * @see \Markdown\Service\RenderServiceInterface::render()
     */
    public function render($input)
    {
        $key = 'editor-renderer-' . hash('sha512', $input);

        if ($this->storage->hasItem($key)) {
            return $this->storage->getItem($key);
        }

        $rendered = null;
        $data     = array('state' => $input);

        $httpHeader = array(
            'Accept: application/json',
            'Content-Type: application/json',
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $httpHeader);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        curl_close($ch);

        try {
            $rendered = json_decode($result, true)['html'];
        } catch (Exception $e) {
            throw new Exception\RuntimeException(sprintf('Broken pipe'));
        }

        $this->storage->setItem($key, $rendered);

        return $rendered;
    }
}
