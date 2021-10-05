<?php

namespace App\Repository\Product;

use App\Models\Product;
use App\Repository\Base\BaseRepository;

class ProductRepository extends BaseRepository implements IProductRepository {

    public function __construct(Product $model)
    {
        parent::__construct($model);
    }
}
