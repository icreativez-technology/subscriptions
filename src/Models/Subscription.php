<?php

namespace Botble\Subscription\Models;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;

class Subscription extends BaseModel
{
    protected $table = 'subscriptions';

    protected $fillable = [
        'name',
        'category_id',
        'amount',
        'product_upload_limit',
        'duration',
        'addons',
        'image',
        'status'
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class
    ];

}
