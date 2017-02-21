<?php

namespace ETSIEmplea;

use Illuminate\Database\Eloquent\Model;

class Egresado extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'etsiemplea_egresados';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;
}
