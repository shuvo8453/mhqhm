<?php
//@abdullah zahid joy
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Base\BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use crud;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class FeeTypeController extends BaseController
{

    /**
     * @var string
     */
    private string $modelName = "FeeType";


     /**
      * @var array|string[]
      */
      private array $files  = [];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return crud::getAll($this->modelName,'datatable',$this->files);
        }
        return view('admin.pages.'. $this->modelName .'.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param Request $request
    * @return JsonResponse
    */
    public function store(Request $request): JsonResponse
    {
        //add your validation rule
         $validator = Validator::make($request->all(),[
            // 'title' => 'required|max:191',
         ]);

        if ($validator->fails()){
           return response()->json([
               'status' => 400,
               'errors' => $validator->messages()
           ]);
        }
        try {
           DB::beginTransaction();
           $data  = $request->all();
           if(!empty($this->files)){
              foreach ($this->files as $file){
                  if($request->file($file)){
                      $data[$file] = $this->upload($request->{$file} , $this->modelName);
                  }
              }
           }
           crud::createOrUpdate($this->modelName,$data);
           DB::commit();

           return response()->json([
               'status' => 200,
               'message' => "Added Successfully!!"
           ]);
        }catch (\Exception $ex){
            DB::rollback();
            return response()->json([
                'status' => 400,
                'errors' => $ex->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function edit(int $id): JsonResponse
    {
         $data = crud::getById($this->modelName ,$id);
         return response()->json([
            'status' => 200,
            'data' =>  $data
         ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
      //add your validation rule
      $validator = Validator::make($request->all(),[
          // 'title' => 'required|max:191',
      ]);

       if ($validator->fails()){
           return response()->json([
               'status' => 400,
               'errors' => $validator->messages()
           ]);
       }


        $value = crud::getById($this->modelName ,$id);

        $data = $request->all();
           if(!empty($this->files)){
               foreach ($this->files as $file){
                   if($request->file($file)){
                       $data[$file] = $this->upload($request->{$file} , $this->modelName,$value->{$file} );
                   }
               }
           }
       crud::createOrUpdate($this->modelName, $data , $id);

       return response()->json([
           'status' => 200,
           'message' => "Updated Successfully!!"
       ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
       crud::destroy( $this->modelName , $id );

         return response()->json([
            'status' => 200,
            'message' => "Deleted successfully!!"
         ]);
    }
}
