<?php
//@abdullah zahid joy
use App\Models\FeeType;
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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->onDelete("cascade");
            $table->foreignIdFor(FeeType::class)->constrained()->onDelete("cascade");
            $table->string('date')->nullable();
            $table->double("actual_amount",10,2);
            $table->double("due",10,2);
            $table->double("paid",10,2)->default(0);
            $table->enum('status', ['paid', 'due'])->default('due');
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
        Schema::dropIfExists('invoices');
    }
};
