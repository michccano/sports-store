<?php

namespace App\Repository\MakeupToken;

use App\Models\MakeupToken;
use App\Repository\Base\BaseRepository;

class MakeupTokenRepository extends BaseRepository implements IMakeupTokenRepository {

    public function __construct(MakeupToken $model)
    {
        parent::__construct($model);
    }
}
