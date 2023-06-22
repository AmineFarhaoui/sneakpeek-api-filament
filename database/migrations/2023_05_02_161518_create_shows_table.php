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
        Schema::create('shows', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('share_url')->nullable();
            $table->text('share_text')->nullable();
            $table->text('external_group_url')->nullable();
            $table->text('description')->nullable();
            $table->text('in_app_description')->nullable();
            $table->text('footer_note')->nullable();
            $table->float('price')->nullable();
            $table->integer('transaction_costs')->nullable();
            $table->text('cast')->nullable();
            $table->text('creators')->nullable();
            $table->text('production')->nullable();
            $table->json('introduction_texts')->nullable();
            $table->text('allows_in_app_registration')->nullable();
            $table->text('allows_external_registration')->nullable();
            $table->string('ios_reference')->nullable();
            $table->text('preview_token')->nullable();
            $table->text('gua_id')->nullable();
            $table->text('ga4_id')->nullable();
            $table->text('gtm_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shows');
    }
};
