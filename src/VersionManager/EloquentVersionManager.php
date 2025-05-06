<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\VersionManager;

use Carbon\Carbon;
use Liquetsoft\Fias\Component\FiasInformer\FiasInformerResponse;
use Liquetsoft\Fias\Component\FiasInformer\FiasInformerResponseFactory;
use Liquetsoft\Fias\Component\VersionManager\VersionManager;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\FiasVersion;

/**
 * Объект, который сохраняет текущую версию ФИАС с помощью eloquent.
 */
final class EloquentVersionManager implements VersionManager
{
    public function __construct(private readonly string $entityClassName)
    {
    }

    /**
     * {@inheritdoc}
     *
     * @throws \RuntimeException
     */
    #[\Override]
    public function setCurrentVersion(FiasInformerResponse $info): void
    {
        $entityClassName = $this->getEntityClassName();

        /** @var FiasVersion */
        $entity = new $entityClassName();

        $entity->version = $info->getVersion();
        $entity->fullurl = $info->getFullUrl();
        $entity->deltaurl = $info->getDeltaUrl();
        $entity->created_at = Carbon::now();
        $entity->save();
    }

    /**
     * {@inheritdoc}
     *
     * @throws \RuntimeException
     *
     * @psalm-suppress MixedMethodCall
     */
    #[\Override]
    public function getCurrentVersion(): ?FiasInformerResponse
    {
        $entityClassName = $this->getEntityClassName();

        /** @var FiasVersion|null */
        $entity = $entityClassName::query()->orderBy('created_at', 'desc')->first();

        if ($entity) {
            return FiasInformerResponseFactory::create(
                $entity->version,
                $entity->fullurl,
                $entity->deltaurl
            );
        }

        return null;
    }

    /**
     * Возвращает класс сущности для обращения к Eloquent.
     *
     * @psalm-return class-string<FiasVersion>
     *
     * @throws \RuntimeException
     */
    protected function getEntityClassName(): string
    {
        $trimmedEntityClassName = trim($this->entityClassName, " \t\n\r\0\x0B\\");

        if ($trimmedEntityClassName !== FiasVersion::class && !is_subclass_of($trimmedEntityClassName, FiasVersion::class)) {
            throw new \RuntimeException(
                "Entity class must be a '" . FiasVersion::class . "' instance or it's successor class, got '{$trimmedEntityClassName}'."
                . " Please check that 'liquetsoft_fias.version_manager_entity' parameter is properly configured."
            );
        }

        return $trimmedEntityClassName;
    }
}
