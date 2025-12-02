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
            // Request Modal
            $table->string('popup_request_title')->nullable();
            $table->text('popup_request_subtitle')->nullable();
            $table->string('popup_request_button_text')->nullable();

            // Exit Intent Popup
            $table->string('popup_exit_title')->nullable();
            $table->text('popup_exit_subtitle')->nullable();
            $table->string('popup_exit_button_text')->nullable();
            $table->string('popup_exit_link')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'popup_request_title',
                'popup_request_subtitle',
                'popup_request_button_text',
                'popup_exit_title',
                'popup_exit_subtitle',
                'popup_exit_button_text',
                'popup_exit_link',
            ]);
        });
    }
};
