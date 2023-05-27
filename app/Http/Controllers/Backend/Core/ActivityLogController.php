<?php

namespace App\Http\Controllers\Backend\Core;

use App\Http\Controllers\Base\BaseController;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends BaseController
{
    public function index(){
        $logs = Activity::orderByDesc('id')->get();
        $logCollection = collect($logs)->map(function($item){
            $subjects =  explode("\\",$item->subject_type);
            $subject =  $subjects[ count($subjects)-1];
            $subject .=  " ".$item->description;
            return [
                'subject' => $subject,
                'subject_id' => $item->subject_id,
            ];
        })->toArray();
        return view('admin.pages.activities.index' , [ 'logs' => $logCollection ]);
    }
}
