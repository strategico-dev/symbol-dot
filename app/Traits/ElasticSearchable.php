<?php


namespace App\Traits;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

/**
 * @method string getTable();
 *
 */
trait ElasticSearchable
{
    /**
     * @param string $query
     * @param array $fields
     * @return array|callable
     */
    public static function search(string $query, array $fields)
    {
        $client = ClientBuilder::create()->build();
        $currentModel = new static();

        return $client->search([
            'index' => $currentModel->getTable(),
            'body' => [
                'query' => [
                    'multi_match' => [
                        'fields'    => $fields,
                        'query'     => $query,
                        'fuzziness' => 'auto'
                    ]
                ]
            ]
        ]);
    }
}
