<?php

namespace App\Lib\Api;

use Cake\Controller\Controller;
use Cake\Http\ServerRequest;

class ApiPaginator
{

    /**
     * Current Controller
     * @var Controller
     */
    private $Controller;

    /**
     * Current page
     * @var int
     */
    private $page = 1;

    /**
     * Limit per page
     * @var int
     */
    private $limit = 25;

    /**
     * Number of total records in database
     * for current query
     * @var int
     */
    private $count = 0;

    /**
     * Total pages
     * @var int
     */
    private $pages = 1;

    /**
     * Number of current records
     * (Amount of records on current page)
     * @var int
     */
    private $current = 0;

    public function __construct(Controller $Controller, ServerRequest $request)
    {
        $this->Controller = $Controller;

        $this->limit = 25;

        $page = $request->getQuery('page');
        if (is_numeric($page)) {
            $this->setPage($page);
        }
    }

    /**
     * @param int $page
     */
    public function setPage($page)
    {
        $this->page = $page;
    }

    /**
     * @param int $limit
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
    }

    /**
     * @param $current
     */
    public function setCurrent($current)
    {
        $this->current = $current;
    }

    /**
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getOffset()
    {
        if ($this->page === 1) {
            return 0;
        }
        return (int) $this->limit * ($this->page - 1);
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @return int
     */
    public function getPages()
    {
        return $this->pages;
    }

    public function setCountResult($count)
    {
        $this->count = (int) $count;
        if ($this->count === 0) {
            $this->pages = 1;
        } else {
            $this->pages = ceil($this->count / $this->limit);
        }
    }

    /**
     * @return bool
     */
    private function hasPrevPage()
    {
        if ($this->page !== 1) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    private function hasNextPage()
    {
        /**
         * $this->page = current page
         * $this->current = number of current items
         * $this->count = number of total items in table
         * $this->limit = max records per page
         */

        if ($this->page * $this->limit < $this->count) {
            return true;
        }

        return false;
    }

    public function getPagination()
    {
        return [
            'page'       => (int) $this->page,
            'current'    => $this->current,
            'count'      => $this->count,
            'prevPage'   => $this->hasPrevPage(),
            'nextPage'   => $this->hasNextPage(),
            'pageCount'  => $this->pages,
            'limit'      => $this->limit,
            'options'    => [],
            'paramType'  => "named",
            'queryScope' => null,
        ];
    }

    public function paginate()
    {
        $this->Controller->set('paging', $this->getPagination());
    }
}
