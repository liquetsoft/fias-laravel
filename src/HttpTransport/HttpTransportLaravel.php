<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\HttpTransport;

use Illuminate\Http\Client\Response as LaravelResponse;
use Illuminate\Support\Facades\Http;
use Liquetsoft\Fias\Component\Exception\HttpTransportException;
use Liquetsoft\Fias\Component\HttpTransport\HttpTransport;
use Liquetsoft\Fias\Component\HttpTransport\HttpTransportResponse;
use Liquetsoft\Fias\Component\HttpTransport\HttpTransportResponseFactory;

/**
 * Http транспорт, который использует встроенный в Laravel Http клиент.
 */
final class HttpTransportLaravel implements HttpTransport
{
    /**
     * {@inheritdoc}
     */
    #[\Override]
    public function head(string $url): HttpTransportResponse
    {
        try {
            $laravelResult = Http::head($url);
            $headers = $this->grabHeadersFromLaravelResult($laravelResult);
        } catch (\Throwable $e) {
            throw new HttpTransportException(
                message: $e->getMessage(),
                previous: $e
            );
        }

        return HttpTransportResponseFactory::create(
            $laravelResult->status(),
            $headers,
        );
    }

    /**
     * {@inheritdoc}
     */
    #[\Override]
    public function get(string $url, array $params = []): HttpTransportResponse
    {
        try {
            $laravelResult = Http::acceptJson()->get($url, $params);
            $headers = $this->grabHeadersFromLaravelResult($laravelResult);
        } catch (\Throwable $e) {
            throw new HttpTransportException(
                message: $e->getMessage(),
                previous: $e
            );
        }

        return HttpTransportResponseFactory::create(
            $laravelResult->status(),
            $headers,
            $laravelResult->body(),
            $laravelResult->json()
        );
    }

    /**
     * {@inheritdoc}
     */
    #[\Override]
    public function download(string $url, $destination, ?int $bytesFrom = null, ?int $bytesTo = null): HttpTransportResponse
    {
        try {
            $laravelRequest = Http::sink($destination);
            if ($bytesFrom !== null && $bytesTo !== null) {
                $laravelRequest = $laravelRequest->withHeaders(
                    [
                        'Range' => 'bytes=' . $bytesFrom . '-' . ($bytesTo - 1),
                    ]
                );
            }
            $laravelResult = $laravelRequest->get($url);
            $headers = $this->grabHeadersFromLaravelResult($laravelResult);
        } catch (\Throwable $e) {
            throw new HttpTransportException(
                message: $e->getMessage(),
                previous: $e
            );
        }

        return HttpTransportResponseFactory::create(
            $laravelResult->status(),
            $headers,
        );
    }

    /**
     * Конвертирует и возвращает заголовки из ответа Http клиента в формате,
     * подходящеи для библиотеки.
     *
     * @return array<string, string>
     */
    private function grabHeadersFromLaravelResult(LaravelResponse $result): array
    {
        $return = [];
        foreach ($result->headers() as $name => $value) {
            $headerName = (string) $name;
            $headerValue = (string) (\is_array($value) ? end($value) : $value);
            $return[$headerName] = $headerValue;
        }

        return $return;
    }
}
