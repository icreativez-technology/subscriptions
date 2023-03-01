<?php

Route::group(['namespace' => 'Botble\Subscription\Http\Controllers', 'middleware' => ['web', 'core']], function () {
    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {
        Route::group(['prefix' => 'subscriptions', 'as' => 'subscription.'], function () {
            Route::resource('', 'SubscriptionController')->parameters(['' => 'subscription']);
            Route::delete('items/destroy', [
                'as' => 'deletes',
                'uses' => 'SubscriptionController@deletes',
                'permission' => 'subscription.destroy',
            ]);
        });
    });
});
