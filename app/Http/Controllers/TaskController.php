<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Utils\HTTPUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    public function create(Request $request)
    {
        $validator = validator($request->all(), [
            "name"          => ["required", "max:255", "string"],
            "cover_type"    => ["required", "max:255", "string"],
            "cover_youtube" => [
                "required_without:cover_file",
                Rule::requiredIf(function () use ($request) {
                    return $request->get('cover_type') == "youtube";
                }),
                "max:255", "string",
            ],
            "cover_file"    => [
                "required_without:cover_youtube",
                Rule::requiredIf(function () use ($request) {
                    return $request->get('cover_type') == "image";
                }),
                "file", "mimes:jpg,png,jpeg,gif", "max:5M",
            ],
            "text"          => ["required", "max:10240"],
            "links"         => ['max:1024', "string"],
            "attachments.*" => ["file", "mimes:png,jpg,jpeg,gif,doc,docx,pdf,xls,csv"],
            "task_type"     => ["required", "max:255", "string"],
            "task_data"     => ["required", "max:10240", "string"],
        ]);
        if ($validator->fails())
            return HTTPUtils::returnJsonErrorBag($validator->errors(), 422);

        if ($request->has('cover_file')) {
            $cover = $request->file('cover_file');
            Storage::putFile('attachments', $cover);
        }

        $data = $request->only(["name", "subject", "grade", "difficulty", "description", "fgos"]);
        $data["user_id"] = $request->user()->id;
        $module = Module::create($data);
        return HTTPUtils::returnJsonResponse($module);
    }
}
