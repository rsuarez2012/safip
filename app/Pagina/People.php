<?php

namespace App\Pagina;

use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    protected $table = 'people';
    protected $fillable = [
        'type_document', 'document', 'name', 'lastname', 'nacionality', 'type',
    ];

    public function contact(){
        return $this->hasOne(Contact::class);
    }

    public function tikets(){
    	return $this->hasMany(Tiket::class);
    }
}
