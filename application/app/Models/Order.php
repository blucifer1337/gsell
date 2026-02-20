<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;
    const STATUS_PENDING = 0;
    const STATUS_COMPLETED = 1;
    const STATUS_PROCESS = 2;
    const STATUS_PRE_ORDER = 3;
    const STATUS_CANCEL_ORDER = 4;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot('license_quantity');
    }
    public function topUp()
    {
        return $this->belongsTo(TopUp::class);
    }

    public function licenseKeys(){
        return $this->hasMany(LicenseKey::class);
    }

    public function statusBadge($status){
        $html = '';
        if($this->status == Order::STATUS_PENDING){
            $html = '<span class="badge bg--warning">'.trans('Pending').'</span>';
        }
        elseif($this->status == Order::STATUS_PRE_ORDER){
            $html = '<span class="badge bg--warning">'.trans('Pending').'</span>';
        }
        elseif($this->status == Order::STATUS_COMPLETED){
            $html = '<span class="badge bg--success">'.trans('Completed').'</span>';
        }
        elseif($this->status == Order::STATUS_PROCESS){
            $html = '<span class="badge bg--info">'.trans('Processing').'</span>';
        }
       else{
            $html = '<span><span class="badge bg--danger">'.trans('Cancel').'</span></span>';
        }
        return $html;
    }
}
