<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Module
 *
 * @property int $id
 * @property string $name Название модуля
 * @property string $subject Предмет
 * @property int $grade Класс
 * @property int $difficulty Сложность
 * @property int $user_id
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Module newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Module newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Module query()
 * @method static \Illuminate\Database\Eloquent\Builder|Module whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Module whereDifficulty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Module whereGrade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Module whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Module whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Module whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Module whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Module whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Module whereUserId($value)
 * @mixin \Eloquent
 */
class Module extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $with = ['tasks'];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
