<?php

/**
 * @category  Eclipse
 * @package  Eclipse_AiCore
 * @subpackage   Gateway
 * @author  Szymon Łukaszewicz <szymon.lukaszewicz@eclipsegroup.co.uk>
 * @copyright 2023 Eclipse
 * @since     1.0.0
 */

declare(strict_types=1);


namespace Eclipse\AiCore\Client;

use Eclipse\AiCore\Api\Client\ConnectionInterface;
use Eclipse\AiCore\Model\ConfigProvider;
use Magento\Framework\Exception\InputException;
use OpenAI;
use OpenAI\Client;
use Psr\Log\LoggerInterface;

class Connection implements ConnectionInterface
{
    public function __construct(private ConfigProvider $config, private LoggerInterface $logger)
    {
    }

    public function create(): Client
    {
        $apiKey = $this->config->getEclipseAiApiKey();
        if (is_null($apiKey) || empty($apiKey)) {
            throw new \Exception('OpenAI API Key is not set');
        }
        return $this->connection();

    }

    /**
     * @return Client|void
     */
    private function connection()
    {
        try {
            return OpenAI::client(
                $this->config->getEclipseAiApiKey(),
                $this->config->getEclipseAiOrganisation()
            );
        } catch (InputException $e) {
            $this->logger->error($e->getMessage(), ['exception' => $e]);
        }
    }
}
