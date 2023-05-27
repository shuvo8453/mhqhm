<?php
//@abdullah zahid joy
namespace App\Helpers;

use App\Helpers\Trait\CreateFrontEnd;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PharIo\Version\Exception;

/**
 *
 */
class Module
{
    use CreateFrontEnd;

    /**
     * @param $string
     * @return string
     */
    public static function lcFirst($string): string
    {
        return lcfirst($string);
    }

    /**
     * @param $string
     * @return string
     */
    public static function ucFirst($string): string
    {
        return ucfirst($string);
    }

    /**
     * @param string $name
     * @param $field
     * @return bool|false
     */
    public static function create(string $name , $field): bool
    {
        //make table field
        $dbField = self::makeTableField($field );
        $formBuilder = self::makeInputField($field);
        $indexData = self::makeIndexData($field);

        //create model and migration and model and add database field
        if(! $migration = self::generateModelAndMigration($name,$indexData['files'],$dbField) ) return false;

        //generate view file
        if(! self::generateFrontend($name , $formBuilder, $indexData)) return false;

        //create controller
        if(! self::generateController($name , $indexData['files'])) return false;

        //add route name in backend.php
        if(! self::addRoute($name)) return false;

        //import controller name
        self::importControllerInRoute($name);

        //save module recode
        return self::storeModuleInfo( $name , $migration );
    }

    /**
     * @param $name
     * @return bool
     */
    public static function checkFile($name): bool
    {
       return file_exists($name);
    }

    /**
     * @param $db
     * @param $field
     * @return
     */
    public static function generateSchema($db , $field): bool|int
    {
        if(!self::checkFile(base_path().'/database/migrations/' . $db)) return false;
        $search = "//add your columns name from here";
        $replace = $search. "\n \t \t \t".  $field;

        return self::addFileContent($search,$replace,base_path().'/database/migrations/' . $db);

    }

    /**
     * @param $name
     * @param $files
     * @param $field
     * @return \Exception|false|mixed|Exception|null
     */
    public static function generateModelAndMigration( $name, $files , $field )
    {
        try {
            if(self::checkFile(app_path('Models/' . ucfirst($name) . '.php'))) return false;

            //create model and migration file
            Artisan::call('make:model',['name'=> self::ucFirst($name), '-m' => 'default']) ;

            if(!self::checkFile(app_path('Models/' . ucfirst($name) . '.php')) ) return false;

            $fileAttribute = self::makeFileAttributeForModel($files);

            $search = '//add your model content here';
            $replace = $fileAttribute. "\n".  $search;
            self::addFileContent($search, $replace, app_path('Models/' . ucfirst($name) . '.php'));
            $migration = self::getFileName(lcfirst($name));
            self::generateSchema($migration , $field );
            return $migration;

        }catch (Exception $ex){
            return $ex;
        }
    }

    static function getFileName(string $keyWord, string $basePath='database/migrations', string $fileBegin='_create_'){
        $files = scandir(base_path($basePath));
        foreach($files as $file){
            if(str_contains($file,$fileBegin.Str::snake(trim($keyWord)))) return $file;
        }
    }

