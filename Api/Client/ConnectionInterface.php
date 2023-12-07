<?php

/**
 * @category  Eclipse
 * @package  Eclipse_AiCore
 * @subpackage   Api
 * @author  Szymon Łukaszewicz <szymon.lukaszewicz@eclipsegroup.co.uk>
 * @copyright 2023 Eclipse
 * @since     1.0.0
 */


namespace Eclipse\AiCore\Api\Client;

interface ConnectionInterface
{
    public function create(): object;
}
