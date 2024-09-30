<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Serializer;

use Illuminate\Database\Eloquent\Model;
use Liquetsoft\Fias\Component\Serializer\FiasSerializerFormat;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\AddrObj;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\AddrObjDivision;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\AddrObjTypes;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\AdmHierarchy;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\Apartments;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\ApartmentTypes;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\Carplaces;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\ChangeHistory;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\FiasVersion;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\Houses;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\HouseTypes;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\MunHierarchy;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\NormativeDocs;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\NormativeDocsKinds;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\NormativeDocsTypes;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\ObjectLevels;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\OperationTypes;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\Param;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\ParamTypes;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\ReestrObjects;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\Rooms;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\RoomTypes;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\Steads;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * Скомпилированный класс для денормализации сущностей ФИАС в модели eloquent.
 */
final class CompiledEntitesDenormalizer implements DenormalizerInterface
{
    private const ALLOWED_ENTITIES = [
        Apartments::class => true,
        AddrObjDivision::class => true,
        NormativeDocsTypes::class => true,
        RoomTypes::class => true,
        ObjectLevels::class => true,
        NormativeDocsKinds::class => true,
        Rooms::class => true,
        ApartmentTypes::class => true,
        AddrObjTypes::class => true,
        Steads::class => true,
        NormativeDocs::class => true,
        OperationTypes::class => true,
        Houses::class => true,
        AdmHierarchy::class => true,
        Carplaces::class => true,
        ChangeHistory::class => true,
        AddrObj::class => true,
        ParamTypes::class => true,
        Param::class => true,
        ReestrObjects::class => true,
        HouseTypes::class => true,
        MunHierarchy::class => true,
        FiasVersion::class => true,
    ];

    /**
     * {@inheritDoc}
     */
    public function supportsDenormalization($data, string $type, ?string $format = null, array $context = []): bool
    {
        return FiasSerializerFormat::XML->isEqual($format) && \array_key_exists(trim($type, " \t\n\r\0\x0B\\/"), self::ALLOWED_ENTITIES);
    }

    /**
     * {@inheritDoc}
     *
     * @psalm-suppress InvalidStringClass
     */
    public function denormalize($data, string $type, ?string $format = null, array $context = []): mixed
    {
        $dataToPopulate = $this->convertDataToInternalFormat($data);
        $type = trim($type, " \t\n\r\0\x0B\\/");

        $entity = $context[AbstractNormalizer::OBJECT_TO_POPULATE] ?? new $type();

        if (!($entity instanceof Model)) {
            throw new InvalidArgumentException("Bad class for populating entity, '" . Model::class . "' is required");
        }

        switch ($type) {
            case Apartments::class:
                $extractedData = $this->modelApartmentsDataExtractor($dataToPopulate);
                break;
            case AddrObjDivision::class:
                $extractedData = $this->modelAddrObjDivisionDataExtractor($dataToPopulate);
                break;
            case NormativeDocsTypes::class:
                $extractedData = $this->modelNormativeDocsTypesDataExtractor($dataToPopulate);
                break;
            case RoomTypes::class:
                $extractedData = $this->modelRoomTypesDataExtractor($dataToPopulate);
                break;
            case ObjectLevels::class:
                $extractedData = $this->modelObjectLevelsDataExtractor($dataToPopulate);
                break;
            case NormativeDocsKinds::class:
                $extractedData = $this->modelNormativeDocsKindsDataExtractor($dataToPopulate);
                break;
            case Rooms::class:
                $extractedData = $this->modelRoomsDataExtractor($dataToPopulate);
                break;
            case ApartmentTypes::class:
                $extractedData = $this->modelApartmentTypesDataExtractor($dataToPopulate);
                break;
            case AddrObjTypes::class:
                $extractedData = $this->modelAddrObjTypesDataExtractor($dataToPopulate);
                break;
            case Steads::class:
                $extractedData = $this->modelSteadsDataExtractor($dataToPopulate);
                break;
            case NormativeDocs::class:
                $extractedData = $this->modelNormativeDocsDataExtractor($dataToPopulate);
                break;
            case OperationTypes::class:
                $extractedData = $this->modelOperationTypesDataExtractor($dataToPopulate);
                break;
            case Houses::class:
                $extractedData = $this->modelHousesDataExtractor($dataToPopulate);
                break;
            case AdmHierarchy::class:
                $extractedData = $this->modelAdmHierarchyDataExtractor($dataToPopulate);
                break;
            case Carplaces::class:
                $extractedData = $this->modelCarplacesDataExtractor($dataToPopulate);
                break;
            case ChangeHistory::class:
                $extractedData = $this->modelChangeHistoryDataExtractor($dataToPopulate);
                break;
            case AddrObj::class:
                $extractedData = $this->modelAddrObjDataExtractor($dataToPopulate);
                break;
            case ParamTypes::class:
                $extractedData = $this->modelParamTypesDataExtractor($dataToPopulate);
                break;
            case Param::class:
                $extractedData = $this->modelParamDataExtractor($dataToPopulate);
                break;
            case ReestrObjects::class:
                $extractedData = $this->modelReestrObjectsDataExtractor($dataToPopulate);
                break;
            case HouseTypes::class:
                $extractedData = $this->modelHouseTypesDataExtractor($dataToPopulate);
                break;
            case MunHierarchy::class:
                $extractedData = $this->modelMunHierarchyDataExtractor($dataToPopulate);
                break;
            case FiasVersion::class:
                $extractedData = $this->modelFiasVersionDataExtractor($dataToPopulate);
                break;
            default:
                throw new InvalidArgumentException("Can't find data extractor for '{$type}' type");
                break;
        }

        $entity->setRawAttributes($extractedData);

        return $entity;
    }

