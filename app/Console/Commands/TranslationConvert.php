<?php

namespace App\Console\Commands;

use ReflectionClass;
use Illuminate\Support\Str;
use Spatie\Sluggable\HasSlug;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Spatie\Translatable\HasTranslations;
use Modules\Core\Traits\HasSlugTranslation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Authorization\Entities\Permission;
use Astrotomic\Translatable\Contracts\Translatable;

// use Modules\Authorization\Entities\Permission;

class TranslationConvert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trans:convert {class : The class model} ';
    protected $pathModel = "";
    protected $relationTable = null;
    protected $translationAttribute = [];

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert model Translation to spaita translation for class argument';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $class = $this->argument('class');
        


        $model                  = new $class;

        $haveTrans              =  $model instanceof Translatable ;

        if ($haveTrans) {
            $modelTranslation       =(new $model->translationModel);
            $this->relationTable    = $modelTranslation->getTable();
        }
       

        $reflector = new ReflectionClass($model);
        $this->pathModel = $reflector->getFileName();
        $this->translationAttribute = $model->translatedAttributes ?? $model->translatable;
     
        if ($this->confirm('Make migration to model to add translate colum', true)) {
            //
            $this->addColum($model);
        }


        if ($haveTrans &&  $this->confirm('Handle model with Spaita and remove old Astrotomic package', true)) {
            //
            $this->handleModelToSpaita($model);
        
        }

        if ($this->confirm('Get the data from the old model ', true)) {
            //
            $this->addData($model);
        }

        if ($haveTrans &&  $this->confirm('Remove Model translation file and database', true)) {
            //
            $this->removeOldTranslationModel($modelTranslation);
        }

        $this->info("done");
    }


    public function addColum($model)
    {
        Schema::table($model->getTable(), function ($table) use ($model) {
            $translationAttribute   = $this->translationAttribute;

            foreach ($translationAttribute as $attribute) {
                if (!Schema::hasColumn($model->getTable(), $attribute)) {
                    $table->json($attribute)->nullable()->after("id");
                }
            }

            if ($this->hasSlug($model) && !Schema::hasColumn($model->getTable(), "slug")) {
                $table->string("slug")->unique()->nullable();
            }
        });
        $this->info("Done create attributes ", implode(",", $this->translationAttribute ?? []));
    }

    public function addData($model)
    {
        $query = $model->query();
        if ($this->checkUseSoftDelete($model)) {
            $query->withTrashed();
        }

        $bar = $this->output->createProgressBar((clone $query)->count());

        $query->chunk(200, function ($models) use ($bar) {
            foreach ($models as $model) {
                $data = [];
                $transitionsData = \DB::table($this->relationTable ??  Str::singular($model->getTable())."_translations")->where($model->getForeignKey(), $model->id)->get();
                foreach ($transitionsData as $trans) {
                    foreach ($this->translationAttribute as $attribute) {
                        if ($attribute == "slug") {
                            continue;
                        }
                        $data[$attribute][$trans->locale] =  $trans->{$attribute};
                    }
                };

              
                $model->update($data);
                $bar->advance();
            }
        });

        $bar->finish();

        $this->info("done handle model ");
    }

    public function checkUseSoftDelete($model)
    {
        return in_array(SoftDeletes::class, class_uses($model));
    }

    public function handleModelToSpaita($model)
    {
        $string = "";

    
        $lines = file($this->pathModel);
    

        foreach ($lines as $key => $value) {
            $value  = str_replace("implements TranslatableContract", "", $value);
            $value  = str_replace('translatedAttributes', 'translatable', $value);
            $value  = str_replace('Translatable', "HasTranslations", $value);
            if (str_contains($value, "use Astrotomic")  || str_contains($value, "translationModel")) {
                continue;
            }
            if (str_contains($value, "with")) {
                $value = str_replace("'translations'", "", $value);
                $value = str_replace('"translations"', "", $value);
            }
           
            if (str_contains($value, "fillable")) {
                $value = "\t protected \$fillable 					= ". json_encode(array_merge($model->getFillable(), $this->translationAttribute)) .";".PHP_EOL ;
            }
            
            $string .= $value ;
        }

       

        $string = Str::replaceFirst('class', "use ".HasTranslations::class.";".PHP_EOL."class", $string);

        if ($this->confirm('Add translation slug', false)) {
            $string = Str::replaceFirst('class', "use ".HasSlugTranslation::class.";".PHP_EOL."class", $string);
            $string = Str::replaceFirst('{', "{ ".PHP_EOL."\t\t use HasSlugTranslation ;", $string);
        }

       
      


       
        
        File::put($this->pathModel, $string);
        
        $this->info("handle Model with spaita");
    }

    public function removeOldTranslationModel($model)
    {
        $reflector = new ReflectionClass($model);
        File::delete($reflector->getFileName());
        Schema::dropIfExists($model->getTable());
        $this->info("Delete model file and database file");
    }


    public function hasSlug($model)
    {
        return in_array(HasSlug::class, class_uses($model));
    }
}
