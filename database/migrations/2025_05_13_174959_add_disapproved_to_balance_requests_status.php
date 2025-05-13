<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDisapprovedToBalanceRequestsStatus extends Migration
{
    public function up()
    {
        Schema::table('balance_requests', function (Blueprint $table) {
            $table->enum('status', ['pending','approved','disapproved'])
                  ->default('pending')
                  ->change();
        });
    }

    public function down()
    {
        Schema::table('balance_requests', function (Blueprint $table) {
            $table->enum('status', ['pending','approved'])
                  ->default('pending')
                  ->change();
        });
    }
}
