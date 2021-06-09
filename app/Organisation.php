<?php

declare(strict_types=1);

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
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
 *
 * @package App
 */
class Organisation extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'owner_user_id',
        'trial_end',
        'subscribed',
    ];

    /**
     * @var array
     */
    protected $dates = [
        'trial_end',
        'deleted_at',
    ];

    /**
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_user_id', 'id');
    }

    /**
     * @param Builder $builder
     * @param string $filter
     * @return Builder
     */
    public function scopeFilter(Builder $builder, string $filter): Builder
    {
        if (!in_array($filter, ['all', 'subbed', 'trial'])) {
            $filter = 'all';
        }

        if ('trial' === $filter) {
            return $builder->where('trial_end', '>', now())
                ->where('subscribed', 0);
        }

        if ('subbed' === $filter) {
            return $builder->where('subscribed', 1);
        }

        return $builder;
    }
}
