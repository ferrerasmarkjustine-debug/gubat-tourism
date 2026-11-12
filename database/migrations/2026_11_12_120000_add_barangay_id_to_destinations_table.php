<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('destinations', 'barangay_id')) {
            Schema::table('destinations', function (Blueprint $table) {
                $table->foreignId('barangay_id')->nullable()->after('municipality_id')->constrained('barangays')->nullOnDelete();
            });
        }

        // Ensure key Gubat barangays exist
        $gubatId = DB::table('municipalities')->where('name', 'Gubat')->value('id') ?? 1;

        $keyBarangays = ['Rizal', 'Buenavista', 'Poblacion', 'Cota-na-daco', 'Bulacao', 'Bentuco', 'Pinontingan', 'Panganiban', 'Ariman', 'Tigkiw', 'Paco'];
        foreach ($keyBarangays as $bName) {
            $exists = DB::table('barangays')->where('name', $bName)->where('municipality_id', $gubatId)->first();
            if (!$exists) {
                DB::table('barangays')->insert([
                    'municipality_id' => $gubatId,
                    'name' => $bName,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        $allBarangays = DB::table('barangays')->where('municipality_id', $gubatId)->pluck('id', 'name');

        // Backfill existing destinations with appropriate barangay_id
        $nameToBarangay = [
            'Lola Sayong Surf Camp' => 'Rizal',
            'Rizal Beach' => 'Rizal',
            'Barcelona Old Church' => 'Poblacion',
            'St. Anthony of Padua Parish' => 'Cota-na-daco',
            'Bulacao Abaca Weaving Association' => 'Bulacao',
            'Bentuco Clay Crafts' => 'Bentuco',
            'Gubat Heritage Ancestral Houses' => 'Poblacion',
        ];

        foreach ($nameToBarangay as $destName => $bName) {
            if (isset($allBarangays[$bName])) {
                DB::table('destinations')
                    ->where('name', 'like', "%{$destName}%")
                    ->update(['barangay_id' => $allBarangays[$bName]]);
            }
        }

        // For any remaining destinations without barangay_id, assign Rizal or first barangay
        $defaultBarangayId = $allBarangays['Rizal'] ?? $allBarangays->first();
        if ($defaultBarangayId) {
            DB::table('destinations')
                ->whereNull('barangay_id')
                ->update(['barangay_id' => $defaultBarangayId]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('destinations', 'barangay_id')) {
            Schema::table('destinations', function (Blueprint $table) {
                $table->dropForeign(['barangay_id']);
                $table->dropColumn('barangay_id');
            });
        }
    }
};

