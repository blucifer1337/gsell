<?php

namespace App\Models;

use App\Models\Genre;
use App\Models\Device;
use App\Models\Category;
use App\Models\Platform;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    const STATUS_DISABLE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_PRE_ORDER = 2;

    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function device(){
        return $this->belongsTo(Device::class);
    }
    public function platform(){
        return $this->belongsTo(Platform::class);
    }
    public function genre(){
        return $this->belongsTo(Genre::class);
    }

    public function productImages(){
        return $this->hasMany(ProductImage::class);
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class)->withPivot('product_id');
    }

    public function licenseKeys(){
        return $this->hasMany(LicenseKey::class);
    }

    public function review()
    {
        return $this->hasMany(Review::class);
    }

    public function hasPreOrder(){
        return $this->orders()->where('user_id', auth()->id())->count()>0;
    }

    public function statusBadge(){
        $html = '';
        if($this->status == 0){
            $html = '<span class="badge badge--danger">'.trans('Disabled').'</span>';
        }
        elseif($this->status == 1 ){
            $html = '<span class="badge badge--success">'.trans('Active').'</span>';
        }
        elseif($this->status == 2){
            $html = '<span class="badge badge--warning">'.trans('Pre-order').'</span>';
        }
        return $html;
    }
}
