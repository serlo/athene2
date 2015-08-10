<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
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
