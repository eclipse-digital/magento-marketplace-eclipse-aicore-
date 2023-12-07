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


namespace Eclipse\AiCore\Model\Config\Source;

use Eclipse\AiCore\Api\Client\ConnectionInterface;
use Exception;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\CacheInterface;
use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\Serialize\SerializerInterface;

class Engine implements OptionSourceInterface
{
    private const CACHE_KEY = 'eclipse_model_options';

    public function __construct(
        private readonly ConnectionInterface $connection,
        private readonly CacheInterface               $cache,
        private readonly TypeListInterface            $cacheTypeList,
        private readonly SerializerInterface          $serializer
    )
    {
    }

    public function toOptionArray(): array
    {
        $cachedData = $this->cache->load(self::CACHE_KEY);
        if ($cachedData !== false) {
            return $this->serializer->unserialize($cachedData);
        }
        try {
            $options = [];
            $modelList = $this->connection->create()->models()->list();
            foreach ($modelList->data as $model) {
                $options[] = ['value' => $model->id, 'label' => $model->id];
            }
            sort($options);
            $this->cache->save($this->serializer->serialize($options), self::CACHE_KEY);
            $this->cacheTypeList->cleanType('config');
        } catch (Exception $e) {
            $options = [
                [
                    'value' => '',
                    'label' => 'No connection'
                ]
            ];
        }
        return $options;
    }
}
