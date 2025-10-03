    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up(): void
        {
            Schema::create('prodi', function (Blueprint $table) {
                $table->string('id_prodi')->primary();
                $table->string('nm_prodi');
                $table->string('id_jenjang_pendidikan')->nullable();
                // Kolom lain bisa ditambahkan jika perlu
            });
        }

        public function down(): void
        {
            Schema::dropIfExists('prodi');
        }
    };
    
