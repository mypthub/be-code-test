<?php

declare(strict_types=1);

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Organisation
 *
 * @property int         id
 * @property string      name
 * @property int         owner_user_id
 * @property Carbon      trial_end
 * @property bool        subscribed
 * @property Carbon      created_at
 * @property Carbon      updated_at
 * @property Carbon|null deleted_at
 *
 * @package App
 */
class Organisation extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = ['name','owner_user_id','trial_end','subscribed'];

    /**
     * @var array
     */
    protected $dates = [
        'deleted_at',
    ];

    /**
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class,'owner_user_id');
    }

    /**
     * Get the Trial End.
     *
     * @param  string  $value
     * @return string
     */
    public function getTrialEndAttribute($value){
        return strtotime($value);

    }

    /**
     * Get the Created At.
     *
     * @param  string  $value
     * @return string
     */

    public function getCreatedAtAttribute($value){
        return strtotime($value);
    }

     /**
     * Get the Updated At.
     *
     * @param  string  $value
     * @return string
     */
    public function getUpdatedAtAttribute($value){
        return strtotime($value);
    }

    /**
     * Get the Deleted At.
     *
     * @param  string  $value
     * @return string
     */
    public function getDeletedAtAttribute($value){
        return strtotime($value);
    }
}
