<?php
/**
 * Created by PhpStorm.
 * User: ca_php_2s11
 * Date: 2018-06-19
 * Time: 10:34
 */

namespace App\Event;

use Symfony\Component\EventDispatcher\Event;

class SomeEvent extends Event
{
    const NAME = 'page.loaded';

    /**
     * @var \DateTime
     */
    private $date;

    public function __construct(\DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }
}