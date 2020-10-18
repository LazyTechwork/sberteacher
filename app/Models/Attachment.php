<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * App\Models\Attachment
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Attachment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function upload(UploadedFile $file, $name)
    {
        $file = Storage::putFile('attachments', $file);
        return self::create(['name' => $name, 'type' => 'document', 'data' => $file]);
    }

    public static function bulkUpload(UploadedFile $files, $name)
    {
        $data = [];
        foreach ($files as $file) {
            $data[] = ['name' => $name, 'type' => 'document', 'data' => Storage::putFile('attachments', $file)];
        }
        return self::create($data);
    }

    public static function link($link, $name)
    {
        return self::create(['name' => $name, 'type' => 'link', 'data' => $link]);
    }
}
