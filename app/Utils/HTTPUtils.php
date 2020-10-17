<?php


namespace App\Utils;


use Illuminate\Support\MessageBag;

class HTTPUtils
{

    public static $VALIDATION_ERROR = "validation";
    public static $LOGIN_FAIL = "login_fail";
    public static $UNAUTHORIZED = "unauthorized";
    public static $MODULE_NOTFOUND = "module_notfound";

    /**
     * @param $data
     * @param int $status
     * @param false $error
     * @return \Illuminate\Http\JsonResponse
     */
    public static function returnJsonResponse($data, $status = 200, $error = false)
    {
        return response()->json(["status" => $error ? "error" : "ok", "data" => $data], $status);
    }

    /**
     * @param $message
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    public static function returnJsonErrorResponse($message, $status = 400)
    {
        return self::returnJsonResponse(["error" => $message], $status, true);
    }

    /**
     * @param MessageBag $messageBag
     * @param int $status
     * @param null $data
     * @return \Illuminate\Http\JsonResponse
     */
    public static function returnJsonErrorBag(MessageBag $messageBag, $status = 422, $data = [])
    {
        $messages = [];
        foreach ($messageBag->getMessages() as $param => $message)
            $messages[$param] = $message[0];

        return self::returnJsonResponse(array_merge(["error" => self::$VALIDATION_ERROR, "messages" => $messages], $data), $status, true);
    }
}
