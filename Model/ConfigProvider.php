<?php

/**
 * @category  Eclipse
 * @package  Eclipse_AiCore
 * @subpackage   Model
 * @author  Szymon Łukaszewicz <szymon.lukaszewicz@eclipsegroup.co.uk>
 * @copyright 2023 Eclipse
 * @since     1.0.0
 */

declare(strict_types=1);


namespace Eclipse\AiCore\Model;

use Magento\Framework\App\Config\ScopeCodeResolver;
use Magento\Framework\Encryption\EncryptorInterface;

class ConfigProvider extends \Magento\Framework\App\Config
{
    public const XML_PATH_ECLIPSE_AI_API_KEY = 'eclipse_ai_client/eclipse_ai_config/api_key';
    public const XML_PATH_ECLIPSE_AI_API_ORGANISATION = 'eclipse_ai_client/eclipse_ai_config/organisation_key';
    public const XML_PATH_ECLIPSE_AI_API_ENGINE = 'eclipse_ai_client/eclipse_ai_config/engine';

    public function __construct(ScopeCodeResolver $scopeCodeResolver, private EncryptorInterface $encryptor, array $types = [])
    {
        parent::__construct($scopeCodeResolver, $types);
    }


    /**
     * @return string
     */
    public function getEclipseAiApiKey(): string
    {
        return $this->encryptor->decrypt($this->getEclipseAiKey());
    }

    /**
     * @return string
     */
    private function getEclipseAiKey(): string
    {
        return (string)$this->getValue(
            self::XML_PATH_ECLIPSE_AI_API_KEY
        );
    }

    public function getEclipseAiOrganisation(): string
    {
        return (string)$this->getValue(
            self::XML_PATH_ECLIPSE_AI_API_ORGANISATION
        );
    }

    /**
     * @return string
     */
    public function getEclipseAiEngine(): string
    {
        return (string)$this->getValue(
            self::XML_PATH_ECLIPSE_AI_API_ENGINE
        );
    }
}
