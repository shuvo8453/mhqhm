<?php
//@abdullah zahid joy
use App\Models\ClassTime;
use App\Models\Group;
use App\Models\Routine;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routine_details', function (Blueprint $table) {
            $table->id();
            //add your columns name from here
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->unsignedBigInteger('group_id')->nullable();
            $table->foreignIdFor(ClassTime::class)->constrained()->onDelete("cascade");
            $table->foreignIdFor(Routine::class)->constrained()->onDelete("cascade");
            $table->string("note")->nullable();
            $table->boolean("is_break")->default(0);
            $table->timestamps();
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete("cascade");
            $table->foreign('group_id')->references('id')->on('groups')->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('routine_details');
    }
};
