<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Mailman\Adapter;

use Mailman\Exception;
use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;

class ZendMailAdapter implements AdapterInterface
{
    /**
     * @var ZendMailAdapter
     */
    private static $instance;

    /**
     * @var SmtpOptions
     */
    protected $smtpOptions;

    /**
     * @var array
     */
    protected $queue = [];

    /**
     * @var Smtp
     */
    protected $transport;

    public function __construct(SmtpOptions $smtpOptions)
    {
        if (self::$instance) {
            throw new Exception\RuntimeException('ZendMailAdapter does not allow multiple instances');
        }

        self::$instance    = $this;
        $this->smtpOptions = $smtpOptions;
        $this->queue       = [];
        $this->transport   = new Smtp();
    }

    public function addMail($to, $from, $subject, $body)
    {
        $message              = new Message();
        $bodyPart             = new MimeMessage();
        $bodyMessage          = new MimePart($body);
        $bodyMessage->type    = 'text/html';
        $bodyMessage->charset = 'UTF-8';
        $bodyPart->setParts([$bodyMessage]);
        $message->setFrom($from);
        $message->addTo($to);
        $message->setEncoding("UTF-8");
        $message->setSubject($subject);
        $message->setBody($bodyPart);
        $message->type = 'text/html';
        $this->queue[] = $message;
    }

    public function flush()
    {
        $this->transport->setOptions($this->getSmtpOptions());
        foreach ($this->queue as $message) {
            $this->transport->send($message);
        }
        $this->queue = [];
    }

    /**
     * @return \Zend\Mail\Transport\SmtpOptions $smtpOptions
     */
    public function getSmtpOptions()
    {
        return $this->smtpOptions;
    }
}
