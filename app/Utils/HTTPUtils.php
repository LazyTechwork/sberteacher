<?php


namespace App\Utils;


use Illuminate\Support\MessageBag;

class HTTPUtils
{
    public static function returnJsonResponse($data, $error = false)
    {
        return response()->json(["status" => $error ? "error" : "ok", "data" => $data]);
    }

    public static function returnJsonErrorResponse($message)
    {
        return self::returnJsonResponse(["error" => $message], true);
    }

    public static function returnJsonErrorBag(MessageBag $messageBag)
    {
        $messages = [];
        foreach ($messageBag->getMessages() as $param => $message)
            $messages[$param] = $message[0];

        return self::returnJsonResponse(["error" => "Validation error", "messages" => $messages], true);
    }
}
