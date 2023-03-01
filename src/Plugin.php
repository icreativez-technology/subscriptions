<?php

namespace Botble\Subscription;

use Botble\PluginManagement\Abstracts\PluginOperationAbstract;
use Botble\Setting\Models\Setting;
use Illuminate\Support\Facades\Schema;

class Plugin extends PluginOperationAbstract
{
    public static function remove()
    {

        Schema::dropIfExists('subscriptions');
        Schema::dropIfExists('subscriptions_translations');

        Setting::query()
            ->whereIn('key', [
                'enable_subscription_schema',
            ])
            ->delete();
    }
}
