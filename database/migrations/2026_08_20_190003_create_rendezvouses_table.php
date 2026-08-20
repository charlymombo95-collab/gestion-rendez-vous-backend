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
        Schema::create('rendezvouses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('medecin_id')->constrained('medecins')->onDelete('cascade');
            $table->date('date');
            $table->time('heure');
            $table->enum('status', ['en attente', 'confirmé', 'annulé'])->default('en attente');
            $table->timestamps();
            //contrainte d'unicité pour éviter les doublons de rendez-vous pour le même patient et le même médecin à la même date et heure
            $table->unique(['medecin_id', 'date', 'heure'],);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rendezvouses');
    }
};
