<?php

declare(strict_types=1);

namespace App;

use Carbon\Carbon;
use App\Services\OrganisationFilterData;
use Illuminate\Database\Eloquent\Collection;
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
 * @property-read User   owner
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
        'deleted_at',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'trial_end' => 'datetime',
        'subscribed' => 'boolean',
    ];

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
        return $this->belongsTo(User::class, 'owner_user_id');
    }

    /**
     * @param OrganisationFilterData $filterData
     * @return Collection
     */
    public function getList(OrganisationFilterData $filterData): Collection
    {
        $query = $this
            ->newQuery()
            ->with('owner')
            ->select(['*'])
            ->whereNull('deleted_at');

        if ($filterData->isTrial()) {
            $query
                ->where('subscribed', false)
                ->where('trial_end', '>', now()->format('Y-m-d H:i:s'));
        }

        if ($filterData->isSubscribed()) {
            $query->where('subscribed', true);
        }

        return $query
            ->orderByDesc('created_at')
            ->get();
    }
}
