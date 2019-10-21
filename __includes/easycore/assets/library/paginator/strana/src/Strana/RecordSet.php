<?php namespace Strana;

class RecordSet implements \Iterator
{

    /**
     * @var array
     */
    public $records;

    /**
     * @var
     */
    protected $total;

    /**
     * @var
     */
    protected $position;

    /**
     * @var string
     */
    protected $links;

    /**
     * @var string
     */
    protected $currentPage;

    /**
     * @param array $records
     * @param $total
     * @param $currentPage
     * @param null $links
     */
    public function __construct($records, $total, $currentPage, $links = null)
    {
        $this->records = $records;
        $this->total = $total;
        $this->currentPage = $currentPage;
        $this->links = $links;
    }

    /**
     * Xamtax Ehex Edit
     * @param $method
     * @param $arguments
     * @return mixed
     */
    // quick fix for laravel, i don;t knw why records need to be called manually
    public function __call($method, $arguments){
       if(isset($this->$method)){
           $func = $this->$method;
           return call_user_func_array($func, $arguments);
       }
    }



    /**
     * @return self|\Model1
     */
    public function records(){
        $record = [];
        foreach($this->records as $rec) $record[] = \Object1::toArrayObject(false,  $rec);
        return $record;
    }

    /**
     * @return int
     */
    public function total()
    {
        return $this->total;
    }

    /**
     * @return mixed|void
     */
    public function rewind(){
        return reset($this->records);
    }

    /**
     * @return mixed
     */
    public function current()
    {
        return current($this->records);
    }

    /**
     * @return mixed
     */
    public function currentPage(){
        return $this->currentPage;
    }

    /**
     * @return mixed
     */
    public function key()
    {
        return key($this->records);
    }

    /**
     * @return mixed|void
     */
    public function next()
    {
        return next($this->records);
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return key($this->records) !== null;
    }

    /**
     * @param $links
     */
    public function setLinks($links)
    {
        $this->links = $links;
    }

    /**
     * @return null|string
     */
    public function links()
    {
        return $this->links;
    }


    /**
     * @return null|string
     */
    public function __toString()
    {
        return $this->links();
    }
}