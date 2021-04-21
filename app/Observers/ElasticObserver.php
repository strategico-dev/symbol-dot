<?php


namespace App\Observers;

use App\Models\Model;
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
     * @param Model $model
     */
    public function created(Model $model)
    {
        $this->client->index([
            'index' => $model->getTable(),
            'type'  => getenv('ELASTIC_SEARCH_TYPE'),
            'id'    => $model->getKey(),
            'body'  => $model->toArray()
        ]);
    }

    /**
     * @param Model $model
     */
    public function deleted(Model $model)
    {
        $this->client->delete([
            'index' => $model->getTable(),
            'id'    => $model->getKey()
        ]);
    }
}
