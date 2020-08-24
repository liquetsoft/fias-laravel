<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Serializer;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\ActualStatus;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\AddressObject;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\AddressObjectType;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\CenterStatus;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\CurrentStatus;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\EstateStatus;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\FiasVersion;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\FlatType;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\House;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\NormativeDocument;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\NormativeDocumentType;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\OperationStatus;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\Room;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\RoomType;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\Stead;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Entity\StructureStatus;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * Скомпилированный класс для денормализации сущностей ФИАС в модели eloquent.
 */
class CompiledEntitesDenormalizer implements DenormalizerInterface
{
    private const ALLOWED_ENTITIES = [
        FlatType::class,
        ActualStatus::class,
        OperationStatus::class,
        Room::class,
        AddressObjectType::class,
        RoomType::class,
        Stead::class,
        CenterStatus::class,
        NormativeDocument::class,
        CurrentStatus::class,
        NormativeDocumentType::class,
        EstateStatus::class,
        AddressObject::class,
        House::class,
        StructureStatus::class,
        FiasVersion::class,
    ];

    /**
     * @inheritDoc
     */
    public function supportsDenormalization($data, string $type, string $format = null)
    {
        return in_array(trim($type, " \t\n\r\0\x0B\\/"), self::ALLOWED_ENTITIES);
    }

    /**
     * {@inheritDoc}
     *
     * @psalm-suppress InvalidStringClass
     */
    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        $data = is_array($data) ? $data : [];
        $type = trim($type, " \t\n\r\0\x0B\\/");

        $entity = $context[AbstractNormalizer::OBJECT_TO_POPULATE] ?? new $type();

        if (!($entity instanceof Model)) {
            $message = sprintf("Bad class for populating entity, need '%s' instance.", Model::class);
            throw new InvalidArgumentException($message);
        }

        switch ($type) {
            case FlatType::class:
                $extractedData = $this->modelFlatTypeDataExtractor($data);
                break;
            case ActualStatus::class:
                $extractedData = $this->modelActualStatusDataExtractor($data);
                break;
            case OperationStatus::class:
                $extractedData = $this->modelOperationStatusDataExtractor($data);
                break;
            case Room::class:
                $extractedData = $this->modelRoomDataExtractor($data);
                break;
            case AddressObjectType::class:
                $extractedData = $this->modelAddressObjectTypeDataExtractor($data);
                break;
            case RoomType::class:
                $extractedData = $this->modelRoomTypeDataExtractor($data);
                break;
            case Stead::class:
                $extractedData = $this->modelSteadDataExtractor($data);
                break;
            case CenterStatus::class:
                $extractedData = $this->modelCenterStatusDataExtractor($data);
                break;
            case NormativeDocument::class:
                $extractedData = $this->modelNormativeDocumentDataExtractor($data);
                break;
            case CurrentStatus::class:
                $extractedData = $this->modelCurrentStatusDataExtractor($data);
                break;
            case NormativeDocumentType::class:
                $extractedData = $this->modelNormativeDocumentTypeDataExtractor($data);
                break;
            case EstateStatus::class:
                $extractedData = $this->modelEstateStatusDataExtractor($data);
                break;
            case AddressObject::class:
                $extractedData = $this->modelAddressObjectDataExtractor($data);
                break;
            case House::class:
                $extractedData = $this->modelHouseDataExtractor($data);
                break;
            case StructureStatus::class:
                $extractedData = $this->modelStructureStatusDataExtractor($data);
                break;
            case FiasVersion::class:
                $extractedData = $this->modelFiasVersionDataExtractor($data);
                break;
            default:
                $message = sprintf("Can't find data extractor for '%s' type.", $type);
                throw new InvalidArgumentException($message);
                break;
        }

        $entity->fill($extractedData);

