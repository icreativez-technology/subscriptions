<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class () extends Migration {
    public function up(): void
    {

        Schema::create('subscription', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->integer('amount');
            $table->integer('product_upload_limit');
            $table->text('duration');
            $table->text('addons');
            $table->string('image', 255)->nullable();
            $table->string('status', 60)->default('published');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscription');
    }
};
