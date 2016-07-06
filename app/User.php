<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function boot(){

        parent::boot();

        static::creating(function($user){
            $user->token = str_random(30);
        });
    }

    public function setPasswordAttribute($value){
        $this->attributes['password'] = bcrypt($value);
    }

    public function confirmEmail(){
        $this->verified = true;
        $this->token = null;
        $this->save();
    }

    public function tasks(){
        return $this->hasMany(Task::class);
    }

    /**
     * Saving a Task to user's list
     * @param Task $task
     * @return $this
     */
    public function addTask(Task $task){
        $this->tasks()->save($task);
        return $this;
    }




}
