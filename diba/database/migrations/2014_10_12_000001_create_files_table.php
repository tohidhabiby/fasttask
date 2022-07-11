<?php

use App\Models\File\File;
use App\Models\File\RootFile;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(File::TABLE, function (Blueprint $table) {
            $table->id();
            $table->foreignId(FILE::USER_ID)->constrained();
            $table->foreignId(File::ROOT_FILE_ID)->constrained();
            $table->string(File::NAME);
            $table->string(File::EXTENSION);
            $table->boolean(File::ENABLED)->default(false);
            $table->boolean(File::IS_PUBLIC)->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(File::TABLE);
    }
}
