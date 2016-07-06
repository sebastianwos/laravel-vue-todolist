<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'body',
        'end_date',
        'completed',
    ];


    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['end_date'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    /**
     * Toggles status
     * @return $this
     */
    public function toggleStatus(){
        $this->completed = !$this->completed;
        $this->save();
        return $this;
    }

    /**
     * Delete the task
     * @return $this
     * @throws \Exception
     */
    public function deleteTask(){
        $this->delete();
        return $this;
    }

    /**
     * Latest tasks sorted by end_date
     * @return mixed
     */
    public function latest(){
        return $this->orderBy('end_date', 'desc');
    }

    public function getEndDateAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d');
    }

}
