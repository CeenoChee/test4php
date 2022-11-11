<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('email')->unique();
                $table->string('password');
                $table->string('Vezeteknev');
                $table->string('Keresztnev');
                $table->string('Cegnev');
                $table->string('Beosztas')->nullable();;
                $table->string('Telefon')->nullable();;
                $table->string('Mobil')->nullable();;
                $table->string('Fax')->nullable();;
                $table->bigInteger('Orszag_ID');
                $table->string('Helyseg');
                $table->string('UtcaHSzam');
                $table->string('IrSzam');
                $table->string('Adoszam');
                $table->string('EUAdoszam')->nullable();;
                $table->string('Cegjegyzekszam');
                $table->boolean('TelepitoiAr')->default(false);
                $table->rememberToken();
                $table->string('token')->nullable();
                $table->boolean('verified')->default(false);
                $table->boolean('newsletter');
                $table->timestamp('newsletter_update')->nullable();
                $table->dateTime('banned_at')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