        return $entity;
    }

    /**
     * Получает правильный массив данных для модели 'FlatType'.
     *
     * @param array $data
     *
     * @return array
     */
    private function modelFlatTypeDataExtractor(array $data): array
    {
        return [
            'fltypeid' => isset($data['@FLTYPEID']) ? (int) $data['@FLTYPEID'] : null,
            'name' => isset($data['@NAME']) ? trim($data['@NAME']) : null,
            'shortname' => isset($data['@SHORTNAME']) ? trim($data['@SHORTNAME']) : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'ActualStatus'.
     *
     * @param array $data
     *
     * @return array
     */
    private function modelActualStatusDataExtractor(array $data): array
    {
        return [
            'actstatid' => isset($data['@ACTSTATID']) ? (int) $data['@ACTSTATID'] : null,
            'name' => isset($data['@NAME']) ? trim($data['@NAME']) : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'OperationStatus'.
     *
     * @param array $data
     *
     * @return array
     */
    private function modelOperationStatusDataExtractor(array $data): array
    {
        return [
            'operstatid' => isset($data['@OPERSTATID']) ? (int) $data['@OPERSTATID'] : null,
            'name' => isset($data['@NAME']) ? trim($data['@NAME']) : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'Room'.
     *
     * @param array $data
     *
     * @return array
     */
    private function modelRoomDataExtractor(array $data): array
    {
        return [
            'roomid' => isset($data['@ROOMID']) ? trim($data['@ROOMID']) : null,
            'roomguid' => isset($data['@ROOMGUID']) ? trim($data['@ROOMGUID']) : null,
            'houseguid' => isset($data['@HOUSEGUID']) ? trim($data['@HOUSEGUID']) : null,
            'regioncode' => isset($data['@REGIONCODE']) ? trim($data['@REGIONCODE']) : null,
            'flatnumber' => isset($data['@FLATNUMBER']) ? trim($data['@FLATNUMBER']) : null,
            'flattype' => isset($data['@FLATTYPE']) ? (int) $data['@FLATTYPE'] : null,
            'postalcode' => isset($data['@POSTALCODE']) ? trim($data['@POSTALCODE']) : null,
            'startdate' => isset($data['@STARTDATE']) ? Carbon::parse(trim($data['@STARTDATE'])) : null,
            'enddate' => isset($data['@ENDDATE']) ? Carbon::parse(trim($data['@ENDDATE'])) : null,
            'updatedate' => isset($data['@UPDATEDATE']) ? Carbon::parse(trim($data['@UPDATEDATE'])) : null,
            'operstatus' => isset($data['@OPERSTATUS']) ? (int) $data['@OPERSTATUS'] : null,
            'livestatus' => isset($data['@LIVESTATUS']) ? (int) $data['@LIVESTATUS'] : null,
            'normdoc' => isset($data['@NORMDOC']) ? trim($data['@NORMDOC']) : null,
            'roomnumber' => isset($data['@ROOMNUMBER']) ? trim($data['@ROOMNUMBER']) : null,
            'roomtype' => isset($data['@ROOMTYPE']) ? (int) $data['@ROOMTYPE'] : null,
            'previd' => isset($data['@PREVID']) ? trim($data['@PREVID']) : null,
            'nextid' => isset($data['@NEXTID']) ? trim($data['@NEXTID']) : null,
            'cadnum' => isset($data['@CADNUM']) ? trim($data['@CADNUM']) : null,
            'roomcadnum' => isset($data['@ROOMCADNUM']) ? trim($data['@ROOMCADNUM']) : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'AddressObjectType'.
     *
     * @param array $data
     *
     * @return array
     */
    private function modelAddressObjectTypeDataExtractor(array $data): array
    {
        return [
            'kod_t_st' => isset($data['@KOD_T_ST']) ? trim($data['@KOD_T_ST']) : null,
            'level' => isset($data['@LEVEL']) ? (int) $data['@LEVEL'] : null,
            'socrname' => isset($data['@SOCRNAME']) ? trim($data['@SOCRNAME']) : null,
            'scname' => isset($data['@SCNAME']) ? trim($data['@SCNAME']) : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'RoomType'.
     *
     * @param array $data
     *
     * @return array
     */
    private function modelRoomTypeDataExtractor(array $data): array
    {
        return [
            'rmtypeid' => isset($data['@RMTYPEID']) ? (int) $data['@RMTYPEID'] : null,
            'name' => isset($data['@NAME']) ? trim($data['@NAME']) : null,
            'shortname' => isset($data['@SHORTNAME']) ? trim($data['@SHORTNAME']) : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'Stead'.
     *
     * @param array $data
     *
     * @return array
     */
    private function modelSteadDataExtractor(array $data): array
    {
        return [
            'steadguid' => isset($data['@STEADGUID']) ? trim($data['@STEADGUID']) : null,
            'number' => isset($data['@NUMBER']) ? trim($data['@NUMBER']) : null,
            'regioncode' => isset($data['@REGIONCODE']) ? trim($data['@REGIONCODE']) : null,
            'postalcode' => isset($data['@POSTALCODE']) ? trim($data['@POSTALCODE']) : null,
            'ifnsfl' => isset($data['@IFNSFL']) ? trim($data['@IFNSFL']) : null,
            'ifnsul' => isset($data['@IFNSUL']) ? trim($data['@IFNSUL']) : null,
            'okato' => isset($data['@OKATO']) ? trim($data['@OKATO']) : null,
            'oktmo' => isset($data['@OKTMO']) ? trim($data['@OKTMO']) : null,
            'parentguid' => isset($data['@PARENTGUID']) ? trim($data['@PARENTGUID']) : null,
            'steadid' => isset($data['@STEADID']) ? trim($data['@STEADID']) : null,
            'operstatus' => isset($data['@OPERSTATUS']) ? (int) $data['@OPERSTATUS'] : null,
            'startdate' => isset($data['@STARTDATE']) ? Carbon::parse(trim($data['@STARTDATE'])) : null,
            'enddate' => isset($data['@ENDDATE']) ? Carbon::parse(trim($data['@ENDDATE'])) : null,
            'updatedate' => isset($data['@UPDATEDATE']) ? Carbon::parse(trim($data['@UPDATEDATE'])) : null,
            'livestatus' => isset($data['@LIVESTATUS']) ? (int) $data['@LIVESTATUS'] : null,
            'divtype' => isset($data['@DIVTYPE']) ? (int) $data['@DIVTYPE'] : null,
            'normdoc' => isset($data['@NORMDOC']) ? trim($data['@NORMDOC']) : null,
            'terrifnsfl' => isset($data['@TERRIFNSFL']) ? trim($data['@TERRIFNSFL']) : null,
            'terrifnsul' => isset($data['@TERRIFNSUL']) ? trim($data['@TERRIFNSUL']) : null,
            'previd' => isset($data['@PREVID']) ? trim($data['@PREVID']) : null,
            'nextid' => isset($data['@NEXTID']) ? trim($data['@NEXTID']) : null,
            'cadnum' => isset($data['@CADNUM']) ? trim($data['@CADNUM']) : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'CenterStatus'.
     *
     * @param array $data
     *
     * @return array
     */
    private function modelCenterStatusDataExtractor(array $data): array
    {
        return [
            'centerstid' => isset($data['@CENTERSTID']) ? (int) $data['@CENTERSTID'] : null,
            'name' => isset($data['@NAME']) ? trim($data['@NAME']) : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'NormativeDocument'.
     *
     * @param array $data
     *
     * @return array
     */
    private function modelNormativeDocumentDataExtractor(array $data): array
    {
        return [
            'normdocid' => isset($data['@NORMDOCID']) ? trim($data['@NORMDOCID']) : null,
            'docname' => isset($data['@DOCNAME']) ? trim($data['@DOCNAME']) : null,
            'docdate' => isset($data['@DOCDATE']) ? Carbon::parse(trim($data['@DOCDATE'])) : null,
            'docnum' => isset($data['@DOCNUM']) ? trim($data['@DOCNUM']) : null,
            'doctype' => isset($data['@DOCTYPE']) ? (int) $data['@DOCTYPE'] : null,
            'docimgid' => isset($data['@DOCIMGID']) ? trim($data['@DOCIMGID']) : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'CurrentStatus'.
     *
     * @param array $data
     *
     * @return array
     */
    private function modelCurrentStatusDataExtractor(array $data): array
    {
        return [
            'curentstid' => isset($data['@CURENTSTID']) ? (int) $data['@CURENTSTID'] : null,
            'name' => isset($data['@NAME']) ? trim($data['@NAME']) : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'NormativeDocumentType'.
     *
     * @param array $data
     *
     * @return array
     */
    private function modelNormativeDocumentTypeDataExtractor(array $data): array
    {
        return [
            'ndtypeid' => isset($data['@NDTYPEID']) ? (int) $data['@NDTYPEID'] : null,
            'name' => isset($data['@NAME']) ? trim($data['@NAME']) : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'EstateStatus'.
     *
     * @param array $data
     *
     * @return array
     */
    private function modelEstateStatusDataExtractor(array $data): array
    {
        return [
            'eststatid' => isset($data['@ESTSTATID']) ? (int) $data['@ESTSTATID'] : null,
            'name' => isset($data['@NAME']) ? trim($data['@NAME']) : null,
            'shortname' => isset($data['@SHORTNAME']) ? trim($data['@SHORTNAME']) : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'AddressObject'.
     *
     * @param array $data
     *
     * @return array
     */
    private function modelAddressObjectDataExtractor(array $data): array
    {
        return [
            'aoid' => isset($data['@AOID']) ? trim($data['@AOID']) : null,
            'aoguid' => isset($data['@AOGUID']) ? trim($data['@AOGUID']) : null,
            'parentguid' => isset($data['@PARENTGUID']) ? trim($data['@PARENTGUID']) : null,
            'previd' => isset($data['@PREVID']) ? trim($data['@PREVID']) : null,
            'nextid' => isset($data['@NEXTID']) ? trim($data['@NEXTID']) : null,
            'code' => isset($data['@CODE']) ? trim($data['@CODE']) : null,
            'formalname' => isset($data['@FORMALNAME']) ? trim($data['@FORMALNAME']) : null,
            'offname' => isset($data['@OFFNAME']) ? trim($data['@OFFNAME']) : null,
            'shortname' => isset($data['@SHORTNAME']) ? trim($data['@SHORTNAME']) : null,
            'aolevel' => isset($data['@AOLEVEL']) ? (int) $data['@AOLEVEL'] : null,
            'regioncode' => isset($data['@REGIONCODE']) ? trim($data['@REGIONCODE']) : null,
            'areacode' => isset($data['@AREACODE']) ? trim($data['@AREACODE']) : null,
            'autocode' => isset($data['@AUTOCODE']) ? trim($data['@AUTOCODE']) : null,
            'citycode' => isset($data['@CITYCODE']) ? trim($data['@CITYCODE']) : null,
            'ctarcode' => isset($data['@CTARCODE']) ? trim($data['@CTARCODE']) : null,
            'placecode' => isset($data['@PLACECODE']) ? trim($data['@PLACECODE']) : null,
            'plancode' => isset($data['@PLANCODE']) ? trim($data['@PLANCODE']) : null,
            'streetcode' => isset($data['@STREETCODE']) ? trim($data['@STREETCODE']) : null,
            'extrcode' => isset($data['@EXTRCODE']) ? trim($data['@EXTRCODE']) : null,
            'sextcode' => isset($data['@SEXTCODE']) ? trim($data['@SEXTCODE']) : null,
            'plaincode' => isset($data['@PLAINCODE']) ? trim($data['@PLAINCODE']) : null,
            'currstatus' => isset($data['@CURRSTATUS']) ? (int) $data['@CURRSTATUS'] : null,
            'actstatus' => isset($data['@ACTSTATUS']) ? (int) $data['@ACTSTATUS'] : null,
            'livestatus' => isset($data['@LIVESTATUS']) ? (int) $data['@LIVESTATUS'] : null,
            'centstatus' => isset($data['@CENTSTATUS']) ? (int) $data['@CENTSTATUS'] : null,
            'operstatus' => isset($data['@OPERSTATUS']) ? (int) $data['@OPERSTATUS'] : null,
            'ifnsfl' => isset($data['@IFNSFL']) ? trim($data['@IFNSFL']) : null,
            'ifnsul' => isset($data['@IFNSUL']) ? trim($data['@IFNSUL']) : null,
            'terrifnsfl' => isset($data['@TERRIFNSFL']) ? trim($data['@TERRIFNSFL']) : null,
            'terrifnsul' => isset($data['@TERRIFNSUL']) ? trim($data['@TERRIFNSUL']) : null,
            'okato' => isset($data['@OKATO']) ? trim($data['@OKATO']) : null,
            'oktmo' => isset($data['@OKTMO']) ? trim($data['@OKTMO']) : null,
            'postalcode' => isset($data['@POSTALCODE']) ? trim($data['@POSTALCODE']) : null,
            'startdate' => isset($data['@STARTDATE']) ? Carbon::parse(trim($data['@STARTDATE'])) : null,
            'enddate' => isset($data['@ENDDATE']) ? Carbon::parse(trim($data['@ENDDATE'])) : null,
            'updatedate' => isset($data['@UPDATEDATE']) ? Carbon::parse(trim($data['@UPDATEDATE'])) : null,
            'divtype' => isset($data['@DIVTYPE']) ? (int) $data['@DIVTYPE'] : null,
            'normdoc' => isset($data['@NORMDOC']) ? trim($data['@NORMDOC']) : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'House'.
     *
     * @param array $data
     *
     * @return array
     */
    private function modelHouseDataExtractor(array $data): array
    {
        return [
            'houseid' => isset($data['@HOUSEID']) ? trim($data['@HOUSEID']) : null,
            'houseguid' => isset($data['@HOUSEGUID']) ? trim($data['@HOUSEGUID']) : null,
            'aoguid' => isset($data['@AOGUID']) ? trim($data['@AOGUID']) : null,
            'housenum' => isset($data['@HOUSENUM']) ? trim($data['@HOUSENUM']) : null,
            'strstatus' => isset($data['@STRSTATUS']) ? (int) $data['@STRSTATUS'] : null,
            'eststatus' => isset($data['@ESTSTATUS']) ? (int) $data['@ESTSTATUS'] : null,
            'statstatus' => isset($data['@STATSTATUS']) ? (int) $data['@STATSTATUS'] : null,
            'ifnsfl' => isset($data['@IFNSFL']) ? trim($data['@IFNSFL']) : null,
            'ifnsul' => isset($data['@IFNSUL']) ? trim($data['@IFNSUL']) : null,
            'okato' => isset($data['@OKATO']) ? trim($data['@OKATO']) : null,
            'oktmo' => isset($data['@OKTMO']) ? trim($data['@OKTMO']) : null,
            'postalcode' => isset($data['@POSTALCODE']) ? trim($data['@POSTALCODE']) : null,
            'startdate' => isset($data['@STARTDATE']) ? Carbon::parse(trim($data['@STARTDATE'])) : null,
            'enddate' => isset($data['@ENDDATE']) ? Carbon::parse(trim($data['@ENDDATE'])) : null,
            'updatedate' => isset($data['@UPDATEDATE']) ? Carbon::parse(trim($data['@UPDATEDATE'])) : null,
            'counter' => isset($data['@COUNTER']) ? (int) $data['@COUNTER'] : null,
            'divtype' => isset($data['@DIVTYPE']) ? (int) $data['@DIVTYPE'] : null,
            'regioncode' => isset($data['@REGIONCODE']) ? trim($data['@REGIONCODE']) : null,
            'terrifnsfl' => isset($data['@TERRIFNSFL']) ? trim($data['@TERRIFNSFL']) : null,
            'terrifnsul' => isset($data['@TERRIFNSUL']) ? trim($data['@TERRIFNSUL']) : null,
            'buildnum' => isset($data['@BUILDNUM']) ? trim($data['@BUILDNUM']) : null,
            'strucnum' => isset($data['@STRUCNUM']) ? trim($data['@STRUCNUM']) : null,
            'normdoc' => isset($data['@NORMDOC']) ? trim($data['@NORMDOC']) : null,
            'cadnum' => isset($data['@CADNUM']) ? trim($data['@CADNUM']) : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'StructureStatus'.
     *
     * @param array $data
     *
     * @return array
     */
    private function modelStructureStatusDataExtractor(array $data): array
    {
        return [
            'strstatid' => isset($data['@STRSTATID']) ? (int) $data['@STRSTATID'] : null,
            'name' => isset($data['@NAME']) ? trim($data['@NAME']) : null,
            'shortname' => isset($data['@SHORTNAME']) ? trim($data['@SHORTNAME']) : null,
        ];
    }

    /**
     * Получает правильный массив данных для модели 'FiasVersion'.
     *
     * @param array $data
     *
     * @return array
     */
    private function modelFiasVersionDataExtractor(array $data): array
    {
        return [
            'version' => isset($data['@VERSION']) ? (int) $data['@VERSION'] : null,
            'url' => isset($data['@URL']) ? trim($data['@URL']) : null,
            'created_at' => isset($data['@CREATED_AT']) ? Carbon::parse(trim($data['@CREATED_AT'])) : null,
        ];
    }
}
