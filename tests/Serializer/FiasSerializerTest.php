<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\Serializer;

use Illuminate\Support\Carbon;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Serializer\FiasSerializer;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\BaseCase;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\MockModel\FiasSerializerMock;
use Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests\MockModel\FiasSerializerMockJson;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;

/**
 * Тест для проверки совместимости сериализатора и моделей eloquent.
 *
 * @internal
 */
final class FiasSerializerTest extends BaseCase
{
    /**
     * Проверяет, что xml верно конвертируется в модель.
     */
    public function testDeserialize(): void
    {
        $data = <<<EOT
<ActualStatus
    actstatid="10"
    NAME="test"
    fLoatNum="10.1"
    bool_val="1"
    testDateVal="10.10.2019 10:10:10"
    timestamp="10101010"
    defaultItem="defaultItem"
    />
EOT;
        $type = FiasSerializerMock::class;

        $serializer = new FiasSerializer();
        $model = $serializer->deserialize($data, $type, 'xml');

        $this->assertInstanceOf($type, $model);
        $this->assertSame(10, $model->ACTSTATID);
        $this->assertSame('test', $model->name);
        $this->assertSame(10.1, $model->floatNum);
        $this->assertTrue($model->boolVal);
        $this->assertInstanceOf(Carbon::class, $model->test_date_val);
        $this->assertSame('2019-10-10 10:10', $model->test_date_val->format('Y-m-d H:i'));
        $this->assertSame(10101010, $model->timestamp);
        $this->assertSame('defaultItem', $model->defaultItem);
        $this->assertNull($model->nullableCast);
    }

    /**
     * Проверяет, что json верно конвертируется в модель.
     */
    public function testDeserializeJson(): void
    {
        $data = json_encode(
            [
                'id' => '10',
                'name' => 'test',
                'floatNum' => '10.1',
                'date' => '10.10.2019 10:10:10',
            ]
        );

        $type = FiasSerializerMockJson::class;

        $serializer = new FiasSerializer();
        $model = $serializer->deserialize($data, $type, 'json');

        $this->assertInstanceOf($type, $model);
        $this->assertSame(10, $model->id);
        $this->assertSame('test', $model->name);
        $this->assertSame(10.1, $model->floatNum);
        $this->assertSame('2019-10-10 10:10', $model->date?->format('Y-m-d H:i'));
    }

    /**
     * Проверяет, что xml верно конвертируется в указанный объект.
     */
    public function testDeserializeToObject(): void
    {
        $data = <<<EOT
<ActualStatus
    actstatid="10"
    NAME="test"
    fLoatNum="10.1"
    bool_val="1"
    testDateVal="10.10.2019 10:10:10"
    timestamp="10101010"
    defaultItem="defaultItem"
    />
EOT;

        $serializer = new FiasSerializer();
        $objectToPopulate = new FiasSerializerMock();
        $model = $serializer->deserialize(
            $data,
            FiasSerializerMock::class,
            'xml',
            [
                'object_to_populate' => $objectToPopulate,
            ]
        );

        $this->assertSame($objectToPopulate, $model);
        $this->assertSame(10, $model->ACTSTATID);
        $this->assertSame('test', $model->name);
        $this->assertSame(10.1, $model->floatNum);
        $this->assertTrue($model->boolVal);
        $this->assertInstanceOf(Carbon::class, $model->test_date_val);
        $this->assertSame('2019-10-10 10:10', $model->test_date_val->format('Y-m-d H:i'));
        $this->assertSame(10101010, $model->timestamp);
        $this->assertSame('defaultItem', $model->defaultItem);
        $this->assertNull($model->nullableCast);
    }

    /**
     * Проверяет, что объект перехватит исключение в процессе приведения типов.
     */
    public function testDeserializeConvertException(): void
    {
        $data = '<ActualStatus testDateVal="test"/>';
        $type = FiasSerializerMock::class;

        $serializer = new FiasSerializer();

        $this->expectException(NotNormalizableValueException::class);
        $serializer->deserialize($data, $type, 'xml');
    }

    /**
     * Проверяет, что объект выбросит исключение, если указан неверный объект для наполнения.
     */
    public function testDeserializeWrongObjectToPopulate(): void
    {
        $data = '<ActualStatus defaultItem="test"/>';
        $type = FiasSerializerMock::class;

        $serializer = new FiasSerializer();

        $this->expectException(InvalidArgumentException::class);
        $serializer->deserialize(
            $data,
            $type,
            'xml',
            [
                'object_to_populate' => new \stdClass(),
            ]
        );
    }
}
