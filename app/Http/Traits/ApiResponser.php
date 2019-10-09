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
        return $this->successResponse(['data' => $collection], $code);
    }

    // Muestra uno
    protected function showOne(Model $instance, $code = 200) {
        return $this->successResponse(['data' => $instance], $code);
    }
}