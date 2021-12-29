<?php

use App\Models\PushToken;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePushTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('push_tokens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->enum('platform', [PushToken::PLATFORM_IOS, PushToken::PLATFORM_ANDROID]);
            $table->string('device_id', 200)->index();
            $table->string('token', 200)->index();
            $table->enum('token_type', [PushToken::TOKEN_TYPE_FIREBASE])->default(PushToken::TOKEN_TYPE_FIREBASE);
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
        Schema::dropIfExists('push_tokens');
    }
}
