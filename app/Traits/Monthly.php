<?php

namespace App\Traits;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use JeroenNoten\LaravelAdminLte\Components\Tool\Modal;

trait Monthly
{

    private $monthesNum = 12;
    public $allMonthes = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
    public function Monthly($model)
    {
        $data = array_fill(0, $this->monthesNum, 0);
        $model::select(DB::raw('count(id) as count'), DB::raw('MONTH(created_at) month'))
            ->groupBy('month')
            ->get(['month', 'count'])
            ->keyBy('month')
            ->each(function ($item, $key) use (&$data) {
                $data[$key - 1] = $item->count;
            })->toArray();
        // dd($data);


        // $model_name = ucfirst($model);
        // $model_class = "App\Models\\" . "$model_name";
        // $t = $model::all();
        // dd($model::all());

        // $monthes = array();
        // for ($i = 1; $i <= $this->monthesNum; $i++) {
        //     if ($i < 10) {
        //         $monthes[] = $model_class::where('created_at', 'like', "%-0$i-%")->count();
        //     } elseif ($i >= 10) {
        //         $monthes[] = $model_class::where('created_at', 'like', "%-$i-%")->count();
        //     }
        // }
        return $data;
    }
}