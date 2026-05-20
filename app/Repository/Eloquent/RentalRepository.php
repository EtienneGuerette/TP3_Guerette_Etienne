<?php

namespace App\Repository\Eloquent;

use App\Repository\RentalRepositoryInterface;
use App\Models\Rental;


class RentalRepository extends BaseRepository implements RentalRepositoryInterface
{
    public function __construct(Rental $model)
    {
        parent::__construct($model);
    }

    public function getActives()
    {
        return $this->model->where('start_date', '<=', now())->where('end_date', '>=', now())->get();
    }
}
