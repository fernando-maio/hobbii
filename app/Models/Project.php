<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'client_id', 
        'status' //stopped, running', finished
    ];

    /**
     * Client relation.
     */
    public function client()
    {
    	return $this->belongsTo('App\Models\Client', 'client_id');
    }

    /**
     * Action relation.
     */
    public function action()
    {
    	return $this->hasMany('App\Models\Action', 'project_id');
    }
}
