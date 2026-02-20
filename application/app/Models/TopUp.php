<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopUp extends Model
{
    use HasFactory;
    public $casts = [
        'services_data'=>'object'
    ];



    public function statusBadge(){
        $html = '';
        if($this->status == 0){
            $html = '<span class="badge badge--danger">'.trans('Disabled').'</span>';
        }
        elseif($this->status == 1 ){
            $html = '<span class="badge badge--success">'.trans('Active').'</span>';
        }
        return $html;
    }
}
