<?php

use App\Helpers\SchemaView;
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
        SchemaView::create("CREATE OR REPLACE VIEW vbulan AS SELECT 1 as No, 'Januari' as Bulan UNION ALL SELECT 2 as Nomor, 'Februari' as Bulan UNION ALL SELECT 3 as Nomor, 'Maret' as Bulan UNION ALL SELECT 4 as Nomor, 'April' as Bulan UNION ALL SELECT 5 as Nomor, 'Mei' as Bulan UNION ALL SELECT 6 as Nomor, 'Juni' as Bulan UNION ALL SELECT 7 as Nomor, 'Juli' as Bulan UNION ALL SELECT 8 as Nomor, 'Agustus' as Bulan UNION ALL SELECT 9 as Nomor, 'September' as Bulan UNION ALL SELECT 10 as Nomor, 'Oktober' as Bulan UNION ALL SELECT 11 as Nomor, 'November' as Bulan UNION ALL SELECT 12 as Nomor, 'Desember' as Bulan;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('view_vbulan');
    }
};
