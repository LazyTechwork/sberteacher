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
            "fgos"       => ["max:255", "string"],
            "grade"      => ["required", "integer", "between:1,11"],
            "difficulty" => ["required", "integer", "between:1,10"],
        ]);
        if ($validator->fails())
            return HTTPUtils::returnJsonErrorBag($validator->errors(), 422);

        $data = $request->only(["name", "subject", "grade", "difficulty", "description", "fgos"]);
        $data["user_id"] = $request->user()->id;
        $module = Module::create($data);
        return HTTPUtils::returnJsonResponse($module);
    }

    public function edit(Request $request)
    {
        $validator = validator($request->all(), [
            "id"         => ["required", "integer"],
            "name"       => ["max:255", "string"],
            "subject"    => ["max:255", "string"],
            "fgos"       => ["max:255", "string"],
            "grade"      => ["integer", "between:1,11"],
            "difficulty" => ["integer", "between:1,10"],
        ]);
        if ($validator->fails())
            return HTTPUtils::returnJsonErrorBag($validator->errors(), 422);

        $data = $request->only(["name", "subject", "grade", "difficulty", "description", "fgos"]);
        $module = Module::find($request->get('id'));
        if (!$module)
            return HTTPUtils::returnJsonErrorResponse(HTTPUtils::$MODULE_NOTFOUND, 404);
        $module = Module::create($data);
        return HTTPUtils::returnJsonResponse($module);
    }

    public function get(Request $request)
    {
        $validator = validator($request->all(), [
            "id" => ["integer"],
        ]);
        if ($validator->fails())
            return HTTPUtils::returnJsonErrorBag($validator->errors(), 422);

        $module = Module::find($request->get('id'));
        if (!$module)
            return HTTPUtils::returnJsonErrorResponse(HTTPUtils::$MODULE_NOTFOUND, 404);

        return HTTPUtils::returnJsonResponse($module);
    }

    public function all(Request $request)
    {
        $validator = validator($request->all(), [
            "user_id" => ['integer'],
        ]);
        if ($validator->fails())
            return HTTPUtils::returnJsonErrorBag($validator->errors(), 422);

        if ($id = $request->get("user_id"))
            $modules = Module::whereUserId($request->get('user_id'))->active()->get();
        else
            $modules = Module::active()->get();

        return HTTPUtils::returnJsonResponse($modules);
    }

    public function delete(Request $request)
    {
        $id = $request->get('id');
        if (!$id)
            return HTTPUtils::returnJsonErrorResponse(HTTPUtils::$MODULE_NOTFOUND, 404);
        $module = Module::find($id);
        $module->update(["status" => "removed"]);
        return HTTPUtils::returnJsonResponse(Module::active()->get());
    }
}
