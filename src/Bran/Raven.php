<?php

namespace Bran;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;
use PHPUnit\Framework\TestCase;

class Raven extends TestCase
{
    /**
     * @var array
     */
    protected $clientConfig;

    /**
     * @var array
     */
    protected $apiConfig;

    /**
     * @var array
     */
    protected $defaultApiConfig = [];

    public function call($apiName, array $options = [])
    {
        $apiConfig = $this->apiConfig + $this->defaultApiConfig;
        if (!array_key_exists($apiName, $apiConfig)) {
            throw new \RuntimeException('Api ' . $apiName . ' is not set');
        }

        $client = ClientBuilder::build(array_replace_recursive($this->clientConfig, $options));

        $api = $apiConfig[$apiName];

        $headers = $this->prepareHeaders($api, $options);

        $request = RequestBuilder::build($api, $headers);

        try {
            $response = $client->send($request);
        } catch (ClientException $e) {
            $response = $e->getResponse();
        } catch (ServerException $e) {
            $response = $e->getResponse();
        } catch (ConnectException $e) {
            throw new $e;
        } catch (RequestException $e) {
            $response = $e->getResponse();
        } catch (\Exception $e) {
            throw new $e;
        }

        return new ResponseEntity($response);
    }

    protected function prepareHeaders($api, $options)
    {
        $headers = [];

        if (array_key_exists('headers', $this->clientConfig)) {
            $headers += $this->clientConfig['headers'];
        }

        if (array_key_exists('headers', $api)) {
            $headers = $api['headers'] + $headers;
        }

        if (array_key_exists('headers', $options)) {
            $headers = $options['headers'] + $headers;
        }

        return $headers;
    }
}