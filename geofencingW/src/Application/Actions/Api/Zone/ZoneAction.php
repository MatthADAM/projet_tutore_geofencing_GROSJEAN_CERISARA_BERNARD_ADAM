<?php

namespace App\Application\Actions\Api\Zone;

use App\Domain\Zone;
use App\Application\Actions\Action;
use Psr\Log\LoggerInterface;

abstract class ZoneAction extends Action {
    /**
    * @var zone
    */
    protected $zone;
    
    /**
    * @param LoggerInterface $logger
    * @param zone  $zone
    */
    public function __construct(LoggerInterface $logger, Zone $zone)
    {
        parent::__construct($logger);
        $this->zone = $zone;
    }
}

?>