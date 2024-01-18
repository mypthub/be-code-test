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
 * @property int id
 * @property string name
 * @property int owner_user_id
 * @property Carbon trial_end
 * @property bool subscribed
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property Carbon|null deleted_at
 * @property mixed $owner
 *
 * @package App
 */
class Organisation extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = ['name', 'trial_end', 'subscribed'];

    /**
     * @var array
     */
    protected $dates = [
        'deleted_at',
        'trial_end'
    ];
    protected $casts = [
        'subscribed' => 'boolean'
    ];

    /**
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_user_id');
    }

    /**
     * @param $query
     * @param bool $state
     * @return mixed
     */
    public function scopeIsSubscribed($query, bool $state = true)
    {
        return $query->where('subscribed', $state);
    }
}
