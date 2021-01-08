<?php

namespace App\Application\Actions\Api\Points;

use App\Domain\Point;
use App\Application\Actions\Action;
use Psr\Log\LoggerInterface;

abstract class PointsAction extends Action {
    /**
    * @var points
    */
    protected $points;
    
    /**
    * @param LoggerInterface $logger
    * @param points  $users
    */
    public function __construct(LoggerInterface $logger, Point $points)
    {
        parent::__construct($logger);
        $this->points = $points;
    }
}

?>