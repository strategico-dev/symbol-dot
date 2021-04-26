<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method void fetch()
 */
class CrmModel extends Model
{
    /**
     * @var int
     */
    protected int $fetchLimit = 10;

    /**
     * @var string
     */
    protected string $orderBy = 'id';

    /**
     * @var string
     */
    protected string $orderType = 'DESC';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    /**
     * @param $query
     * @param $limit
     * @return mixed
     */
    public function scopeFetch($query, $limit = null)
    {
        $limit = $limit ?? $this->fetchLimit;

        return $query->orderBy($this->orderBy, $this->orderType)->
                       paginate($limit);
    }
}
