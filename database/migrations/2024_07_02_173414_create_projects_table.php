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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();

            $table->string('check_time')->nullable();
            $table->string('brand_name')->nullable();
            $table->string('tech_check')->nullable();
            $table->string('object_check')->nullable();
            $table->string('firm_name')->nullable();
            $table->boolean('firm_type')->nullable(); // 0=iravabanakan 1= fizikakan ete fizikakan a chuni i_address ev hvhh
            $table->string('hvhh')->nullable();
            $table->foreignId('i_marz_id')->nullable()->references('id')->on('states')->onDelete('cascade');
            $table->string('i_address')->nullable();
            $table->foreignId('w_marz_id')->nullable()->references('id')->on('states')->onDelete('cascade');
            $table->string('w_address')->nullable();
            $table->date('start_act')->nullable();

            $table->foreignId('ceorole_id')->nullable()->references('id')->on('seoroles')->onDelete('cascade');
           $table->foreignId('type_id')->nullable()->references('id')->on('object_types')->onDelete('cascade');

            $table->string('ceo_name')->nullable();
            $table->string('ceo_phone')->nullable();

            $table->string('fin_contact')->nullable();

            $table->string('andznagir')->nullable(); // fizikakan firm_type = 1
                   $table->string('soc')->nullable(); // fizikakan firm_type = 1
            $table->string('id_card')->nullable(); // fizikakan firm_type = 1

            $table->string('firm_email')->nullable();
            $table->string('firm_bank')->nullable();
            $table->string('firm_bank_hh')->nullable();
            $table->foreignId('price_id')->nullable()->references('id')->on('prices')->onDelete('cascade');
            $table->timestamp('paymanagir_time')->useCurrent();
            $table->date('paymanagir_start')->nullable();
            $table->boolean('signed')->nullable();
            $table->string('status')->nullable();

            $table->foreignId('user_id')->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('worker_id')->nullable()->references('id')->on('users')->onDelete('cascade');

            //          $table->double('paymanagir_id_marz')->nullable();
            $table->string('x_gps')->nullable();
            $table->string('y_gps')->nullable();
            $table->string('nkar')->nullable();
            $table->string('their_hardware')->nullable();
            $table->string('connection_type')->nullable();
            $table->date('end_dimum')->nullable();
            $table->date('paymanagir_end')->nullable();

            $table->boolean('paymanagir_received')->nullable();
            $table->boolean('status_edit')->default(0);
            $table->string('ident_id', 4)->unique()->nullable();
            /**
             * obshi mitq
             * mi hat el knopka aktivacnel
             *
             *
             */

//
//
//            $table->string('w_city')->nullable();
//
//            $table->string('simnumber')->nullable();
//            $table->string('simcartinfo')->nullable();
//
//
//
//            $table->string('patasxanatu_two')->nullable();
//            $table->string('i_address')->nullable();
//
//
//
//            $table->string('connection_phone_1')->nullable();
//            $table->string('connection_phone_2')->nullable();
//
//            $table->boolean('status_edit')->default(true);
////            $table->string('partq')->nullable();
//            $table->boolean('active')->default(0);
//            $table->boolean('paymanagir_id')->default(0);
//
//
//            $table->foreignId('simlist_1')->nullable()->references('id')->on('simlists')->onDelete('cascade');
//            $table->foreignId('simlist_2')->nullable()->references('id')->on('simlists')->onDelete('cascade');
//            $table->foreignId('price_id')->constrained('prices')->onDelete('cascade');
//              // $table->foreignId('simlist_id')->constrained('simlists')->onDelete('cascade');


            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