    /**
     * @param array $files
     * @return string
     */
    public static function makeFileAttributeForModel(array $files = []){
        $attribute = "";
        if (!empty($files)){
            foreach ($files as $file){
                $attribute .= "public function get".$file."Attribute(\$value)\n";
                $attribute .= "\t{\n";
                $attribute .= "\t \t if (!empty(\$value)) {\n";
                $attribute .= "\t \t \t return Storage::url(\$value) ;\n";
                $attribute .= "\t \t }\n";
                $attribute .= " \t return null;\n";
                $attribute .= " }\n";

            }
        }
        return $attribute;
    }
    /**
     * @param $name
     * @param array $fileData
     * @return
     */
    public static function generateController($name, array $fileData = [])
    {
        try {
            if (self::checkFile(app_path('Http/Controllers/Backend/' . ucfirst($name) . 'Controller.php'))) return false;

                $controller = "Backend/" . self::ucFirst($name) . "Controller";
                Artisan::call('make:controller', ['name' => $controller, '--type' => "custom"]);
                $result = explode("\r\n", Artisan::output());

                $files = 'private array $files  = ';
                $files .= json_encode($fileData);
                $files .= ";";
                $modelName = 'private string $modelName = "'.ucfirst($name).'";';

                $searchFiles = 'private array $files = [];';
                $searchModelName = 'private string $modelName = "";';

                self::addFileContent($searchFiles, $files, app_path('Http/Controllers/Backend/' . ucfirst($name) . 'Controller.php'));
                self::addFileContent($searchModelName, $modelName, app_path('Http/Controllers/Backend/' . ucfirst($name) . 'Controller.php'));
                return str_contains($result[0], "created successfully.");

        }catch (Exception $ex){
            return $ex;
        }
    }

    /**
     * @param $name
     * @param $migration
     * @return bool
     */
    public static function storeModuleInfo($name , $migration): bool
    {
       return DB::table('modules')->insert([
            'name' => self::ucFirst($name),
            'controller' => self::ucFirst($name)."Controller",
            'route' => self::lcFirst($name).".index",
            'migration' => $migration,
        ]);
    }

    /**
     * @param $name
     * @param $formBuilder
     * @param $indexData
     * @return bool
     */
    public static function generateFrontend($name , $formBuilder , $indexData): bool
    {
        $module = new Module();
        $file = new Filesystem();

        $front_end = $module->getSourceFrontEndPath(self::ucFirst($name));

        $module->makeDirectory( dirname(base_path().'/resources/views/admin/pages/'.ucfirst($name) .'/*' ));

        $contents =  $module->getSourceFrontEnd(self::lcFirst($name),self::ucFirst($name),$formBuilder, $indexData);

        if ($file->exists($contents)) return false;

        $file->put($front_end, $contents);

        return true;
    }

    /**
     * Build the directory if necessary.
     *
     * @param  $path
     * @return string
     */
    protected static function makeDirectory($path): void
    {
        $file = new Filesystem();
        if (! $file->isDirectory($path)) $file->makeDirectory($path, 0777, true, true);

    }


    /**
     * @param $name
     * @return bool|int
     */
    public static function addRoute($name): bool|int
    {
        $search = "//module routes";
        $url = self::lcFirst($name);

        $controller = self::ucFirst($name)."Controller";

        $route = "Route::resource('". $url ."', ".$controller."::Class,['names'=>'".self::ucFirst($name)."']);";

        $replace = $search. "\n \t".  $route;

        return self::addFileContent($search,$replace,base_path('routes/Backend.php'));

    }

    /**
     * @param $name
     * @return bool|int
     */
    public static function importControllerInRoute($name): bool|int
    {
        $search = "use Illuminate\Support\Facades\Route;";

        $controller = self::ucFirst($name)."Controller";
        $import = 'use App\Http\Controllers\Backend\\'.$controller.";";

        $replace = $search. "\n".  $import;

       return self::addFileContent($search,$replace,base_path('routes/Backend.php'));
    }

    /**
     * @param $search
     * @param $replace
     * @param $path
     * @return bool|int
     */
    public static function addFileContent($search, $replace, $path): bool|int
    {
       return file_put_contents( $path , str_replace($search, $replace, file_get_contents( $path)));
    }

    /**
     * @return array
     */
    public static function  getAllDatatype(): array
    {
        return collect([
            'bigInteger' ,
            'boolean' ,
            'char' ,
            'dateTime' ,
            'date' ,
            'decimal' ,
            'double' ,
            'enum' ,
            'float' ,
            'integer' ,
            'longText',
            'mediumInteger',
            'mediumText',
            'smallInteger',
            'string',
            'text',
            'time',
            'timestamp',
            'timestamps',
            'tinyInteger',
            'tinyText',
            'unsignedBigInteger',
            'unsignedDecimal',
            'unsignedInteger',
            'unsignedMediumInteger',
            'unsignedSmallInteger',
            'unsignedTinyInteger',

        ])->toArray();
    }

