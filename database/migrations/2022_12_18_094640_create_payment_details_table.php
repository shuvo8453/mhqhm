<?php
//@abdullah zahid joy
use App\Models\FeeType;
use App\Models\Invoice;
use App\Models\Payment;
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
        Schema::create('payment_details', function (Blueprint $table) {
            $table->id();
            //add your columns name from here
            $table->foreignIdFor(Payment::class)->constrained()->onDelete("cascade");
            $table->foreignIdFor(FeeType::class)->constrained()->onDelete("cascade");
            $table->double("paid_amount",10,2);
            $table->double("due_amount",10,2);
            $table->double("actual_amount",10,2);
            //mandatory fields
            $table->userLog();
            $table->status();

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
        Schema::dropIfExists('payment_details');
    }
};
