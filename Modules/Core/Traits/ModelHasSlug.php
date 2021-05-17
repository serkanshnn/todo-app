<?php

namespace Modules\Core\Traits;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Schema;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * Class HasModuleFactory.
 */
/**
 * @property-read string $slugFrom
 */
trait ModelHasSlug
{
    use HasSlug;
    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        if (Schema::hasColumn($this->getTable(), 'name')) {
            $this->slugFrom = 'name';
        }elseif (Schema::hasColumn($this->getTable(), 'title')) {
            $this->slugFrom = 'title';
        }
        return SlugOptions::create()
            ->generateSlugsFrom($this->slugFrom)
            ->saveSlugsTo('slug');
    }

}
