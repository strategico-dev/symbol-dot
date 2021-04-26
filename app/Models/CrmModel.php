<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

/**
 * @method void fetch()
 */
class CrmModel extends BaseModel
{
    /**
     * @var int
     */
    protected $fetchLimit = 10;

    /**
     * @var string
     */
    protected $orderBy = 'id';

    /**
     * @var string
     */
    protected $orderType = 'DESC';

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
