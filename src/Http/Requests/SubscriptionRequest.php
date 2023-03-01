<?php

namespace Botble\Subscription\Http\Requests;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class SubscriptionRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => 'required',
            'amount' => 'required|integer|min:0',
            'product_upload_limit' => 'required|integer|min:0',
            'duration' => 'required',
            'status' => Rule::in(BaseStatusEnum::values()),
        ];
    }
}
