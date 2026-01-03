<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('room_reviews', function (Blueprint $table) {
            $table->text('admin_reply')->nullable()->after('review');
            $table->unsignedBigInteger('admin_reply_user_id')->nullable()->after('admin_reply');
            $table->timestamp('admin_reply_at')->nullable()->after('admin_reply_user_id');
        });
    }

    public function down(): void
    {
        Schema::table('room_reviews', function (Blueprint $table) {
            $table->dropColumn(['admin_reply', 'admin_reply_user_id', 'admin_reply_at']);
        });
    }
};
