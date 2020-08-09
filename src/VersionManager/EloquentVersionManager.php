<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\VersionManager;

use Carbon\Carbon;
use Liquetsoft\Fias\Component\FiasInformer\InformerResponse;
use Liquetsoft\Fias\Component\FiasInformer\InformerResponseBase;
use Liquetsoft\Fias\Component\VersionManager\VersionManager;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\FiasVersion;
use RuntimeException;

/**
 * Объект, который сохраняет текущую версию ФИАС с помощью eloquent.
 */
class EloquentVersionManager implements VersionManager
{
    /**
     * @var string
     */
    protected $entityClassName;

    /**
     * @param string $entityClassName
     */
    public function __construct(string $entityClassName)
    {
        $this->entityClassName = $entityClassName;
    }

    /**
     * {@inheritdoc}
     *
     * @throws RuntimeException
     *
     * @psalm-suppress InvalidStringClass
     */
    public function setCurrentVersion(InformerResponse $info): VersionManager
    {
        $entityClassName = $this->getEntityClassName();
        $entity = new $entityClassName();

        $entity->version = $info->getVersion();
        $entity->url = $info->getUrl();
        $entity->created_at = Carbon::now();
        $entity->save();

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @throws RuntimeException
     *
     * @psalm-suppress InvalidStringClass
     */
    public function getCurrentVersion(): InformerResponse
    {
        $response = new InformerResponseBase();

        $entityClassName = $this->getEntityClassName();
        $entity = $entityClassName::query()->orderBy('created_at', 'desc')->first();
        if ($entity) {
            $response->setVersion($entity->version);
            $response->setUrl($entity->url);
        }

        return $response;
    }

    /**
     * Возвращает класс сущности для обращения к Eloquent.
     *
     * @return string
     *
     * @throws RuntimeException
     */
    protected function getEntityClassName(): string
    {
        $trimmedEntityClassName = trim($this->entityClassName, " \t\n\r\0\x0B\\");

        if ($trimmedEntityClassName !== FiasVersion::class && !is_subclass_of($trimmedEntityClassName, FiasVersion::class)) {
            throw new RuntimeException(
                "Entity class must be a '" . FiasVersion::class . "' instance or it's successor class, got '{$trimmedEntityClassName}'."
                . " Please check that 'liquetsoft_fias.version_manager_entity' parameter is properly configured."
            );
        }

        return $trimmedEntityClassName;
    }
}