    /**
     * @return array
     */
    public static function  getAllInputType(): array
    {
        return collect([
            'text' ,
            'password' ,
            'file' ,
            'date' ,
            'textarea' ,
            'number' ,
            'checkbox' ,
            'radio' ,
            'select' ,
        ])->toArray();
    }

    /**
     * @return array
     */
    public static function getAllModel(): array
    {
        return DB::table('modules')->select('name')->get()->toArray();
    }

    /**
     * @param $field
     * @return string
     */
    public static function makeTableField($field): string
    {
        $tableField = "";
        for ($key = 0 ; $key < count($field["type"]); $key++){
            $type = $field['type'][$key];
            $condition = "";
            if(!empty($field['is_nullable'])){
                if($field['is_nullable'][$key] == "yes" ){
                    $condition .= "->nullable()";
                }
            }
            if(!empty($field['is_unique'])){
                if($field['is_unique'][$key] == "yes"){
                    $condition .= "->unique()";
                }
            }
            if(!empty($field['default'])){
                if(!empty($field['default'][$key])){
                    $condition .= "->default('{$field['default'][$key]}')";
                }
            }

            $addition = '';
            if(!empty($field['char'][$key]) && ($type == "char" || $type == "string")){
                $addition .= ",{$field['char'][$key]}";
            }
            if(!empty($field['enum1'][$key]) && !empty($field['enum2'][$key]) && $type == "enum"){
                $addition .= ", ['{$field['enum1'][$key]}','{$field['enum2'][$key]}']";
            }
            if(!empty($field['precision'][$key]) && !empty($field['scale'][$key]) && ($type == "float" || $type == "double" || $type == "decimal" || $type == "unsignedDecimal")){
                $addition .= ", {$field['precision'][$key]},{$field['scale'][$key]}";
            }
            if(!empty($field['foreign'][$key]) && ($type == "bigInteger" || $type == "unsignedBigInteger" || $type == "unsignedInteger" || $type == "unsignedMediumInteger" || $type == "unsignedSmallInteger" || $type == "unsignedTinyInteger")){
                $table =  App::make( 'App\\Models\\'. $field['foreign'][$key] )->getTable();
                $foreign = "\$table->foreign('{$field['name'][$key]}')->references('id')->on('{$table}')->onDelete('cascade');\n";
            }
            $tableField .= "\$table->{$type}('{$field['name'][$key]}'{$addition}){$condition};\n";
            if(!empty($foreign)){
                $tableField .= $foreign;
            }

        }
        //dd($tableField);
        return $tableField;
    }

    /**
     * @param $field
     * @return string
     */
    public static function makeInputField($field ): array
    {
        $createInputField = "";
        $updateInputField = "";
        for ($key = 0 ; $key < count($field["inputType"]); $key++){
            $type = $field['inputType'][$key];
            $name = $field['name'][$key];
            $title = self::ucFirst($field['name'][$key]);
            $condition = "";
            if(!empty($field['is_nullable'])){
                if($field['is_nullable'][$key] == "no" ){
                    $condition .= " required";
                }
            }
            if( $type == 'file'){
                $condition .=" accept=\"image/*\"";
            }
            $enum = [];
            if(!empty($field['enum1'][$key]) && !empty($field['enum2'][$key]) ){
                $enum[] = $field['enum1'][$key];
                $enum[] = $field['enum2'][$key];
            }

            $createInputField .= self::generateInputField("create",$name,$title,$type,$condition,$enum);
            $updateInputField .= self::generateInputField("update",$name,$title,$type,$condition,$enum);
        }

        return [
            'createInputField'=> $createInputField,
            'updateInputField'=> $updateInputField,
        ];

    }

