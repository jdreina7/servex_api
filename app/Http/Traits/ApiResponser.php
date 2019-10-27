<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

trait ApiResponser {

    // Respuestas exitosas
    private function successResponse($data, $code) {
        return response()->json($data, $code);
    }

    // Respuestas con error
    protected function errorResponse($message, $code) {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }

    // Muestra todos
    protected function showAll(Collection $collection, $code = 200) {

        if ($collection->isEmpty()) {
            return $this->successResponse(['data' => $collection], $code);
        }
        
        
        $collection = $this->sortData($collection);
        return $this->successResponse($collection, $code);
    }

    // Muestra uno
    protected function showOne(Model $instance, $code = 200) {
        return $this->successResponse(['data' => $instance], $code);
    }

    protected function sortData(Collection $collection) {
        if (request()->has('sort_by')) {
            $attr = request()->sort_by;
            $collection = $collection->sortBy->{$attr};
        }

        return $collection;
    }

    protected function filterData(Collection $collection, $filter) {
        foreach (request()->query() as $query => $value) {
            $attr = $filter::originalAttribute($query);

            if (isset($attr, $value)) {
                $collection = $collection->where($attr, $value);
            }
        }

        return $collection;
    }
}