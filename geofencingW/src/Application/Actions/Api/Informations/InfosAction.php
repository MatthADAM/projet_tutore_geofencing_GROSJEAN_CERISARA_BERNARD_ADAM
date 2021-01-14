<?php

namespace App\Application\Actions\Api\Infos;

use App\Domain\Informations;
use App\Application\Actions\Action;
use Psr\Log\LoggerInterface;

abstract class InfosAction extends Action {
    /**
    * @var infos
    */
    protected $infos;
    
    /**
    * @param LoggerInterface $logger
    * @param infos  $infos
    */
    public function __construct(LoggerInterface $logger, Informations $infos)
    {
        parent::__construct($logger);
        $this->infos = $infos;
    }
}

?>