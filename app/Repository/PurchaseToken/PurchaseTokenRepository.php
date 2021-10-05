<?php

namespace App\Repository\PurchaseToken;

use App\Models\PurchaseToken;
use App\Repository\Base\BaseRepository;

class PurchaseTokenRepository extends BaseRepository implements IPurchaseTokenRepository {

    public function __construct(PurchaseToken $model)
    {
        parent::__construct($model);
    }
}
