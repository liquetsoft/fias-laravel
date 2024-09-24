<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Serializer;

use Illuminate\Database\Eloquent\Model;
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
class CompiledEntitesDenormalizer implements DenormalizerInterface
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
    public function supportsDenormalization($data, string $type, ?string $format = null)
    {
        return \array_key_exists(trim($type, " \t\n\r\0\x0B\\/"), self::ALLOWED_ENTITIES);
    }

    /**
     * {@inheritDoc}
     *
     * @psalm-suppress InvalidStringClass
     */
    public function denormalize($data, string $type, ?string $format = null, array $context = [])
    {
        $data = \is_array($data) ? $data : [];
        $type = trim($type, " \t\n\r\0\x0B\\/");

        $entity = $context[AbstractNormalizer::OBJECT_TO_POPULATE] ?? new $type();

        if (!($entity instanceof Model)) {
            throw new InvalidArgumentException("Bad class for populating entity, '" . Model::class . "' is required");
        }

        switch ($type) {
            case Apartments::class:
                $extractedData = $this->modelApartmentsDataExtractor($data);
                break;
            case AddrObjDivision::class:
                $extractedData = $this->modelAddrObjDivisionDataExtractor($data);
                break;
            case NormativeDocsTypes::class:
                $extractedData = $this->modelNormativeDocsTypesDataExtractor($data);
                break;
            case RoomTypes::class:
                $extractedData = $this->modelRoomTypesDataExtractor($data);
                break;
            case ObjectLevels::class:
                $extractedData = $this->modelObjectLevelsDataExtractor($data);
                break;
            case NormativeDocsKinds::class:
                $extractedData = $this->modelNormativeDocsKindsDataExtractor($data);
                break;
            case Rooms::class:
                $extractedData = $this->modelRoomsDataExtractor($data);
                break;
            case ApartmentTypes::class:
                $extractedData = $this->modelApartmentTypesDataExtractor($data);
                break;
            case AddrObjTypes::class:
                $extractedData = $this->modelAddrObjTypesDataExtractor($data);
                break;
            case Steads::class:
                $extractedData = $this->modelSteadsDataExtractor($data);
                break;
            case NormativeDocs::class:
                $extractedData = $this->modelNormativeDocsDataExtractor($data);
                break;
            case OperationTypes::class:
                $extractedData = $this->modelOperationTypesDataExtractor($data);
                break;
            case Houses::class:
                $extractedData = $this->modelHousesDataExtractor($data);
                break;
            case AdmHierarchy::class:
                $extractedData = $this->modelAdmHierarchyDataExtractor($data);
                break;
            case Carplaces::class:
                $extractedData = $this->modelCarplacesDataExtractor($data);
                break;
            case ChangeHistory::class:
                $extractedData = $this->modelChangeHistoryDataExtractor($data);
                break;
            case AddrObj::class:
                $extractedData = $this->modelAddrObjDataExtractor($data);
                break;
            case ParamTypes::class:
                $extractedData = $this->modelParamTypesDataExtractor($data);
                break;
            case Param::class:
                $extractedData = $this->modelParamDataExtractor($data);
                break;
            case ReestrObjects::class:
                $extractedData = $this->modelReestrObjectsDataExtractor($data);
                break;
            case HouseTypes::class:
                $extractedData = $this->modelHouseTypesDataExtractor($data);
                break;
            case MunHierarchy::class:
                $extractedData = $this->modelMunHierarchyDataExtractor($data);
                break;
            case FiasVersion::class:
                $extractedData = $this->modelFiasVersionDataExtractor($data);
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
        return self::ALLOWED_ENTITIES;
    }

    /**
     * Получает правильный массив данных для модели 'Apartments'.
     */
    private function modelApartmentsDataExtractor(array $data): array
    {
        return [
            'id' => isset($data['@ID']) ? (int) $data['@ID'] : null,
            'objectid' => isset($data['@OBJECTID']) ? (int) $data['@OBJECTID'] : null,
            'objectguid' => isset($data['@OBJECTGUID']) ? trim((string) $data['@OBJECTGUID']) : null,
            'changeid' => isset($data['@CHANGEID']) ? (int) $data['@CHANGEID'] : null,
            'number' => isset($data['@NUMBER']) ? trim((string) $data['@NUMBER']) : null,
            'aparttype' => isset($data['@APARTTYPE']) ? (int) $data['@APARTTYPE'] : null,
            'opertypeid' => isset($data['@OPERTYPEID']) ? (int) $data['@OPERTYPEID'] : null,
            'previd' => isset($data['@PREVID']) ? (int) $data['@PREVID'] : null,
            'nextid' => isset($data['@NEXTID']) ? (int) $data['@NEXTID'] : null,
            'updatedate' => isset($data['@UPDATEDATE']) ? new \DateTimeImmutable((string) $data['@UPDATEDATE']) : null,
            'startdate' => isset($data['@STARTDATE']) ? new \DateTimeImmutable((string) $data['@STARTDATE']) : null,
            'enddate' => isset($data['@ENDDATE']) ? new \DateTimeImmutable((string) $data['@ENDDATE']) : null,
            'isactual' => isset($data['@ISACTUAL']) ? (int) $data['@ISACTUAL'] : null,
            'isactive' => isset($data['@ISACTIVE']) ? (int) $data['@ISACTIVE'] : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'AddrObjDivision'.
     */
    private function modelAddrObjDivisionDataExtractor(array $data): array
    {
        return [
            'id' => isset($data['@ID']) ? (int) $data['@ID'] : null,
            'parentid' => isset($data['@PARENTID']) ? (int) $data['@PARENTID'] : null,
            'childid' => isset($data['@CHILDID']) ? (int) $data['@CHILDID'] : null,
            'changeid' => isset($data['@CHANGEID']) ? (int) $data['@CHANGEID'] : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'NormativeDocsTypes'.
     */
    private function modelNormativeDocsTypesDataExtractor(array $data): array
    {
        return [
            'id' => isset($data['@ID']) ? (int) $data['@ID'] : null,
            'name' => isset($data['@NAME']) ? trim((string) $data['@NAME']) : null,
            'startdate' => isset($data['@STARTDATE']) ? new \DateTimeImmutable((string) $data['@STARTDATE']) : null,
            'enddate' => isset($data['@ENDDATE']) ? new \DateTimeImmutable((string) $data['@ENDDATE']) : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'RoomTypes'.
     */
    private function modelRoomTypesDataExtractor(array $data): array
    {
        return [
            'id' => isset($data['@ID']) ? (int) $data['@ID'] : null,
            'name' => isset($data['@NAME']) ? trim((string) $data['@NAME']) : null,
            'shortname' => isset($data['@SHORTNAME']) ? trim((string) $data['@SHORTNAME']) : null,
            'desc' => isset($data['@DESC']) ? trim((string) $data['@DESC']) : null,
            'updatedate' => isset($data['@UPDATEDATE']) ? new \DateTimeImmutable((string) $data['@UPDATEDATE']) : null,
            'startdate' => isset($data['@STARTDATE']) ? new \DateTimeImmutable((string) $data['@STARTDATE']) : null,
            'enddate' => isset($data['@ENDDATE']) ? new \DateTimeImmutable((string) $data['@ENDDATE']) : null,
            'isactive' => isset($data['@ISACTIVE']) ? trim((string) $data['@ISACTIVE']) : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'ObjectLevels'.
     */
    private function modelObjectLevelsDataExtractor(array $data): array
    {
        return [
            'level' => isset($data['@LEVEL']) ? (int) $data['@LEVEL'] : null,
            'name' => isset($data['@NAME']) ? trim((string) $data['@NAME']) : null,
            'shortname' => isset($data['@SHORTNAME']) ? trim((string) $data['@SHORTNAME']) : null,
            'updatedate' => isset($data['@UPDATEDATE']) ? new \DateTimeImmutable((string) $data['@UPDATEDATE']) : null,
            'startdate' => isset($data['@STARTDATE']) ? new \DateTimeImmutable((string) $data['@STARTDATE']) : null,
            'enddate' => isset($data['@ENDDATE']) ? new \DateTimeImmutable((string) $data['@ENDDATE']) : null,
            'isactive' => isset($data['@ISACTIVE']) ? trim((string) $data['@ISACTIVE']) : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'NormativeDocsKinds'.
     */
    private function modelNormativeDocsKindsDataExtractor(array $data): array
    {
        return [
            'id' => isset($data['@ID']) ? (int) $data['@ID'] : null,
            'name' => isset($data['@NAME']) ? trim((string) $data['@NAME']) : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'Rooms'.
     */
    private function modelRoomsDataExtractor(array $data): array
    {
        return [
            'id' => isset($data['@ID']) ? (int) $data['@ID'] : null,
            'objectid' => isset($data['@OBJECTID']) ? (int) $data['@OBJECTID'] : null,
            'objectguid' => isset($data['@OBJECTGUID']) ? trim((string) $data['@OBJECTGUID']) : null,
            'changeid' => isset($data['@CHANGEID']) ? (int) $data['@CHANGEID'] : null,
            'number' => isset($data['@NUMBER']) ? trim((string) $data['@NUMBER']) : null,
            'roomtype' => isset($data['@ROOMTYPE']) ? (int) $data['@ROOMTYPE'] : null,
            'opertypeid' => isset($data['@OPERTYPEID']) ? (int) $data['@OPERTYPEID'] : null,
            'previd' => isset($data['@PREVID']) ? (int) $data['@PREVID'] : null,
            'nextid' => isset($data['@NEXTID']) ? (int) $data['@NEXTID'] : null,
            'updatedate' => isset($data['@UPDATEDATE']) ? new \DateTimeImmutable((string) $data['@UPDATEDATE']) : null,
            'startdate' => isset($data['@STARTDATE']) ? new \DateTimeImmutable((string) $data['@STARTDATE']) : null,
            'enddate' => isset($data['@ENDDATE']) ? new \DateTimeImmutable((string) $data['@ENDDATE']) : null,
            'isactual' => isset($data['@ISACTUAL']) ? (int) $data['@ISACTUAL'] : null,
            'isactive' => isset($data['@ISACTIVE']) ? (int) $data['@ISACTIVE'] : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'ApartmentTypes'.
     */
    private function modelApartmentTypesDataExtractor(array $data): array
    {
        return [
            'id' => isset($data['@ID']) ? (int) $data['@ID'] : null,
            'name' => isset($data['@NAME']) ? trim((string) $data['@NAME']) : null,
            'shortname' => isset($data['@SHORTNAME']) ? trim((string) $data['@SHORTNAME']) : null,
            'desc' => isset($data['@DESC']) ? trim((string) $data['@DESC']) : null,
            'updatedate' => isset($data['@UPDATEDATE']) ? new \DateTimeImmutable((string) $data['@UPDATEDATE']) : null,
            'startdate' => isset($data['@STARTDATE']) ? new \DateTimeImmutable((string) $data['@STARTDATE']) : null,
            'enddate' => isset($data['@ENDDATE']) ? new \DateTimeImmutable((string) $data['@ENDDATE']) : null,
            'isactive' => isset($data['@ISACTIVE']) ? trim((string) $data['@ISACTIVE']) : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'AddrObjTypes'.
     */
    private function modelAddrObjTypesDataExtractor(array $data): array
    {
        return [
            'id' => isset($data['@ID']) ? (int) $data['@ID'] : null,
            'level' => isset($data['@LEVEL']) ? (int) $data['@LEVEL'] : null,
            'shortname' => isset($data['@SHORTNAME']) ? trim((string) $data['@SHORTNAME']) : null,
            'name' => isset($data['@NAME']) ? trim((string) $data['@NAME']) : null,
            'desc' => isset($data['@DESC']) ? trim((string) $data['@DESC']) : null,
            'updatedate' => isset($data['@UPDATEDATE']) ? new \DateTimeImmutable((string) $data['@UPDATEDATE']) : null,
            'startdate' => isset($data['@STARTDATE']) ? new \DateTimeImmutable((string) $data['@STARTDATE']) : null,
            'enddate' => isset($data['@ENDDATE']) ? new \DateTimeImmutable((string) $data['@ENDDATE']) : null,
            'isactive' => isset($data['@ISACTIVE']) ? trim((string) $data['@ISACTIVE']) : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'Steads'.
     */
    private function modelSteadsDataExtractor(array $data): array
    {
        return [
            'id' => isset($data['@ID']) ? (int) $data['@ID'] : null,
            'objectid' => isset($data['@OBJECTID']) ? (int) $data['@OBJECTID'] : null,
            'objectguid' => isset($data['@OBJECTGUID']) ? trim((string) $data['@OBJECTGUID']) : null,
            'changeid' => isset($data['@CHANGEID']) ? (int) $data['@CHANGEID'] : null,
            'number' => isset($data['@NUMBER']) ? trim((string) $data['@NUMBER']) : null,
            'opertypeid' => isset($data['@OPERTYPEID']) ? trim((string) $data['@OPERTYPEID']) : null,
            'previd' => isset($data['@PREVID']) ? (int) $data['@PREVID'] : null,
            'nextid' => isset($data['@NEXTID']) ? (int) $data['@NEXTID'] : null,
            'updatedate' => isset($data['@UPDATEDATE']) ? new \DateTimeImmutable((string) $data['@UPDATEDATE']) : null,
            'startdate' => isset($data['@STARTDATE']) ? new \DateTimeImmutable((string) $data['@STARTDATE']) : null,
            'enddate' => isset($data['@ENDDATE']) ? new \DateTimeImmutable((string) $data['@ENDDATE']) : null,
            'isactual' => isset($data['@ISACTUAL']) ? (int) $data['@ISACTUAL'] : null,
            'isactive' => isset($data['@ISACTIVE']) ? (int) $data['@ISACTIVE'] : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'NormativeDocs'.
     */
    private function modelNormativeDocsDataExtractor(array $data): array
    {
        return [
            'id' => isset($data['@ID']) ? (int) $data['@ID'] : null,
            'name' => isset($data['@NAME']) ? trim((string) $data['@NAME']) : null,
            'date' => isset($data['@DATE']) ? new \DateTimeImmutable((string) $data['@DATE']) : null,
            'number' => isset($data['@NUMBER']) ? trim((string) $data['@NUMBER']) : null,
            'type' => isset($data['@TYPE']) ? (int) $data['@TYPE'] : null,
            'kind' => isset($data['@KIND']) ? (int) $data['@KIND'] : null,
            'updatedate' => isset($data['@UPDATEDATE']) ? new \DateTimeImmutable((string) $data['@UPDATEDATE']) : null,
            'orgname' => isset($data['@ORGNAME']) ? trim((string) $data['@ORGNAME']) : null,
            'regnum' => isset($data['@REGNUM']) ? trim((string) $data['@REGNUM']) : null,
            'regdate' => isset($data['@REGDATE']) ? new \DateTimeImmutable((string) $data['@REGDATE']) : null,
            'accdate' => isset($data['@ACCDATE']) ? new \DateTimeImmutable((string) $data['@ACCDATE']) : null,
            'comment' => isset($data['@COMMENT']) ? trim((string) $data['@COMMENT']) : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'OperationTypes'.
     */
    private function modelOperationTypesDataExtractor(array $data): array
    {
        return [
            'id' => isset($data['@ID']) ? (int) $data['@ID'] : null,
            'name' => isset($data['@NAME']) ? trim((string) $data['@NAME']) : null,
            'shortname' => isset($data['@SHORTNAME']) ? trim((string) $data['@SHORTNAME']) : null,
            'desc' => isset($data['@DESC']) ? trim((string) $data['@DESC']) : null,
            'updatedate' => isset($data['@UPDATEDATE']) ? new \DateTimeImmutable((string) $data['@UPDATEDATE']) : null,
            'startdate' => isset($data['@STARTDATE']) ? new \DateTimeImmutable((string) $data['@STARTDATE']) : null,
            'enddate' => isset($data['@ENDDATE']) ? new \DateTimeImmutable((string) $data['@ENDDATE']) : null,
            'isactive' => isset($data['@ISACTIVE']) ? trim((string) $data['@ISACTIVE']) : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'Houses'.
     */
    private function modelHousesDataExtractor(array $data): array
    {
        return [
            'id' => isset($data['@ID']) ? (int) $data['@ID'] : null,
            'objectid' => isset($data['@OBJECTID']) ? (int) $data['@OBJECTID'] : null,
            'objectguid' => isset($data['@OBJECTGUID']) ? trim((string) $data['@OBJECTGUID']) : null,
            'changeid' => isset($data['@CHANGEID']) ? (int) $data['@CHANGEID'] : null,
            'housenum' => isset($data['@HOUSENUM']) ? trim((string) $data['@HOUSENUM']) : null,
            'addnum1' => isset($data['@ADDNUM1']) ? trim((string) $data['@ADDNUM1']) : null,
            'addnum2' => isset($data['@ADDNUM2']) ? trim((string) $data['@ADDNUM2']) : null,
            'housetype' => isset($data['@HOUSETYPE']) ? (int) $data['@HOUSETYPE'] : null,
            'addtype1' => isset($data['@ADDTYPE1']) ? (int) $data['@ADDTYPE1'] : null,
            'addtype2' => isset($data['@ADDTYPE2']) ? (int) $data['@ADDTYPE2'] : null,
            'opertypeid' => isset($data['@OPERTYPEID']) ? (int) $data['@OPERTYPEID'] : null,
            'previd' => isset($data['@PREVID']) ? (int) $data['@PREVID'] : null,
            'nextid' => isset($data['@NEXTID']) ? (int) $data['@NEXTID'] : null,
            'updatedate' => isset($data['@UPDATEDATE']) ? new \DateTimeImmutable((string) $data['@UPDATEDATE']) : null,
            'startdate' => isset($data['@STARTDATE']) ? new \DateTimeImmutable((string) $data['@STARTDATE']) : null,
            'enddate' => isset($data['@ENDDATE']) ? new \DateTimeImmutable((string) $data['@ENDDATE']) : null,
            'isactual' => isset($data['@ISACTUAL']) ? (int) $data['@ISACTUAL'] : null,
            'isactive' => isset($data['@ISACTIVE']) ? (int) $data['@ISACTIVE'] : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'AdmHierarchy'.
     */
    private function modelAdmHierarchyDataExtractor(array $data): array
    {
        return [
            'id' => isset($data['@ID']) ? (int) $data['@ID'] : null,
            'objectid' => isset($data['@OBJECTID']) ? (int) $data['@OBJECTID'] : null,
            'parentobjid' => isset($data['@PARENTOBJID']) ? (int) $data['@PARENTOBJID'] : null,
            'changeid' => isset($data['@CHANGEID']) ? (int) $data['@CHANGEID'] : null,
            'regioncode' => isset($data['@REGIONCODE']) ? trim((string) $data['@REGIONCODE']) : null,
            'areacode' => isset($data['@AREACODE']) ? trim((string) $data['@AREACODE']) : null,
            'citycode' => isset($data['@CITYCODE']) ? trim((string) $data['@CITYCODE']) : null,
            'placecode' => isset($data['@PLACECODE']) ? trim((string) $data['@PLACECODE']) : null,
            'plancode' => isset($data['@PLANCODE']) ? trim((string) $data['@PLANCODE']) : null,
            'streetcode' => isset($data['@STREETCODE']) ? trim((string) $data['@STREETCODE']) : null,
            'previd' => isset($data['@PREVID']) ? (int) $data['@PREVID'] : null,
            'nextid' => isset($data['@NEXTID']) ? (int) $data['@NEXTID'] : null,
            'updatedate' => isset($data['@UPDATEDATE']) ? new \DateTimeImmutable((string) $data['@UPDATEDATE']) : null,
            'startdate' => isset($data['@STARTDATE']) ? new \DateTimeImmutable((string) $data['@STARTDATE']) : null,
            'enddate' => isset($data['@ENDDATE']) ? new \DateTimeImmutable((string) $data['@ENDDATE']) : null,
            'isactive' => isset($data['@ISACTIVE']) ? (int) $data['@ISACTIVE'] : null,
            'path' => isset($data['@PATH']) ? trim((string) $data['@PATH']) : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'Carplaces'.
     */
    private function modelCarplacesDataExtractor(array $data): array
    {
        return [
            'id' => isset($data['@ID']) ? (int) $data['@ID'] : null,
            'objectid' => isset($data['@OBJECTID']) ? (int) $data['@OBJECTID'] : null,
            'objectguid' => isset($data['@OBJECTGUID']) ? trim((string) $data['@OBJECTGUID']) : null,
            'changeid' => isset($data['@CHANGEID']) ? (int) $data['@CHANGEID'] : null,
            'number' => isset($data['@NUMBER']) ? trim((string) $data['@NUMBER']) : null,
            'opertypeid' => isset($data['@OPERTYPEID']) ? (int) $data['@OPERTYPEID'] : null,
            'previd' => isset($data['@PREVID']) ? (int) $data['@PREVID'] : null,
            'nextid' => isset($data['@NEXTID']) ? (int) $data['@NEXTID'] : null,
            'updatedate' => isset($data['@UPDATEDATE']) ? new \DateTimeImmutable((string) $data['@UPDATEDATE']) : null,
            'startdate' => isset($data['@STARTDATE']) ? new \DateTimeImmutable((string) $data['@STARTDATE']) : null,
            'enddate' => isset($data['@ENDDATE']) ? new \DateTimeImmutable((string) $data['@ENDDATE']) : null,
            'isactual' => isset($data['@ISACTUAL']) ? (int) $data['@ISACTUAL'] : null,
            'isactive' => isset($data['@ISACTIVE']) ? (int) $data['@ISACTIVE'] : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'ChangeHistory'.
     */
    private function modelChangeHistoryDataExtractor(array $data): array
    {
        return [
            'changeid' => isset($data['@CHANGEID']) ? (int) $data['@CHANGEID'] : null,
            'objectid' => isset($data['@OBJECTID']) ? (int) $data['@OBJECTID'] : null,
            'adrobjectid' => isset($data['@ADROBJECTID']) ? trim((string) $data['@ADROBJECTID']) : null,
            'opertypeid' => isset($data['@OPERTYPEID']) ? (int) $data['@OPERTYPEID'] : null,
            'ndocid' => isset($data['@NDOCID']) ? (int) $data['@NDOCID'] : null,
            'changedate' => isset($data['@CHANGEDATE']) ? new \DateTimeImmutable((string) $data['@CHANGEDATE']) : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'AddrObj'.
     */
    private function modelAddrObjDataExtractor(array $data): array
    {
        return [
            'id' => isset($data['@ID']) ? (int) $data['@ID'] : null,
            'objectid' => isset($data['@OBJECTID']) ? (int) $data['@OBJECTID'] : null,
            'objectguid' => isset($data['@OBJECTGUID']) ? trim((string) $data['@OBJECTGUID']) : null,
            'changeid' => isset($data['@CHANGEID']) ? (int) $data['@CHANGEID'] : null,
            'name' => isset($data['@NAME']) ? trim((string) $data['@NAME']) : null,
            'typename' => isset($data['@TYPENAME']) ? trim((string) $data['@TYPENAME']) : null,
            'level' => isset($data['@LEVEL']) ? trim((string) $data['@LEVEL']) : null,
            'opertypeid' => isset($data['@OPERTYPEID']) ? (int) $data['@OPERTYPEID'] : null,
            'previd' => isset($data['@PREVID']) ? (int) $data['@PREVID'] : null,
            'nextid' => isset($data['@NEXTID']) ? (int) $data['@NEXTID'] : null,
            'updatedate' => isset($data['@UPDATEDATE']) ? new \DateTimeImmutable((string) $data['@UPDATEDATE']) : null,
            'startdate' => isset($data['@STARTDATE']) ? new \DateTimeImmutable((string) $data['@STARTDATE']) : null,
            'enddate' => isset($data['@ENDDATE']) ? new \DateTimeImmutable((string) $data['@ENDDATE']) : null,
            'isactual' => isset($data['@ISACTUAL']) ? (int) $data['@ISACTUAL'] : null,
            'isactive' => isset($data['@ISACTIVE']) ? (int) $data['@ISACTIVE'] : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'ParamTypes'.
     */
    private function modelParamTypesDataExtractor(array $data): array
    {
        return [
            'id' => isset($data['@ID']) ? (int) $data['@ID'] : null,
            'name' => isset($data['@NAME']) ? trim((string) $data['@NAME']) : null,
            'code' => isset($data['@CODE']) ? trim((string) $data['@CODE']) : null,
            'desc' => isset($data['@DESC']) ? trim((string) $data['@DESC']) : null,
            'updatedate' => isset($data['@UPDATEDATE']) ? new \DateTimeImmutable((string) $data['@UPDATEDATE']) : null,
            'startdate' => isset($data['@STARTDATE']) ? new \DateTimeImmutable((string) $data['@STARTDATE']) : null,
            'enddate' => isset($data['@ENDDATE']) ? new \DateTimeImmutable((string) $data['@ENDDATE']) : null,
            'isactive' => isset($data['@ISACTIVE']) ? trim((string) $data['@ISACTIVE']) : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'Param'.
     */
    private function modelParamDataExtractor(array $data): array
    {
        return [
            'id' => isset($data['@ID']) ? (int) $data['@ID'] : null,
            'objectid' => isset($data['@OBJECTID']) ? (int) $data['@OBJECTID'] : null,
            'changeid' => isset($data['@CHANGEID']) ? (int) $data['@CHANGEID'] : null,
            'changeidend' => isset($data['@CHANGEIDEND']) ? (int) $data['@CHANGEIDEND'] : null,
            'typeid' => isset($data['@TYPEID']) ? (int) $data['@TYPEID'] : null,
            'value' => isset($data['@VALUE']) ? trim((string) $data['@VALUE']) : null,
            'updatedate' => isset($data['@UPDATEDATE']) ? new \DateTimeImmutable((string) $data['@UPDATEDATE']) : null,
            'startdate' => isset($data['@STARTDATE']) ? new \DateTimeImmutable((string) $data['@STARTDATE']) : null,
            'enddate' => isset($data['@ENDDATE']) ? new \DateTimeImmutable((string) $data['@ENDDATE']) : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'ReestrObjects'.
     */
    private function modelReestrObjectsDataExtractor(array $data): array
    {
        return [
            'objectid' => isset($data['@OBJECTID']) ? (int) $data['@OBJECTID'] : null,
            'createdate' => isset($data['@CREATEDATE']) ? new \DateTimeImmutable((string) $data['@CREATEDATE']) : null,
            'changeid' => isset($data['@CHANGEID']) ? (int) $data['@CHANGEID'] : null,
            'levelid' => isset($data['@LEVELID']) ? (int) $data['@LEVELID'] : null,
            'updatedate' => isset($data['@UPDATEDATE']) ? new \DateTimeImmutable((string) $data['@UPDATEDATE']) : null,
            'objectguid' => isset($data['@OBJECTGUID']) ? trim((string) $data['@OBJECTGUID']) : null,
            'isactive' => isset($data['@ISACTIVE']) ? (int) $data['@ISACTIVE'] : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'HouseTypes'.
     */
    private function modelHouseTypesDataExtractor(array $data): array
    {
        return [
            'id' => isset($data['@ID']) ? (int) $data['@ID'] : null,
            'name' => isset($data['@NAME']) ? trim((string) $data['@NAME']) : null,
            'shortname' => isset($data['@SHORTNAME']) ? trim((string) $data['@SHORTNAME']) : null,
            'desc' => isset($data['@DESC']) ? trim((string) $data['@DESC']) : null,
            'updatedate' => isset($data['@UPDATEDATE']) ? new \DateTimeImmutable((string) $data['@UPDATEDATE']) : null,
            'startdate' => isset($data['@STARTDATE']) ? new \DateTimeImmutable((string) $data['@STARTDATE']) : null,
            'enddate' => isset($data['@ENDDATE']) ? new \DateTimeImmutable((string) $data['@ENDDATE']) : null,
            'isactive' => isset($data['@ISACTIVE']) ? trim((string) $data['@ISACTIVE']) : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'MunHierarchy'.
     */
    private function modelMunHierarchyDataExtractor(array $data): array
    {
        return [
            'id' => isset($data['@ID']) ? (int) $data['@ID'] : null,
            'objectid' => isset($data['@OBJECTID']) ? (int) $data['@OBJECTID'] : null,
            'parentobjid' => isset($data['@PARENTOBJID']) ? (int) $data['@PARENTOBJID'] : null,
            'changeid' => isset($data['@CHANGEID']) ? (int) $data['@CHANGEID'] : null,
            'oktmo' => isset($data['@OKTMO']) ? trim((string) $data['@OKTMO']) : null,
            'previd' => isset($data['@PREVID']) ? (int) $data['@PREVID'] : null,
            'nextid' => isset($data['@NEXTID']) ? (int) $data['@NEXTID'] : null,
            'updatedate' => isset($data['@UPDATEDATE']) ? new \DateTimeImmutable((string) $data['@UPDATEDATE']) : null,
            'startdate' => isset($data['@STARTDATE']) ? new \DateTimeImmutable((string) $data['@STARTDATE']) : null,
            'enddate' => isset($data['@ENDDATE']) ? new \DateTimeImmutable((string) $data['@ENDDATE']) : null,
            'isactive' => isset($data['@ISACTIVE']) ? (int) $data['@ISACTIVE'] : null,
            'path' => isset($data['@PATH']) ? trim((string) $data['@PATH']) : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'FiasVersion'.
     */
    private function modelFiasVersionDataExtractor(array $data): array
    {
        return [
            'version' => isset($data['@VERSION']) ? (int) $data['@VERSION'] : null,
            'fullurl' => isset($data['@FULLURL']) ? trim((string) $data['@FULLURL']) : null,
            'deltaurl' => isset($data['@DELTAURL']) ? trim((string) $data['@DELTAURL']) : null,
            'created_at' => isset($data['@CREATED_AT']) ? new \DateTimeImmutable((string) $data['@CREATED_AT']) : null,
        ];
    }
}
