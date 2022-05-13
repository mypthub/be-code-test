<?php

declare(strict_types=1);

namespace App\Services;

class OrganisationFilterData
{
    const FILTER_DEFAULT = 'all';
    const FILTER_TRIAL = 'trial';
    const FILTER_SUBSCRIBED = 'subbed';

    /**
     * @var string
     */
    private $filter;

    public function __construct()
    {
        $this->filter = self::FILTER_DEFAULT;
    }

    /**
     * @return string
     */
    public function getFilter(): string
    {
        return $this->filter;
    }

    /**
     * @param string $filter
     */
    public function setFilter(string $filter): void
    {
        if (in_array($filter, [self::FILTER_SUBSCRIBED, self::FILTER_TRIAL])) {
            $this->filter = $filter;
        } else {
            $this->filter = self::FILTER_DEFAULT;
        }
    }

    /**
     * @return bool
     */
    public function isTrial(): bool
    {
        return $this->filter === self::FILTER_TRIAL;
    }

    /**
     * @return bool
     */
    public function isSubscribed(): bool
    {
        return $this->filter === self::FILTER_SUBSCRIBED;
    }
}
