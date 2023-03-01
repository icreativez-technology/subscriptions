<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('subscription_translations')) {
            Schema::create('subscription_translations', function (Blueprint $table) {
                $table->string('lang_code');
                $table->integer('subscription_id');
                $table->string('name', 255)->nullable();
                $table->string('image', 255)->nullable();
                $table->string('url', 255)->nullable();
                $table->primary(['lang_code', 'subscription_id'], 'subscription_translations_primary');
            });
        }

    }

    public function down(): void
    {
        Schema::dropIfExists('subscription_translations');
    }
};
