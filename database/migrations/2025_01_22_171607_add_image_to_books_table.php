<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('books', function (Blueprint $table) {
        $table->string('image')->nullable();  // Добавяме колоната за изображение
    });
}

public function down()
{
    Schema::table('books', function (Blueprint $table) {
        $table->dropColumn('image');  // В случай на връщане назад, изтриваме колоната
    });
}
};
