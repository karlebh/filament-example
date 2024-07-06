<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('patients', function (Blueprint $table) {
      $table->id();
      $table->date('dob');
      $table->string('name');
      $table->foreignIdFor(User::class)->cascadeOnDelete();
      $table->string('type');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('patients');
  }
};
