<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            // Удаляем старые соцсети
            $table->dropColumn(['facebook_url', 'twitter_url', 'instagram_url', 'linkedin_url']);
            
            // Добавляем новые
            $table->string('telegram_url')->nullable()->after('address');
            $table->string('vk_url')->nullable()->after('telegram_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            // Возвращаем старые поля
            $table->string('facebook_url')->nullable()->after('address');
            $table->string('twitter_url')->nullable()->after('facebook_url');
            $table->string('instagram_url')->nullable()->after('twitter_url');
            $table->string('linkedin_url')->nullable()->after('instagram_url');
            
            // Удаляем новые
            $table->dropColumn(['telegram_url', 'vk_url']);
        });
    }
};
