<?php

namespace Vendor\GoogleSecretManager;

use Google\Cloud\SecretManager\V1\SecretManagerServiceClient;

class SecretManager
{
    protected $client;

    public function __construct()
    {
        $this->client = new SecretManagerServiceClient();
    }

    public function getSecret($projectId, $secretId, $versionId = 'latest')
    {
        $name = $this->client->secretVersionName($projectId, $secretId, $versionId);
        $response = $this->client->accessSecretVersion($name);
        $payload = $response->getPayload()->getData();

        return $payload;
    }
    
    public function injectSecretToEnv($projectId, $secretId, $envKey, $versionId = 'latest')
    {
        $secret = $this->getSecret($projectId, $secretId, $versionId);
        $this->setEnv($envKey, $secret);
    }

    protected function setEnv($key, $value)
    {
        // Check if the key already exists in the environment
        if (env($key) !== null) {
            $pattern = "/^{$key}=.*$/m";
            file_put_contents(base_path('.env'), preg_replace($pattern, "{$key}={$value}", file_get_contents(base_path('.env'))));
        } else {
            // Append new key to the end of the file
            file_put_contents(base_path('.env'), PHP_EOL . "{$key}={$value}", FILE_APPEND);
        }

        // Update the $_ENV and $_SERVER superglobals
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;

        // Update the Laravel config cache if it exists
        if (function_exists('app')) {
            app()->config->set($key, $value);
        }
    }

    public function injectSecretToConfig($projectId, $secretId, $configKey, $versionId = 'latest')
    {
        $secret = $this->getSecret($projectId, $secretId, $versionId);
        config([$configKey => $secret]);
    }
}
