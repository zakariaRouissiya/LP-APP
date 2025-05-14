<?php

namespace Tests;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Illuminate\Support\Collection;
use Laravel\Dusk\TestCase as BaseTestCase;
use PHPUnit\Framework\Attributes\BeforeClass;

abstract class DuskTestCase extends BaseTestCase
{
    /**
     * Prepare for Dusk test execution.
     */
    #[BeforeClass]
    public static function prepare(): void
    {
        if (! static::runningInSail()) {
            static::startChromeDriver(['--port=9515',
            '--user-data-dir=/tmp/chrome-user-data']);
        }
    }

    /**
     * Create the RemoteWebDriver instance.
     */
    protected function driver(): RemoteWebDriver
{
    $options = (new ChromeOptions)->addArguments([
        '--disable-gpu',
        '--headless',
        '--window-size=1920,1080',
        '--no-sandbox',
        '--disable-dev-shm-usage',
        '--user-data-dir=/tmp/chrome-user-data'
    ]);

    return RemoteWebDriver::create(
        'http://localhost:9515',
        DesiredCapabilities::chrome()->setCapability(
            ChromeOptions::CAPABILITY, $options
        )
    );
}

    /**
     * Get the base URL for the application.
     */
    protected function baseUrl()
    {
        return 'http://127.0.0.1:8000';
    }
}
