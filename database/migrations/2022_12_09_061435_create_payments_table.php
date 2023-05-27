<?php
//@abdullah zahid joy
use App\Models\Invoice;
use App\Models\User;
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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            //add your columns name from here
            $table->double("total_paid_amount",10,2);
            $table->double("total_due_amount",10,2);
            $table->double("total_actual_amount",10,2);
            $table->date('date')->nullable();
            $table->enum('status',['success',"failed"])->default("success");
            $table->enum("method",['cash' , 'online'])->default("cash");
            $table->foreignIdFor(User::class)->constrained()->onDelete("cascade");

            //mandatory fields
            $table->userLog();
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
        Schema::dropIfExists('payments');
    }
};
