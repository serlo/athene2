<?php
namespace Newsletter;

use \DrewM\MailChimp\MailChimp;

trait MailChimpAwareTrait
{

    /**
     * @var MailChimp
     */
    protected $mailChimp;

    /**
     * @return MailChimp $mailChimp
     */
    public function getMailChimp()
    {
        return $this->mailman;
    }

    /**
     * @param MailChimp $mailChimp
     * @return self
     */
    public function setMailChimp(MailChimp $mailChimp)
    {
        $this->mailman = $mailChimp;
    }
}
