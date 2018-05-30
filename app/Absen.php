<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    protected $table = 'absens';
    protected $fillable = ['user_id','tanggal','jam_masuk','jam_keluar','keterangan'];
}
