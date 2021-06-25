<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Command;

use Exception;
use Symfony\Component\Console\Exception\ExceptionInterface;

class FiasConsoleException extends Exception implements ExceptionInterface
{
}
