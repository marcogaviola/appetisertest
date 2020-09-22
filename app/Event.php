<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $table = 'events';
  protected $fillable = [
    "description",
    "from_date",
    "to_date",
    "days_covered"
  ];
  protected $casts = [
    'days_covered' => 'object',
  ];
  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */
  protected $hidden = [];
  protected $guarded = ['id'];
}
