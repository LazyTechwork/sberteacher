<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
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
                "file", "mimes:jpg,png,jpeg,gif", "max:5120",
            ],
            "text"          => ["required", "max:10240"],
            "links"         => ['max:1024', "string"],
            "attachments.*" => ["file", "mimes:png,jpg,jpeg,gif,doc,docx,pdf,xls,csv"],
            "task_type"     => ["required", "max:255", "string", "in:check,radio,short_answer,long_answer,theory"],
            "task_data"     => ["max:10240", "string"],
        ]);
        if ($validator->fails())
            return HTTPUtils::returnJsonErrorBag($validator->errors(), 422);

        $data = $request->only(["name", "cover_type", "text", "task_type", "task_data"]);

        if ($request->has('cover_file'))
            $data["cover_attachment"] = Attachment::upload($request->file('cover_file'), $request->get('name'));
        else
            $data["cover_attachment"] = Attachment::link($request->get("cover_youtube"), $request->get("name"));

        if ($request->has("attachments")) {
            $attachments = $request->file("attachments.*");
            Attachment::bulkUpload($attachments, $request->get("name"));
        }

        $data["user_id"] = $request->user()->id;
        return HTTPUtils::returnJsonResponse($module);
    }
}
