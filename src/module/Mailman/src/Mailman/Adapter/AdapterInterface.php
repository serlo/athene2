<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Mailman\Adapter;

interface AdapterInterface
{
    /**
     * @param string $to
     * @param string $from
     * @param string $subject
     * @param string $body
     * @return void
     */
    public function addMail($to, $from, $subject, $body);

    /**
     * sends all mail in the queue
     *
     * @return void
     */
    public function flush();
}
