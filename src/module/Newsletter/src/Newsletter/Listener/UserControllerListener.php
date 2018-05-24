<?php
namespace Newsletter\Listener;

use \DrewM\MailChimp\MailChimp;
use Common\Listener\AbstractSharedListenerAggregate;
use Newsletter\MailChimpAwareTrait;
use Newsletter\MailChimpInterface;
use Zend\EventManager\Event;
use Zend\EventManager\SharedEventManagerInterface;
use Zend\Http\Client;
use Zend\Http\PhpEnvironment\RemoteAddress;

class UserControllerListener extends AbstractSharedListenerAggregate
{
    use MailChimpAwareTrait;

    /**
     * @param MailChimp $mailChimp
     */
    public function __construct(MailChimp $mailChimp)
    {
        $this->mailChimp = $mailChimp;
    }

    public function attachShared(SharedEventManagerInterface $events)
    {
        $events->attach($this->getMonitoredClass(), 'register', [$this, 'onRegister']);
    }

    /**
     * Gets executed after user registration
     *
     * @param Event $e
     * @return void
     */
    public function onRegister(Event $e)
    {
        /* @var $user \User\Entity\UserInterface */
        $user = $e->getParam('user');
        $data = $e->getParam('data');
        $email = $user->getEmail();
        $username = $user->getUsername();
        $timestamp = date('c');
        $ip = (new RemoteAddress())->getIpAddress();
        $newsletterOptIn = $data['newsletterOptIn'];
        $firstName = $data['firstName'];
        $lastName = $data['lastName'];
        $interests = $data['interests'];

        if (!$newsletterOptIn) {
            return;
        }

        $request = array(
            'email_address' => $email,
            'status' => 'subscribed',
            'merge_fields' => array(
                'FNAME' => $firstName,
                'LNAME' => $lastName,
                'UNAME' => $username,
                'MMERGE6' => $timestamp
            ),
            'ip_signup' => $ip,
            'timestamp_signup' => $timestamp,
            'ip_opt' => $ip,
            'timestamp_opt' => $timestamp
        );

        if ($interests) {
            $request = array_merge($request, array(
                'interests' => array(
                    $interests => true
                )
            ));
        }

        $result = $this->mailChimp->post('lists/a7bb2bbc4f/members', $request);

        print_r($result);
    }

    protected function getMonitoredClass()
    {
        return 'User\Controller\UserController';
    }
}
