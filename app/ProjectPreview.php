<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectPreview extends Model
{

   protected $table="project_preview";
   protected $fillable = ['id', 'name','billing_type_id','status_id','customer_name','registration_id','start_date'];
}
