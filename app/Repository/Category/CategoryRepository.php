<?php

namespace App\Repository\Category;

use App\Models\Category;
use App\Repository\Base\BaseRepository;

class CategoryRepository extends BaseRepository implements ICategoryRepository {

    public function __construct(Category $model)
    {
        parent::__construct($model);
    }
}
