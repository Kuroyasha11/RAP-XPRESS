 <?php

    use App\Models\Courier;
    use App\Models\PickUp;
    use App\Models\Shipping;
    use App\Models\User;
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class CreatePackagesTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('packages', function (Blueprint $table) {
                $table->id();
                $table->string('slug')->unique();
                $table->foreignIdFor(User::class);
                $table->foreignIdFor(Shipping::class);
                $table->string('nama');
                $table->integer('jumlah');
                $table->bigInteger('hargapaket');
                $table->text('alamat');
                $table->string('namapemohon');
                $table->string('telepon');
                $table->string('namapenerima');
                $table->string('no_hp');
                $table->string('keterangan')->nullable();
                $table->boolean('cod')->default(false);
                $table->boolean('terima')->default(false);
                $table->boolean('diambil')->default(false);
                $table->boolean('selesai')->default(false);
                $table->string('foto')->nullable();
                $table->string('image')->nullable();
                $table->foreignIdFor(Courier::class)->nullable();
                $table->foreignIdFor(PickUp::class)->nullable();
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
            Schema::dropIfExists('packages');
        }
    }
