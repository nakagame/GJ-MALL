<?php

namespace App\Models\Orders;

use App\Models\Products\Product;
use App\Models\Products\Review;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderLine extends Model
{
    use HasFactory;

    protected $table = 'order_lines';

    public function shopOrder() {
        return $this->belongsTo(ShopOrder::class ,'order_id','id');
    }

    public function getStatus($id) {
        return $this->shopOrder()->where("status_id",$id)->paginate(5);
    }

    public function product() {
        return $this->belongsTo(Product::class , "product_id","id");
    }

    public function getSeller() {
        return $this->product()->where("seller_id",Auth::guard("admin")->id())->get();
    }

}