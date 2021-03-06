<?php

/**
 * Corcel\PostBuilder.
 *
 * @author Junior Grossi <juniorgro@gmail.com>
 */

namespace Adrenalads\Corcel;

use Illuminate\Database\Eloquent\Builder;

class PostBuilder extends Builder
{
    /**
     * Get only posts with a custom status.
     *
     * @param string $postStatus
     *
     * @return \Adrenalads\Corcel\PostBuilder
     */
    public function status($postStatus)
    {
        return $this->where('post_status', $postStatus);
    }

    /**
     * Get only published posts.
     *
     * @return \Adrenalads\Corcel\PostBuilder
     */
    public function published()
    {
        return $this->status('publish');
    }

    /**
     * Get only posts from a custom post type.
     *
     * @param string $type
     *
     * @return \Adrenalads\Corcel\PostBuilder
     */
    public function type($type)
    {
        return $this->where('post_type', $type);
    }

    /**
     * Get only posts from an array of custom post types.
     *
     * @param array $type
     *
     * @return \Adrenalads\Corcel\PostBuilder
     */
    public function typeIn(array $type)
    {
        return $this->whereIn('post_type', $type);
    }

    /**
     * @param string $taxonomy
     * @param mixed  $terms
     *
     * @return Builder|static
     */
    public function taxonomy($taxonomy, $terms)
    {
        return $this->whereHas('taxonomies', function ($query) use ($taxonomy, $terms) {
            $query->where('taxonomy', $taxonomy)->whereHas('term', function ($query) use ($terms) {
                $query->whereIn('slug', is_array($terms) ? $terms : [$terms]);
            });
        });
    }

    /**
     * Get only posts with a specific slug.
     *
     * @param string slug
     *
     * @return \Adrenalads\Corcel\PostBuilder
     */
    public function slug($slug)
    {
        return $this->where('post_name', $slug);
    }

    /**
     * Paginate the results.
     *
     * @param int $perPage
     * @param int $currentPage
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function paged($perPage = 10, $currentPage = 1)
    {
        $skip = $currentPage * $perPage - $perPage;

        return $this->skip($skip)->take($perPage)->get();
    }
}
