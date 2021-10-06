<?php

namespace App\Repository\Order;

use App\Models\Order;
use App\Repository\Base\BaseRepository;

class OrderRepository extends BaseRepository implements IOrderRepository {

    public function __construct(Order $model)
    {
        parent::__construct($model);
    }
}
