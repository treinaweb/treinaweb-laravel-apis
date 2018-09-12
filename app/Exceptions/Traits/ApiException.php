<?php

namespace App\Exceptions\Traits;

use Illuminate\Database\Eloquent\ModelNotFoundException;

trait ApiException {

  public function getJsonException($request, $e)
  {
    if ($e instanceof ModelNotFoundException) {
      return response()->json([
        "errors" => [
            [
                "status" => 404,
                "code" => "01",
                "message" => "O recurso não foi encontrado"
            ]
        ]
      ], 404);
    }
  }

}