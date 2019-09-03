<?php
namespace Agegg\VopClient\Factories;

use VopClient\VopClient;

class VopClientFactory
{
    public function make(array $config)
    {
        $config = $this->getConfig($config);
        return $this->getClient($config);
    }
    
    protected function getConfig(array $config)
    {
        if (!array_key_exists('app_key', $config)
            || !array_key_exists('app_secret', $config)) {
            throw new \InvalidArgumentException('The vop client requires api keys.');
        }
        return array_only($config, ['app_key', 'app_secret', 'format']);
    }

    protected function getClient(array $config)
    {
        $c = new VopClient;
        $c->appkey = $config['app_key'];
        $c->secretKey = $config['app_secret'];
        $c->format = isset($config['format']) ? $config['format'] : 'json';
        return $c;
    }
}
