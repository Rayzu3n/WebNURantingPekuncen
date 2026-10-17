<?php

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Support\NikProtection;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('members', function (Blueprint $table): void {
            $table->string('nik_hash', 64)->nullable()->after('nik');
        });

        $members = DB::table('members')->select('id', 'nik')->get();

        foreach ($members as $member) {
            $storedNik = (string) $member->nik;
            try {
                $plainNik = Crypt::decryptString($storedNik);
            } catch (DecryptException) {
                $plainNik = $storedNik;
            }

            DB::table('members')->where('id', $member->id)->update([
                'nik' => Crypt::encryptString($plainNik),
                'nik_hash' => NikProtection::fingerprint($plainNik),
            ]);
        }

        Schema::table('members', function (Blueprint $table): void {
            $table->dropUnique(['nik']);
            $table->text('nik')->change();
            $table->unique('nik_hash');
        });

        Schema::create('membership_applications', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('registration_number', 40)->unique();
            $table->string('access_token_hash', 64)->unique();
            $table->text('nik');
            $table->string('nik_hash', 64)->unique();
            $table->string('birth_place');
            $table->date('birth_date');
            $table->string('gender', 20);
            $table->string('phone', 20)->nullable();
            $table->text('address');
            $table->text('photo')->nullable();
            $table->string('status', 32)->default('pending_review')->index();
            $table->text('admin_note')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('membership_applications');

        $members = DB::table('members')->select('id', 'nik')->get();

        foreach ($members as $member) {
            DB::table('members')->where('id', $member->id)->update([
                'nik' => Crypt::decryptString((string) $member->nik),
            ]);
        }

        Schema::table('members', function (Blueprint $table): void {
            $table->dropUnique(['nik_hash']);
            $table->dropColumn('nik_hash');
            $table->string('nik')->change();
            $table->unique('nik');
        });
    }
};
