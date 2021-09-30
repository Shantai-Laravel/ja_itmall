<?php
namespace App\Models;

use App\Base as Model;

class TranslationLine extends Model
{
    protected $table = 'translation_lines';

    protected $fillable = ['translation_id', 'lang_id', 'line'];

    public function trans()
    {
        return $this->hasOne(Translation::class, 'id', 'translation_id');
    }
}
