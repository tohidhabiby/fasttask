<?php

use App\Models\User\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(User::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string(User::FIRST_NAME);
            $table->string(User::LAST_NAME);
            $table->string(User::INTERNATIONAL_NUMBER)->nullable();
            $table->string(User::MOBILE)->unique();
            $table->string(User::PHONE)->nullable();
            $table->string(User::OTHER_CONTACT_WAY)->nullable();
            $table->string(User::EMAIL)->nullable()->unique();
            $table->string(User::POST_CODE);
            $table->string(User::USERNAME)->unique();
            $table->text(User::BEST_TIME_FOR_CALL)->nullable();
            $table->text(User::ADDRESS);
            $table->enum(User::GENDER, User::$genders)
                ->comment(implode(', ', User::$genders));
            $table->timestamp('email_verified_at')->nullable();
            $table->string(User::PASSWORD);
            $table->timestamp(User::LAST_LOGIN)->nullable();
            $table->enum(User::SECURITY_QUESTION, User::$questions)
                ->nullable()
                ->comment(implode(',', User::$questions));
            $table->string(User::SECURITY_ANSWER)->nullable();
            $table->boolean(User::IS_ACTIVE)->default(true);
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
        Schema::dropIfExists(User::TABLE);
    }
}
