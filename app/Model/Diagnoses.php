<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Diagnoses extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function getAbsoluteUrl():string{
        return __DIR__ . "//..//" . app()->settings->getFilePath();
    }

}
