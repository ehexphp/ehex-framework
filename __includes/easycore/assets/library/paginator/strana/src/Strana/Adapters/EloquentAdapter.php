<?php namespace Strana\Adapters;

use Illuminate\Database\Query\Builder as EloquentQuery;
use Strana\ConfigHelper;
use Strana\Exceptions\InvalidArgumentException;
use Strana\Interfaces\CollectionAdapter;

class EloquentAdapter implements CollectionAdapter{

    /**
     * @var \Strana\ConfigHelper
     */
    protected $configHelper;

    /**
     * @var EloquentQuery
     */
    protected $records;

    /**
     * @param $records
     * @param ConfigHelper $configHelper
     * @throws \Strana\Exceptions\InvalidArgumentException
     */
    public function __construct($records, ConfigHelper $configHelper)
    {
        if (!$records instanceof EloquentQuery) {
            throw new InvalidArgumentException('Expected Illuminate\Database\Query\Builder');
        }




        $this->records = $records;//is_array($records)? $records: $records->get();

        $this->configHelper = $configHelper;
    }

    /**
     * @return array|static[]
     */
    public function slice()
    {
        $records = clone($this->records);
        $limit = $this->configHelper->getLimit();
        $offset = $this->configHelper->getOffset();
        
        return $records->limit($limit)->offset($offset)->get();
    }

    /**
     * @return int
     */
    public function total()
    {
        $records = clone($this->records);
        return $records->count();
    }
}