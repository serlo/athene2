<?php
namespace Mailman\Controller;

use Mailman\Adapter\MailMockAdapter;
use Mailman\MailmanInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

class MailMockController extends AbstractActionController
{
    /**
     * @var MailMockAdapter
     */
    protected $mailmock;

    public function __construct(MailMockAdapter $mailmock) {
        $this->mailmock = $mailmock;
    }

    public function listAction() {
        return new JsonModel([
            'queue' => $this->mailmock->getQueue(),
            'flushed' => $this->mailmock->getFlushed()
        ]);
    }

    public function clearAction() {
        $this->mailmock->clear();
        return $this->redirect()->toReferer();
    }
}
