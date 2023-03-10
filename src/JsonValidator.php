<?php

namespace Tlab;

use Symfony\Component\HttpFoundation\Request;
use Opis\JsonSchema\{Validator, Errors\ErrorFormatter};

class JsonValidator
{
  public function validate(Request $request): string
  {
      $content = $request->getContent();
      $payload = json_decode($content, true);

      if($payload === null) {
          return json_encode([
              'valid' => false,
              'message' => 'Invalid data',
          ]);
      }

      $data = $payload['data'];
      $schema = $payload['schema'];

      $schema = json_encode($schema);
      $data = json_encode($data);

      $validator = new Validator();
      $validator->setMaxErrors(5);

      // Decode $data
      $data = json_decode($data);

      $result = $validator->validate($data, $schema);

      if ($result->isValid()) {
          return json_encode([
              'valid' => true,
              'message' => '',
          ]);
      }

      $error = $result->error();
      $formatter = new ErrorFormatter();

      return json_encode(
          [
              'valid' => false,
              'message' => $formatter->format($error, false),
          ]
      );
  }
}