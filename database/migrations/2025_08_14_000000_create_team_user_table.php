<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamUserTable extends Migration
{
    public function up()
    {
        Schema::create('team_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('email');
            $table->enum('role', ['owner', 'lead', 'member'])->default('member');
            $table->enum('status', ['invited', 'active'])->default('invited');
            $table->string('invitation_token', 32)->nullable()->unique();
            $table->timestamp('invitation_sent_at')->nullable();
            $table->timestamps();

            $table->unique(['team_id', 'user_id']);
            $table->unique(['team_id', 'email']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('team_user');
    }
}