    /**
     *
     * @param $formType
     * @param $name
     * @param $title
     * @param $type
     * @param $condition
     * @param array $enums
     * @return string
     */
    public static function generateInputField($formType ,$name , $title , $type , $condition , array $enums = []): string
    {
        if($formType == "update"){
            $field ="<div class=\"form-group mb-3 edit_{$name}\"> \n";
        }else{
            $field ="<div class=\"form-group mb-3\"> \n";
        }

        if($type == 'text' || $type == 'password' || $type == 'number' || $type == 'date' ){
            if($formType == 'create'){
              $field .="\t<label for=\"{$name}\" class=\"form-label \">{$title}</label>\n";
              $field .="\t<input type=\"{$type}\" class=\"form-control\" id=\"{$name}\" name=\"{$name}\" {$condition}>\n";
            }else{
                $field .="\t<label for=\"edit_{$name}\" class=\"form-label \">{$title}</label>\n";
                $field .="\t<input type=\"{$type}\" class=\"form-control\" id=\"edit_{$name}\" name=\"{$name}\" {$condition}>\n";
            }
        }

        if( $type == 'file'){
            if($formType == 'update'){
                $field .= "\t<p  class=\"form-label\">Current {$name}</p>\n";
                $field .= "\t<a href=\"#\" class=\"edit_{$name}_link\"><img src=\"#\" width=\"100px\" height=\"100px\" alt=\"image\" class=\"edit_{$name}_preview\"></a>\n";
                $field .= "\t</div>\n";
                $field .= "<div class=\"form-group mb-3\">\n";

                $field .="\t<label for=\"edit_{$name}\" class=\"form-label \">{$title}</label>\n";
                $field .="\t<input type=\"{$type}\" class=\"form-control\" id=\"edit_{$name}\" name=\"{$name}\" {$condition}>\n";

            }else{
                $field .="\t<label for=\"{$name}\" class=\"form-label \">{$title}</label>\n";
                $field .="\t<input type=\"{$type}\" class=\"form-control\" id=\"{$name}\" name=\"{$name}\" {$condition}>\n";
            }
        }

        if($type == 'select'){
            if($formType == "create"){
                $field .="\t<label for=\"{$name}\" class=\"form-label \">{$title}</label>\n";
                $field .="\t<select class=\"form-select\" id=\"{$name}\" name=\"{$name}\" $condition>\n";
            }else{
                $field .="\t<label for=\"edit_{$name}\" class=\"form-label \">{$title}</label>\n";
                $field .="\t<select class=\"form-select\" id=\"edit_{$name}\" name=\"{$name}\" $condition>\n";
            }

            $field .="\t<option selected>Choose...</option>\n";
            if(count($enums) > 0){
                foreach ($enums as $enum){
                    $title = self::ucFirst($enum);
                    $field .="\t <option value=\"{$enum}\">{$title}</option>\n";
                }
            }
            $field .="\t</select>\n";
        }
        if($type == 'textarea') {
            if ($formType == "create"){
                $field .= "\t<label for=\"{$name}\" class=\"form-label \">{$title}</label>\n";
                $field .= "\t<textarea class=\"form-control\" id=\"{$name}\" name=\"{$name}\" $condition></textarea>\n";
            }else {
                $field .= "\t<label for=\"edit_{$name}\" class=\"form-label \">{$title}</label>\n";
                $field .= "\t<textarea class=\"form-control\" id=\"edit_{$name}\" name=\"{$name}\" $condition></textarea>\n";
            }
        }

        if($type == 'radio' || $type == 'checkbox'){
            $field .="\t<label>{$title}</label>\n";
            $field .="\t<br>\n";
            if(count($enums) > 0){
                foreach ($enums as $enum){
                    $title = self::ucFirst($enum);
                    if($formType == "create"){
                        $field .="\t <input class=\"form-check-input\" type=\"{$type}\" name=\"{$name}\" id=\"{$enum}\" value=\"{$enum}\">\n";
                        $field .="\t  <label class=\"form-check-label\" for=\"{$enum}\">{$title}</label>\n";
                    }else{
                        $field .="\t <input class=\"form-check-input\" type=\"{$type}\" name=\"{$name}\" id=\"edit_{$enum}\" value=\"{$enum}\">\n";
                        $field .="\t  <label class=\"form-check-label\" for=\"edit_{$enum}\">{$title}</label>\n";
                    }
                }
            }else{

                if ($formType == "create"){
                    $field .="\t <input class=\"form-check-input\" type=\"{$type}\" name=\"{$name}\" id=\"{$name}_1\" value=\"1\">\n";
                    $field .="\t  <label class=\"form-check-label\" for=\"{$name}_1\">1</label>\n";
                }else{
                    $field .="\t <input class=\"form-check-input\" type=\"{$type}\" name=\"{$name}\" id=\"edit_{$name}_1\" value=\"1\">\n";
                    $field .="\t  <label class=\"form-check-label\" for=\"edit_{$name}_1\">1</label>\n";
                }
                if($formType == "create"){
                    $field .="\t <input class=\"form-check-input\" type=\"{$type}\" name=\"{$name}\" id=\"{$name}_2\" value=\"2\">\n";
                    $field .="\t  <label class=\"form-check-label\" for=\"{$name}_2\">2</label>\n";
                }else{
                    $field .="\t <input class=\"form-check-input\" type=\"{$type}\" name=\"{$name}\" id=\"edit_{$name}_2\" value=\"2\">\n";
                    $field .="\t  <label class=\"form-check-label\" for=\"edit_{$name}_2\">2</label>\n";
                }
            }
        }

        $field .="</div>\n";
        return $field;
    }