    /**
     * {@inheritDoc}
     */
    public function getSupportedTypes(?string $format): array
    {
        return FiasSerializerFormat::XML->isEqual($format) ? self::ALLOWED_ENTITIES : [];
    }

    private function convertDataToInternalFormat(mixed $data): array
    {
        $result = [];
        if (!\is_array($data)) {
            return $result;
        }

        foreach ($data as $key => $value) {
            $newKey = strtolower(trim((string) $key, " \n\r\t\v\x00@"));
            $result[$newKey] = $value;
        }

        return $result;
    }

    /**
     * Получает правильный массив данных для модели 'Apartments'.
     */
    private function modelApartmentsDataExtractor(array $data): array
    {
        return [
            'id' => isset($data['id']) ? (int) $data['id'] : null,
            'objectid' => isset($data['objectid']) ? (int) $data['objectid'] : null,
            'objectguid' => isset($data['objectguid']) ? trim((string) $data['objectguid']) : null,
            'changeid' => isset($data['changeid']) ? (int) $data['changeid'] : null,
            'number' => isset($data['number']) ? trim((string) $data['number']) : null,
            'aparttype' => isset($data['aparttype']) ? (int) $data['aparttype'] : null,
            'opertypeid' => isset($data['opertypeid']) ? (int) $data['opertypeid'] : null,
            'previd' => isset($data['previd']) ? (int) $data['previd'] : null,
            'nextid' => isset($data['nextid']) ? (int) $data['nextid'] : null,
            'updatedate' => isset($data['updatedate']) ? new \DateTimeImmutable((string) $data['updatedate']) : null,
            'startdate' => isset($data['startdate']) ? new \DateTimeImmutable((string) $data['startdate']) : null,
            'enddate' => isset($data['enddate']) ? new \DateTimeImmutable((string) $data['enddate']) : null,
            'isactual' => isset($data['isactual']) ? (int) $data['isactual'] : null,
            'isactive' => isset($data['isactive']) ? (int) $data['isactive'] : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'AddrObjDivision'.
     */
    private function modelAddrObjDivisionDataExtractor(array $data): array
    {
        return [
            'id' => isset($data['id']) ? (int) $data['id'] : null,
            'parentid' => isset($data['parentid']) ? (int) $data['parentid'] : null,
            'childid' => isset($data['childid']) ? (int) $data['childid'] : null,
            'changeid' => isset($data['changeid']) ? (int) $data['changeid'] : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'NormativeDocsTypes'.
     */
    private function modelNormativeDocsTypesDataExtractor(array $data): array
    {
        return [
            'id' => isset($data['id']) ? (int) $data['id'] : null,
            'name' => isset($data['name']) ? trim((string) $data['name']) : null,
            'startdate' => isset($data['startdate']) ? new \DateTimeImmutable((string) $data['startdate']) : null,
            'enddate' => isset($data['enddate']) ? new \DateTimeImmutable((string) $data['enddate']) : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'RoomTypes'.
     */
    private function modelRoomTypesDataExtractor(array $data): array
    {
        return [
            'id' => isset($data['id']) ? (int) $data['id'] : null,
            'name' => isset($data['name']) ? trim((string) $data['name']) : null,
            'shortname' => isset($data['shortname']) ? trim((string) $data['shortname']) : null,
            'desc' => isset($data['desc']) ? trim((string) $data['desc']) : null,
            'updatedate' => isset($data['updatedate']) ? new \DateTimeImmutable((string) $data['updatedate']) : null,
            'startdate' => isset($data['startdate']) ? new \DateTimeImmutable((string) $data['startdate']) : null,
            'enddate' => isset($data['enddate']) ? new \DateTimeImmutable((string) $data['enddate']) : null,
            'isactive' => isset($data['isactive']) ? trim((string) $data['isactive']) : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'ObjectLevels'.
     */
    private function modelObjectLevelsDataExtractor(array $data): array
    {
        return [
            'level' => isset($data['level']) ? (int) $data['level'] : null,
            'name' => isset($data['name']) ? trim((string) $data['name']) : null,
            'shortname' => isset($data['shortname']) ? trim((string) $data['shortname']) : null,
            'updatedate' => isset($data['updatedate']) ? new \DateTimeImmutable((string) $data['updatedate']) : null,
            'startdate' => isset($data['startdate']) ? new \DateTimeImmutable((string) $data['startdate']) : null,
            'enddate' => isset($data['enddate']) ? new \DateTimeImmutable((string) $data['enddate']) : null,
            'isactive' => isset($data['isactive']) ? trim((string) $data['isactive']) : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'NormativeDocsKinds'.
     */
    private function modelNormativeDocsKindsDataExtractor(array $data): array
    {
        return [
            'id' => isset($data['id']) ? (int) $data['id'] : null,
            'name' => isset($data['name']) ? trim((string) $data['name']) : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'Rooms'.
     */
    private function modelRoomsDataExtractor(array $data): array
    {
        return [
            'id' => isset($data['id']) ? (int) $data['id'] : null,
            'objectid' => isset($data['objectid']) ? (int) $data['objectid'] : null,
            'objectguid' => isset($data['objectguid']) ? trim((string) $data['objectguid']) : null,
            'changeid' => isset($data['changeid']) ? (int) $data['changeid'] : null,
            'number' => isset($data['number']) ? trim((string) $data['number']) : null,
            'roomtype' => isset($data['roomtype']) ? (int) $data['roomtype'] : null,
            'opertypeid' => isset($data['opertypeid']) ? (int) $data['opertypeid'] : null,
            'previd' => isset($data['previd']) ? (int) $data['previd'] : null,
            'nextid' => isset($data['nextid']) ? (int) $data['nextid'] : null,
            'updatedate' => isset($data['updatedate']) ? new \DateTimeImmutable((string) $data['updatedate']) : null,
            'startdate' => isset($data['startdate']) ? new \DateTimeImmutable((string) $data['startdate']) : null,
            'enddate' => isset($data['enddate']) ? new \DateTimeImmutable((string) $data['enddate']) : null,
            'isactual' => isset($data['isactual']) ? (int) $data['isactual'] : null,
            'isactive' => isset($data['isactive']) ? (int) $data['isactive'] : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'ApartmentTypes'.
     */
    private function modelApartmentTypesDataExtractor(array $data): array
    {
        return [
            'id' => isset($data['id']) ? (int) $data['id'] : null,
            'name' => isset($data['name']) ? trim((string) $data['name']) : null,
            'shortname' => isset($data['shortname']) ? trim((string) $data['shortname']) : null,
            'desc' => isset($data['desc']) ? trim((string) $data['desc']) : null,
            'updatedate' => isset($data['updatedate']) ? new \DateTimeImmutable((string) $data['updatedate']) : null,
            'startdate' => isset($data['startdate']) ? new \DateTimeImmutable((string) $data['startdate']) : null,
            'enddate' => isset($data['enddate']) ? new \DateTimeImmutable((string) $data['enddate']) : null,
            'isactive' => isset($data['isactive']) ? trim((string) $data['isactive']) : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'AddrObjTypes'.
     */
    private function modelAddrObjTypesDataExtractor(array $data): array
    {
        return [
            'id' => isset($data['id']) ? (int) $data['id'] : null,
            'level' => isset($data['level']) ? (int) $data['level'] : null,
            'shortname' => isset($data['shortname']) ? trim((string) $data['shortname']) : null,
            'name' => isset($data['name']) ? trim((string) $data['name']) : null,
            'desc' => isset($data['desc']) ? trim((string) $data['desc']) : null,
            'updatedate' => isset($data['updatedate']) ? new \DateTimeImmutable((string) $data['updatedate']) : null,
            'startdate' => isset($data['startdate']) ? new \DateTimeImmutable((string) $data['startdate']) : null,
            'enddate' => isset($data['enddate']) ? new \DateTimeImmutable((string) $data['enddate']) : null,
            'isactive' => isset($data['isactive']) ? trim((string) $data['isactive']) : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'Steads'.
     */
    private function modelSteadsDataExtractor(array $data): array
    {
        return [
            'id' => isset($data['id']) ? (int) $data['id'] : null,
            'objectid' => isset($data['objectid']) ? (int) $data['objectid'] : null,
            'objectguid' => isset($data['objectguid']) ? trim((string) $data['objectguid']) : null,
            'changeid' => isset($data['changeid']) ? (int) $data['changeid'] : null,
            'number' => isset($data['number']) ? trim((string) $data['number']) : null,
            'opertypeid' => isset($data['opertypeid']) ? trim((string) $data['opertypeid']) : null,
            'previd' => isset($data['previd']) ? (int) $data['previd'] : null,
            'nextid' => isset($data['nextid']) ? (int) $data['nextid'] : null,
            'updatedate' => isset($data['updatedate']) ? new \DateTimeImmutable((string) $data['updatedate']) : null,
            'startdate' => isset($data['startdate']) ? new \DateTimeImmutable((string) $data['startdate']) : null,
            'enddate' => isset($data['enddate']) ? new \DateTimeImmutable((string) $data['enddate']) : null,
            'isactual' => isset($data['isactual']) ? (int) $data['isactual'] : null,
            'isactive' => isset($data['isactive']) ? (int) $data['isactive'] : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'NormativeDocs'.
     */
    private function modelNormativeDocsDataExtractor(array $data): array
    {
        return [
            'id' => isset($data['id']) ? (int) $data['id'] : null,
            'name' => isset($data['name']) ? trim((string) $data['name']) : null,
            'date' => isset($data['date']) ? new \DateTimeImmutable((string) $data['date']) : null,
            'number' => isset($data['number']) ? trim((string) $data['number']) : null,
            'type' => isset($data['type']) ? (int) $data['type'] : null,
            'kind' => isset($data['kind']) ? (int) $data['kind'] : null,
            'updatedate' => isset($data['updatedate']) ? new \DateTimeImmutable((string) $data['updatedate']) : null,
            'orgname' => isset($data['orgname']) ? trim((string) $data['orgname']) : null,
            'regnum' => isset($data['regnum']) ? trim((string) $data['regnum']) : null,
            'regdate' => isset($data['regdate']) ? new \DateTimeImmutable((string) $data['regdate']) : null,
            'accdate' => isset($data['accdate']) ? new \DateTimeImmutable((string) $data['accdate']) : null,
            'comment' => isset($data['comment']) ? trim((string) $data['comment']) : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'OperationTypes'.
     */
    private function modelOperationTypesDataExtractor(array $data): array
    {
        return [
            'id' => isset($data['id']) ? (int) $data['id'] : null,
            'name' => isset($data['name']) ? trim((string) $data['name']) : null,
            'shortname' => isset($data['shortname']) ? trim((string) $data['shortname']) : null,
            'desc' => isset($data['desc']) ? trim((string) $data['desc']) : null,
            'updatedate' => isset($data['updatedate']) ? new \DateTimeImmutable((string) $data['updatedate']) : null,
            'startdate' => isset($data['startdate']) ? new \DateTimeImmutable((string) $data['startdate']) : null,
            'enddate' => isset($data['enddate']) ? new \DateTimeImmutable((string) $data['enddate']) : null,
            'isactive' => isset($data['isactive']) ? trim((string) $data['isactive']) : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'Houses'.
     */
    private function modelHousesDataExtractor(array $data): array
    {
        return [
            'id' => isset($data['id']) ? (int) $data['id'] : null,
            'objectid' => isset($data['objectid']) ? (int) $data['objectid'] : null,
            'objectguid' => isset($data['objectguid']) ? trim((string) $data['objectguid']) : null,
            'changeid' => isset($data['changeid']) ? (int) $data['changeid'] : null,
            'housenum' => isset($data['housenum']) ? trim((string) $data['housenum']) : null,
            'addnum1' => isset($data['addnum1']) ? trim((string) $data['addnum1']) : null,
            'addnum2' => isset($data['addnum2']) ? trim((string) $data['addnum2']) : null,
            'housetype' => isset($data['housetype']) ? (int) $data['housetype'] : null,
            'addtype1' => isset($data['addtype1']) ? (int) $data['addtype1'] : null,
            'addtype2' => isset($data['addtype2']) ? (int) $data['addtype2'] : null,
            'opertypeid' => isset($data['opertypeid']) ? (int) $data['opertypeid'] : null,
            'previd' => isset($data['previd']) ? (int) $data['previd'] : null,
            'nextid' => isset($data['nextid']) ? (int) $data['nextid'] : null,
            'updatedate' => isset($data['updatedate']) ? new \DateTimeImmutable((string) $data['updatedate']) : null,
            'startdate' => isset($data['startdate']) ? new \DateTimeImmutable((string) $data['startdate']) : null,
            'enddate' => isset($data['enddate']) ? new \DateTimeImmutable((string) $data['enddate']) : null,
            'isactual' => isset($data['isactual']) ? (int) $data['isactual'] : null,
            'isactive' => isset($data['isactive']) ? (int) $data['isactive'] : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'AdmHierarchy'.
     */
    private function modelAdmHierarchyDataExtractor(array $data): array
    {
        return [
            'id' => isset($data['id']) ? (int) $data['id'] : null,
            'objectid' => isset($data['objectid']) ? (int) $data['objectid'] : null,
            'parentobjid' => isset($data['parentobjid']) ? (int) $data['parentobjid'] : null,
            'changeid' => isset($data['changeid']) ? (int) $data['changeid'] : null,
            'regioncode' => isset($data['regioncode']) ? trim((string) $data['regioncode']) : null,
            'areacode' => isset($data['areacode']) ? trim((string) $data['areacode']) : null,
            'citycode' => isset($data['citycode']) ? trim((string) $data['citycode']) : null,
            'placecode' => isset($data['placecode']) ? trim((string) $data['placecode']) : null,
            'plancode' => isset($data['plancode']) ? trim((string) $data['plancode']) : null,
            'streetcode' => isset($data['streetcode']) ? trim((string) $data['streetcode']) : null,
            'previd' => isset($data['previd']) ? (int) $data['previd'] : null,
            'nextid' => isset($data['nextid']) ? (int) $data['nextid'] : null,
            'updatedate' => isset($data['updatedate']) ? new \DateTimeImmutable((string) $data['updatedate']) : null,
            'startdate' => isset($data['startdate']) ? new \DateTimeImmutable((string) $data['startdate']) : null,
            'enddate' => isset($data['enddate']) ? new \DateTimeImmutable((string) $data['enddate']) : null,
            'isactive' => isset($data['isactive']) ? (int) $data['isactive'] : null,
            'path' => isset($data['path']) ? trim((string) $data['path']) : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'Carplaces'.
     */
    private function modelCarplacesDataExtractor(array $data): array
    {
        return [
            'id' => isset($data['id']) ? (int) $data['id'] : null,
            'objectid' => isset($data['objectid']) ? (int) $data['objectid'] : null,
            'objectguid' => isset($data['objectguid']) ? trim((string) $data['objectguid']) : null,
            'changeid' => isset($data['changeid']) ? (int) $data['changeid'] : null,
            'number' => isset($data['number']) ? trim((string) $data['number']) : null,
            'opertypeid' => isset($data['opertypeid']) ? (int) $data['opertypeid'] : null,
            'previd' => isset($data['previd']) ? (int) $data['previd'] : null,
            'nextid' => isset($data['nextid']) ? (int) $data['nextid'] : null,
            'updatedate' => isset($data['updatedate']) ? new \DateTimeImmutable((string) $data['updatedate']) : null,
            'startdate' => isset($data['startdate']) ? new \DateTimeImmutable((string) $data['startdate']) : null,
            'enddate' => isset($data['enddate']) ? new \DateTimeImmutable((string) $data['enddate']) : null,
            'isactual' => isset($data['isactual']) ? (int) $data['isactual'] : null,
            'isactive' => isset($data['isactive']) ? (int) $data['isactive'] : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'ChangeHistory'.
     */
    private function modelChangeHistoryDataExtractor(array $data): array
    {
        return [
            'changeid' => isset($data['changeid']) ? (int) $data['changeid'] : null,
            'objectid' => isset($data['objectid']) ? (int) $data['objectid'] : null,
            'adrobjectid' => isset($data['adrobjectid']) ? trim((string) $data['adrobjectid']) : null,
            'opertypeid' => isset($data['opertypeid']) ? (int) $data['opertypeid'] : null,
            'ndocid' => isset($data['ndocid']) ? (int) $data['ndocid'] : null,
            'changedate' => isset($data['changedate']) ? new \DateTimeImmutable((string) $data['changedate']) : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'AddrObj'.
     */
    private function modelAddrObjDataExtractor(array $data): array
    {
        return [
            'id' => isset($data['id']) ? (int) $data['id'] : null,
            'objectid' => isset($data['objectid']) ? (int) $data['objectid'] : null,
            'objectguid' => isset($data['objectguid']) ? trim((string) $data['objectguid']) : null,
            'changeid' => isset($data['changeid']) ? (int) $data['changeid'] : null,
            'name' => isset($data['name']) ? trim((string) $data['name']) : null,
            'typename' => isset($data['typename']) ? trim((string) $data['typename']) : null,
            'level' => isset($data['level']) ? trim((string) $data['level']) : null,
            'opertypeid' => isset($data['opertypeid']) ? (int) $data['opertypeid'] : null,
            'previd' => isset($data['previd']) ? (int) $data['previd'] : null,
            'nextid' => isset($data['nextid']) ? (int) $data['nextid'] : null,
            'updatedate' => isset($data['updatedate']) ? new \DateTimeImmutable((string) $data['updatedate']) : null,
            'startdate' => isset($data['startdate']) ? new \DateTimeImmutable((string) $data['startdate']) : null,
            'enddate' => isset($data['enddate']) ? new \DateTimeImmutable((string) $data['enddate']) : null,
            'isactual' => isset($data['isactual']) ? (int) $data['isactual'] : null,
            'isactive' => isset($data['isactive']) ? (int) $data['isactive'] : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'ParamTypes'.
     */
    private function modelParamTypesDataExtractor(array $data): array
    {
        return [
            'id' => isset($data['id']) ? (int) $data['id'] : null,
            'name' => isset($data['name']) ? trim((string) $data['name']) : null,
            'code' => isset($data['code']) ? trim((string) $data['code']) : null,
            'desc' => isset($data['desc']) ? trim((string) $data['desc']) : null,
            'updatedate' => isset($data['updatedate']) ? new \DateTimeImmutable((string) $data['updatedate']) : null,
            'startdate' => isset($data['startdate']) ? new \DateTimeImmutable((string) $data['startdate']) : null,
            'enddate' => isset($data['enddate']) ? new \DateTimeImmutable((string) $data['enddate']) : null,
            'isactive' => isset($data['isactive']) ? trim((string) $data['isactive']) : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'Param'.
     */
    private function modelParamDataExtractor(array $data): array
    {
        return [
            'id' => isset($data['id']) ? (int) $data['id'] : null,
            'objectid' => isset($data['objectid']) ? (int) $data['objectid'] : null,
            'changeid' => isset($data['changeid']) ? (int) $data['changeid'] : null,
            'changeidend' => isset($data['changeidend']) ? (int) $data['changeidend'] : null,
            'typeid' => isset($data['typeid']) ? (int) $data['typeid'] : null,
            'value' => isset($data['value']) ? trim((string) $data['value']) : null,
            'updatedate' => isset($data['updatedate']) ? new \DateTimeImmutable((string) $data['updatedate']) : null,
            'startdate' => isset($data['startdate']) ? new \DateTimeImmutable((string) $data['startdate']) : null,
            'enddate' => isset($data['enddate']) ? new \DateTimeImmutable((string) $data['enddate']) : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'ReestrObjects'.
     */
    private function modelReestrObjectsDataExtractor(array $data): array
    {
        return [
            'objectid' => isset($data['objectid']) ? (int) $data['objectid'] : null,
            'createdate' => isset($data['createdate']) ? new \DateTimeImmutable((string) $data['createdate']) : null,
            'changeid' => isset($data['changeid']) ? (int) $data['changeid'] : null,
            'levelid' => isset($data['levelid']) ? (int) $data['levelid'] : null,
            'updatedate' => isset($data['updatedate']) ? new \DateTimeImmutable((string) $data['updatedate']) : null,
            'objectguid' => isset($data['objectguid']) ? trim((string) $data['objectguid']) : null,
            'isactive' => isset($data['isactive']) ? (int) $data['isactive'] : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'HouseTypes'.
     */
    private function modelHouseTypesDataExtractor(array $data): array
    {
        return [
            'id' => isset($data['id']) ? (int) $data['id'] : null,
            'name' => isset($data['name']) ? trim((string) $data['name']) : null,
            'shortname' => isset($data['shortname']) ? trim((string) $data['shortname']) : null,
            'desc' => isset($data['desc']) ? trim((string) $data['desc']) : null,
            'updatedate' => isset($data['updatedate']) ? new \DateTimeImmutable((string) $data['updatedate']) : null,
            'startdate' => isset($data['startdate']) ? new \DateTimeImmutable((string) $data['startdate']) : null,
            'enddate' => isset($data['enddate']) ? new \DateTimeImmutable((string) $data['enddate']) : null,
            'isactive' => isset($data['isactive']) ? trim((string) $data['isactive']) : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'MunHierarchy'.
     */
    private function modelMunHierarchyDataExtractor(array $data): array
    {
        return [
            'id' => isset($data['id']) ? (int) $data['id'] : null,
            'objectid' => isset($data['objectid']) ? (int) $data['objectid'] : null,
            'parentobjid' => isset($data['parentobjid']) ? (int) $data['parentobjid'] : null,
            'changeid' => isset($data['changeid']) ? (int) $data['changeid'] : null,
            'oktmo' => isset($data['oktmo']) ? trim((string) $data['oktmo']) : null,
            'previd' => isset($data['previd']) ? (int) $data['previd'] : null,
            'nextid' => isset($data['nextid']) ? (int) $data['nextid'] : null,
            'updatedate' => isset($data['updatedate']) ? new \DateTimeImmutable((string) $data['updatedate']) : null,
            'startdate' => isset($data['startdate']) ? new \DateTimeImmutable((string) $data['startdate']) : null,
            'enddate' => isset($data['enddate']) ? new \DateTimeImmutable((string) $data['enddate']) : null,
            'isactive' => isset($data['isactive']) ? (int) $data['isactive'] : null,
            'path' => isset($data['path']) ? trim((string) $data['path']) : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'FiasVersion'.
     */
    private function modelFiasVersionDataExtractor(array $data): array
    {
        return [
            'version' => isset($data['version']) ? (int) $data['version'] : null,
            'fullurl' => isset($data['fullurl']) ? trim((string) $data['fullurl']) : null,
            'deltaurl' => isset($data['deltaurl']) ? trim((string) $data['deltaurl']) : null,
            'created_at' => isset($data['created_at']) ? new \DateTimeImmutable((string) $data['created_at']) : null,
        ];
    }
}
