<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $table = "todo";
    //protected $timestamp = true; false->disable auto fill-in created_at and updated_at field
    protected $fillable = [];//insert table field that are fillable
}