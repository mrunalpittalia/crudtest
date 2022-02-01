<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'employee';
    
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'employee_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'first_name',
        'last_name',
        'email_address',
        'position',
        'city',
        'country',
        'status',
    ];

    /**
     * Get related company.
     *
     * @return void
     */
    public function company()
    {
        return $this->belongsTo(company::class, 'company_id', 'company_id');
    }
}
