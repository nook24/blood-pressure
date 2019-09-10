<?php

namespace App\Lib\Traits;

use Cake\ORM\Query;
use App\Lib\Api\ApiPaginator;


trait PaginationTrait{


    /**
     * @param Query $query
     * @param ApiPaginator $ApiPaginator
     * @return array
     */
    public function paginate(Query $query, ApiPaginator $ApiPaginator) {
        $ApiPaginator->setCountResult($query->count());
        $query->offset($ApiPaginator->getOffset());
        $query->limit($ApiPaginator->getLimit());
        $result = $this->emptyArrayIfNull($query->toArray());
        $ApiPaginator->setCurrent(sizeof($result));
        $ApiPaginator->paginate();
        return $result;
    }

    /**
     * @param array|null $result
     * @return array
     */
    public function emptyArrayIfNull($result) {
        if ($result === null) {
            return [];
        }
        return $result;
    }

}