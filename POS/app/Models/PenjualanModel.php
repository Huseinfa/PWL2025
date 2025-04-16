<?php

   namespace App\Models;

   use Illuminate\Database\Eloquent\Factories\HasFactory;
   use Illuminate\Database\Eloquent\Model;

   class PenjualanModel extends Model
   {
       use HasFactory;

       protected $table = 't_penjualan';
       protected $primaryKey = 'penjualan_id';
       protected $fillable = ['user_id', 'penjualan_kode', 'penjualan_tanggal', 'customer', 'total_harga'];

       // Cast penjualan_tanggal as a Carbon instance
       protected $dates = ['penjualan_tanggal'];

       public function details()
        {
            return $this->hasMany(PenjualanDetailModel::class, 'penjualan_id', 'penjualan_id');
        }

       public function user()
       {
           return $this->belongsTo(UserModel::class, 'user_id', 'user_id');
       }
   }