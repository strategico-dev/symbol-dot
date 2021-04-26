<?php


namespace App\Observers;

use App\Models\CrmModel;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

/**
 * Observer for models that use elasticsearch
 */
class ElasticObserver
{
    /**
     * @var Client
     */
    private $client;

    public function __construct()
    {
        $this->client = ClientBuilder::create()->build();
    }

    /**
     * @param CrmModel $model
     */
    public function created(CrmModel $model)
    {
        $this->client->index([
            'index' => $model->getTable(),
            'type'  => getenv('ELASTIC_SEARCH_TYPE'),
            'id'    => $model->getKey(),
            'body'  => $model->toArray()
        ]);
    }

    /**
     * @param CrmModel $model
     */
    public function deleted(CrmModel $model)
    {
        $this->client->delete([
            'index' => $model->getTable(),
            'id'    => $model->getKey()
        ]);
    }
}
