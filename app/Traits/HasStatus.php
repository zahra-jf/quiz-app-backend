<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * Trait HasStatus
 *
 * @package App\Traits
 *
 * @property string  $table
 * @property boolean $status
 *
 * @method static Builder active()
 * @method static Builder inActive()
 */
trait HasStatus
{
    /**
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeActive(Builder $query)
    {
        return $query->where("{$this->table}.status", true);
    }

    /**
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeInActive(Builder $query)
    {
        return $query->where("{$this->table}.status", false);
    }

    /**
     * change dynamic status
     */
    public function changeStatus()
    {
        static::where('id', $this->id)->update([
            "{$this->table}_status" => !$this->{$this->table . '_status'}
        ]);
    }

}
