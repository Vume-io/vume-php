<?php

namespace Vume\Tests;

use Vume\CMS;
use Dotenv\Dotenv;

use PHPUnit\Framework\TestCase;

abstract class BaseTest extends TestCase
{
    protected $vume;

    public function __construct()
    {
        if (file_exists(__DIR__ . '/../.env')) {
            Dotenv::createImmutable(__DIR__ . '/../')->load();
        }

        parent::__construct();
    }

    public function setUp(): void
    {
        $this->vume = new CMS('VM.wDScs0mOBkl1rRbUJtf9oPEQMeC24gWh5AqxKvGzNuXI3VZY6dTHijn7LpaF8');

        // Overwrite API endpoint
        if (isset($_ENV['PHPUNIT_API_ENDPOINT'])) {
            $this->vume->setApiEndpoint($_ENV['PHPUNIT_API_ENDPOINT']);
        }

        // Overwrite API access token
        if (isset($_ENV['PHPUNIT_API_ACCESS_TOKEN'])) {
            $this->vume->setAccessToken($_ENV['PHPUNIT_API_ACCESS_TOKEN']);
        }

        parent::setUp();
    }
}
