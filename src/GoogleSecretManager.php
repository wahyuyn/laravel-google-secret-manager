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
}
