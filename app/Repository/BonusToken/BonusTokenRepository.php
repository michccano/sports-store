<?php

namespace App\Repository\BonusToken;

use App\Models\BonusToken;
use App\Repository\Base\BaseRepository;

class BonusTokenRepository extends BaseRepository implements IBonusTokenRepository {

    public function __construct(BonusToken $model)
    {
        parent::__construct($model);
    }
}