    /**
     * @param $field
     * @return array
     */
    public static function makeIndexData($field): array
    {
        $indexField = "";
        $indexTable = "";
        $editField = "";
        $files = [];
        $textArea = [];
        for ($key = 0 ; $key < count($field["type"]); $key++){
            $name = $field['name'][$key];
            $title = self::ucFirst($field['name'][$key]);
            if($field['inputType'][$key] == 'file'){
                $indexField .= "{data:'{$name}',name:'{$title}'}, \n";
                $indexTable .= "<th>{$title}</th> \n";
                $files[] = $field['name'][$key];
                $editField .= "$(\".edit_{$name}_preview\").attr(\"src\",res.data.{$name});\n";
                $editField .= "$(\".edit_{$name}_link\").attr(\"href\",res.data.{$name});\n";
            }else if($field['inputType'][$key] == 'textarea'){
                $textArea[] = $name;
                $textArea[] = "edit_".$name;
                $editField .= "$('#edit_{$name}').val(res.data.{$name});\n";
            }else if($field['inputType'][$key] == 'radio' || $field['inputType'][$key] == 'checkbox'){
                $type = $field['inputType'][$key];
                $editField .= "\$(`.edit_{$name} > input[type=\"{$type}\"]`).each((index , input) =>{\n";
                $editField .= "\t if(res.data.{$name} === input.value){\n";
                $editField .= "\t input.checked= true;\n";
                $editField .= "\t}\n";
                $editField .= "\t });\n";

                $indexField .= "{data:'{$name}',name:'{$title}'}, \n";
                $indexTable .= "<th>{$title}</th> \n";

            }else{
                $indexField .= "{data:'{$name}',name:'{$title}'}, \n";
                $indexTable .= "<th>{$title}</th> \n";
                $editField .= "$('#edit_{$name}').val(res.data.{$name});\n";
            }


        }
        return ['indexField' => $indexField ,'indexTable' => $indexTable , 'files' => $files,'textArea'=> $textArea,'editField'=> $editField];
    }

}
