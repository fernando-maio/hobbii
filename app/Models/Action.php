<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_id',
        'started_at',
        'stoped_at',
        'invoiced'
    ];

    /**
     * Project relation.
     */
    public function project()
    {
    	return $this->belongsTo('App\Models\Project', 'project_id');
    }
}
