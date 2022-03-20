<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PromotionUser
 *
 * @property int $id
 * @property int $user
 * @property int $promotion
 * @method static \Illuminate\Database\Eloquent\Builder|PromotionUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PromotionUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PromotionUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|PromotionUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PromotionUser wherePromotion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PromotionUser whereUser($value)
 * @mixin \Eloquent
 */
class PromotionUser extends Model
{
    use HasFactory;
    protected $table='promotion_users';
    public $timestamps = false;
//    public function wallet(){
//        return $this->belongsTo('App\Models\Wallet', 'user','user');
//    }
}
