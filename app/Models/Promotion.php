<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Promotion
 *
 * @property int $id
 * @property string $code
 * @property string $start_date
 * @property string $end_date
 * @property string $amount
 * @property int $quato
 * @method static \Illuminate\Database\Eloquent\Builder|Promotion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Promotion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Promotion query()
 * @method static \Illuminate\Database\Eloquent\Builder|Promotion whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Promotion whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Promotion whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Promotion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Promotion whereQuato($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Promotion whereStartDate($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 */
class Promotion extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table='promotions';
    public function users(){
        return $this->belongsToMany('App\Models\User', 'promotion_users', 'promotion', 'user');
    }

}
