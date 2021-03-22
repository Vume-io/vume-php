<?php

namespace Vume\Libraries;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;

use Vume\Exceptions\ConnectionException;
use Vume\Exceptions\AccessTokenInvalidException;

class Api
{
    private $api_endpoint;
    private $access_token;

    /**
     * Construct class
     *
     * @param string $api_endpoint
     * @param string $access_token
     */
    public function __construct(string $api_endpoint, string $access_token)
    {
        $this->api_endpoint = $api_endpoint;
        $this->access_token = $access_token;
    }

    /**
     * Call Vume API
     *
     * @param string $method
     * @param string $route
     * @param array $params
     * @return array $result
     */
    public function call(string $method, string $route, array $params = [])
    {
        $client = new Client(['headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'access-token' => $this->access_token
        ]]);

        // Try calling the api
        try {
            $response = $client->request($method, $this->constructEndpoint($method, $route, $params), []);
        } catch (ClientException $exception) {
            $response = $exception->getResponse();
        } catch (ConnectException $exception) {
            throw new ConnectionException();
        } catch (ServerException $exception) {
            throw new ConnectionException();
        }

        // Throw exception if the access token is invalid
        switch ($response->getStatusCode()) {
            case '403':
                throw new AccessTokenInvalidException();
        }

        // Return result
        return [
            'code' => $response->getStatusCode(),
            'body' => json_decode($response->getBody()->getContents(), true)
        ];
    }

    /**
     * Construct the api endpoint
     *
     * @param string $method
     * @param string $endpoint
     * @param array $params
     * @return string $endpoint
     */
    private function constructEndpoint(string $method, string $endpoint, array $params)
    {
        if ($method === 'GET' && $params) return $this->api_endpoint . $endpoint . '?' . http_build_query($params);
        return $this->api_endpoint . $endpoint;
    }
}
