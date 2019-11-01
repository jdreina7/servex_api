<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

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
            // return $this->errorResponse('No existen registros en esta coleccion', 404);
        }

        $transformer = $collection->first()->transformer;

        $collection = $this->filterData($collection, $transformer);

        $collection = $this->sortData($collection, $transformer);

        $collection = $this->paginate($collection);
        
        $collection = $this->transfomrData($collection, $transformer);

        $collection = $this->cacheResponse($collection);

        return $this->successResponse($collection, $code);
    }

    // Muestra uno
    protected function showOne(Model $instance, $code = 200) {
        return $this->successResponse(['data' => $instance], $code);
    }

    // Transformar la data a devolver
    protected function transfomrData($data, $transformer) {
        $transformation = fractal($data, new $transformer);
        return $transformation->toArray();
    }

    // Organizar la data a devolver
    protected function sortData(Collection $collection, $transformer) {
        if (request()->has('sort_by')) {
            //$attr = request()->sort_by;
            $attr = $transformer::originalAttr(request()->sort_by);
            $collection = $collection->sortBy->{$attr};
        }

        return $collection;
    }

    // Paginacion de resultados
    protected function paginate(Collection $collection) {

        $rules = [
            'per_page' => 'integer|min:2|max:50'
        ];

        Validator::validate(request()->all(), $rules);


        $page = LengthAwarePaginator::resolveCurrentPage();

        $perPage = 15;

        // Validamos si envian una pagina desde la URL como paginacion personalizada
        if (request()->has('per_page')) {
            $perPage = (int) request()->per_page;
        }

        $result = $collection->slice(($page - 1) * $perPage, $perPage)->values();

        $paginated = new LengthAwarePaginator($result, $collection->count(), $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);

        $paginated->appends(request()->all());

        return $paginated;
    }

    // Filtrar la data a devolver
    protected function filterData(Collection $collection, $transformer) {
        foreach (request()->query() as $query => $value) {
            $attr = $transformer::originalAttr($query);
            if (isset($attr, $value)) {
                $collection = $collection->where($attr, $value);
            }
        }

        return $collection;
    }

    // Cache de resultados de consulta
    protected function cacheResponse($data) {
        $url = request()->url();

        $queryParams = request()->query();

        ksort($queryParams);

        $queryString = http_build_query($queryParams);

        $fullUrl = "{$url}?{$queryString}";

        return Cache::remember($fullUrl, 30/60, function() use($data){
            return $data;
        });
    }
}