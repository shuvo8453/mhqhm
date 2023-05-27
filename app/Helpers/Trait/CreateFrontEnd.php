<?php
//@abdullah zahid joy
namespace App\Helpers\Trait;

/**
 *
 */
trait CreateFrontEnd
{
    /**
     * Return the stub file path
     * @return string
     *
     */
    public function getPath(): string
    {
        return  __DIR__ .'/../stubs/FrontEnd.stub';
    }

    /**
     * Get the full path of generate front end
     *
     * @param $name
     * @return string
     */
    public function getSourceFrontEndPath($name): string
    {
        return base_path('resources/views/admin/pages') .'/' .$name.'/' . 'index.blade.php';
    }

    /**
     * Replace the stub variables(key) with the desire value
     *
     * @param $stub
     * @param array $stubVariables
     * @return string|array|bool
     */
    public function getContents($stub , array $stubVariables = []): string|array|bool
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace)
        {
            $contents = str_replace('$'.$search.'$' , $replace, $contents);
        }

        return $contents;
    }

    /**
     * Get the stub path and the stub variables
     *
     * @param $name
     * @param $model
     * @param $createForm
     * @param $indexData
     * @return string|array|bool
     */
    public function getSourceFrontEnd($name,$model,$formBuilder,$indexData): string|array|bool
    {
        return $this->getContents($this->getPath(), $this->getVariables($name,$model,$formBuilder,$indexData));
    }

    /**
     **
     * Map the stub variables present in stub to its value
     *
     * @param $name
     * @param $model
     * @param $formBuilder
     * @param $indexData
     * @return array
     */
    public function getVariables($name,$model,$formBuilder,$indexData): array
    {
        return [
            'NAME' => $name,
            'MODEL' => $model,
            'createForm' => $formBuilder["createInputField"],
            'updateForm' => $formBuilder["updateInputField"],
            'indexField' => $indexData['indexField'],
            'indexTable' => $indexData['indexTable'],
            'editField' => $indexData['editField'],
            'TEXTAREA' => json_encode($indexData['textArea']),
        ];
    }


}
