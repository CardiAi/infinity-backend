<?php
namespace App\Traits;
trait Searchable
{
    public function scopeFilter($query,array $filter){
        $columns = $this->columns;
        if($filter['search'] ?? false){
            $query->where(function($q)use($columns){
                foreach($columns as $column){
                    $q->orWhere($column,'like','%'.request('search').'%');
                }

            });
        }
    }
}
