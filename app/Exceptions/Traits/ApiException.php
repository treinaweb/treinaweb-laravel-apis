<?php

namespace App\Exceptions\Traits;

use Illuminate\Database\Eloquent\ModelNotFoundException;

trait ApiException {

  /**
   * Trata as exceções da API
   *
   * @param [type] $request
   * @param [type] $e
   * @return void
   */
  public function getJsonException($request, $e)
  {
    if ($e instanceof ModelNotFoundException) {
      return $this->notFoundException();
    }
  }

  /**
   * Retornar o erro 404
   *
   * @return void
   */
  public function notFoundException()
  {
    return $this->getResponse(
      "Recurso não encontrado",
      "01",
      404
    );
  }

  /**
   * Mostra a resposta em json
   *
   * @param [type] $message
   * @param [type] $code
   * @param [type] $status
   * @return void
   */
  public function getResponse($message, $code, $status)
  {
    return response()->json([
      "errors" => [
          [
              "status" => $status,
              "code" => $code,
              "message" => $message
          ]
      ]
    ], $status);
  }

}