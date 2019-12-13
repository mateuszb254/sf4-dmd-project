<?php

namespace App\Core\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as BaseController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

abstract class AbstractController extends BaseController
{
    use ControllerTrait;

    public static function getSubscribedServices()
    {
        return array_merge(parent::getSubscribedServices(), [
            'event_dispatcher' => EventDispatcherInterface::class
        ]);
    }
}
