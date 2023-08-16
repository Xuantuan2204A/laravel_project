<?php

namespace App\Repositories\Eloquent;

use App\Repositories\BlogPostRepositoryInterface;
use App\Models\BlogPosts;

class BlogPostRepository extends BaseRepository implements BlogPostRepositoryInterface
{
    public $model;

    public function __construct(BlogPosts $model)
    {
        $this->setModel($model);
    }
}
