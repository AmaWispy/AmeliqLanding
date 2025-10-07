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
        Schema::table('blocks', function (Blueprint $table) {
            // Удаляем старые поля
            $table->dropColumn(['type', 'css_classes', 'content']);
            
            // Добавляем новые поля
            $table->string('key')->nullable()->after('title');
            $table->string('anchor')->nullable()->after('key');
            $table->string('photo')->nullable()->after('anchor');
            $table->string('video')->nullable()->after('photo');
            $table->json('fields')->nullable()->after('video');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blocks', function (Blueprint $table) {
            // Возвращаем старые поля
            $table->string('type')->after('title');
            $table->text('css_classes')->nullable()->after('type');
            $table->json('content')->nullable()->after('css_classes');
            
            // Удаляем новые поля
            $table->dropColumn(['key', 'anchor', 'photo', 'video', 'fields']);
        });
    }
};
