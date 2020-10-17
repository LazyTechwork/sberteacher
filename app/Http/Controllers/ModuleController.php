<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Utils\HTTPUtils;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function create(Request $request)
    {
        $validator = validator($request->all(), [
            "name"       => ["required", "max:255", "string"],
            "subject"    => ["required", "max:255", "string"],
            "desciption" => ["required"],
            "grade"      => ["required", "integer", "between:1,11"],
            "difficulty" => ["required", "integer", "between:1,10"],
        ]);
        if ($validator->fails())
            return HTTPUtils::returnJsonErrorBag($validator->errors(), 422);

        $data = $request->only(["name", "subject", "grade", "difficulty"]);
        $data["user_id"] = \Auth::user()->id;
        $module = Module::create($data);
        return HTTPUtils::returnJsonResponse($module);
    }

    public function get(Request $request)
    {
        $validator = validator($request->all(), [
            "id"      => ["integer", "required_without:user_id"],
            "user_id" => ["integer", "required_without:id"],
        ]);
        if ($validator->fails())
            return HTTPUtils::returnJsonErrorBag($validator->errors(), 422);

        if ($id = $request->get("id"))
            $module = Module::find($id)->first();
        else
            $module = Module::whereUserId($request->get('user_id'));

        return HTTPUtils::returnJsonResponse($module);
    }
}
