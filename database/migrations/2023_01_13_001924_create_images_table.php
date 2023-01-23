<?php

use App\Enums\ImageTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $types = collect(ImageTypeEnum::cases())->map(fn ($el) => $el->value)->toArray();

        Schema::create('images', function (Blueprint $table) use ($types) {
            $table->id();
            $table->string('path')->nullable(false);
            $table->string('origin_name')->nullable(false);
            $table->string('extension')->nullable(false);
            $table->integer('size')->nullable(false);
            $table->string('width')->nullable(false);
            $table->string('height')->nullable(false);
            $table->enum('type', [...$types])->default(ImageTypeEnum::MAIN_IMAGE->value);
            $table->integer('imageable_id')->default(0);
            $table->string('imageable_type')->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images');
    }
}
