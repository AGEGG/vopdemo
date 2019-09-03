<?php
namespace Agegg\VopClient;

use Agegg\VopClient\Factories\VopClientFactory;
use GrahamCampbell\Manager\AbstractManager;
use Illuminate\Contracts\Config\Repository;

class VopClientManager extends AbstractManager
{
    protected $factory;

    public function __construct(Repository $config, VopClientFactory $factory)
    {
        parent::__construct($config);
        $this->factory = $factory;
    }

    protected function createConnection(array $config)
    {
        return $this->factory->make($config);
    }

    protected function getConfigName()
    {
        return 'vop';
    }

    public function getFactory()
    {
        return $this->factory;
    }
}
