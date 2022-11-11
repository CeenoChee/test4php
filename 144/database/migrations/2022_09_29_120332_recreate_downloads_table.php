<?php

use App\Models\DownloadCategory;
use App\Models\DownloadCategoryTranslation;
use App\Models\Language;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RecreateDownloadsTable extends Migration
{
    public function up()
    {
        Schema::table('download_categories', function (Blueprint $table) {
            $table->nestedSet();
        });

        Schema::table('download_download_category', function (Blueprint $table) {
            $table->renameColumn('download_group_id', 'download_category_id');
            $table->integer('sort')->default(1);
        });

        Schema::create('download_category_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('download_category_id');
            $table->bigInteger('Nyelv_ID');
            $table->string('name');
            $table->string('slug')->index();
            $table->text('brief')->nullable();
            $table->timestamps();

            $table->foreign('download_category_id')->references('id')->on((new DownloadCategory())->getTable())->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('Nyelv_ID')->references('Nyelv_ID')->on((new Language())->getTable())->cascadeOnUpdate()->cascadeOnDelete();
        });

        $this->transferOldTranslations();
    }

    public function down()
    {
        $this->reverseTranslations();

        Schema::table('download_download_category', function (Blueprint $table) {
            $table->renameColumn('download_category_id', 'download_group_id');
            $table->dropColumn('sort');
        });

        Schema::table('download_categories', function (Blueprint $table) {
            $table->dropNestedSet();
        });

        Schema::dropIfExists('download_category_translations');
    }

    protected function transferOldTranslations()
    {
        $transes = DB::table('translations')->where('translatable_type', 'download_groups')->get();

        foreach ($transes as $trans) {
            DownloadCategoryTranslation::create([
                'download_category_id' => $trans->translatable_id,
                'Nyelv_ID' => $trans->language_id,
                'name' => $trans->name,
                'brief' => $trans->description,
                'slug' => $trans->slug,
                'created_at' => $trans->created_at,
                'updated_at' => $trans->updated_at,
            ]);
        }

        DB::table('translations')->where('translatable_type', 'download_groups')->delete();
    }

    protected function reverseTranslations()
    {
        $transes = DownloadCategoryTranslation::all();

        foreach ($transes as $trans) {
            DB::table('translations')->insert([
                'translatable_id' => $trans->download_category_id,
                'language_id' => $trans->Nyelv_ID,
                'name' => $trans->name,
                'description' => $trans->brief,
                'slug' => $trans->slug,
                'created_at' => $trans->created_at,
                'updated_at' => $trans->updated_at,
            ]);
        }

        DownloadCategoryTranslation::truncate();
    }
}
