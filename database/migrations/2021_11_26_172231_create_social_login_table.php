<?php

use App\Models\SocialLogin;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialLoginTable extends Migration
{
    /**
     * Run the migrations.SocialLogin
     *
     * @return void
     */
    public function up()
    {
        Schema::create('social_login', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('external_id', 200)->index();
            $table->enum('social_site', [SocialLogin::SOCIAL_SITE_SNAPCHAT]);

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
        Schema::dropIfExists('social_login');
    }
}
