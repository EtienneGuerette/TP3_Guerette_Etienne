<?php

namespace App\Repository\Eloquent;

use App\Repository\ReviewRepositoryInterface;
use App\Models\Review;


class ReviewRepository extends BaseRepository implements ReviewRepositoryInterface
{
    public function __construct(Review $model)
    {
        parent::__construct($model);
    }
}
