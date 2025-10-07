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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            
            // Основные настройки
            $table->string('site_name')->nullable();
            $table->string('site_title')->nullable();
            $table->text('site_description')->nullable();
            $table->text('site_keywords')->nullable();
            
            // Изображения
            $table->string('favicon')->nullable();
            $table->string('logo')->nullable();
            $table->string('og_image')->nullable();
            
            // Контакты
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            
            // Социальные сети
            $table->string('facebook_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('youtube_url')->nullable();
            
            // Аналитика и метрики
            $table->text('google_analytics')->nullable();
            $table->text('yandex_metrika')->nullable();
            $table->text('google_tag_manager')->nullable();
            $table->text('facebook_pixel')->nullable();
            
            // Дополнительные скрипты
            $table->text('head_scripts')->nullable();
            $table->text('body_scripts')->nullable();
            
            // Robots и sitemap
            $table->text('robots_txt')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
