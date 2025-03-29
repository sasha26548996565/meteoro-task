<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('knives', function (Blueprint $table) {
            $table->id();

            $table->string('material');
            $table->string('blade_length');
            $table->string('handle');

            $table->foreignIdFor(User::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('knives');
    }
};
