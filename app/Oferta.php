<?php

namespace ETSIEmplea;

use Illuminate\Database\Eloquent\Model;

class Oferta extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'etsiemplea_ofertas';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;
}
