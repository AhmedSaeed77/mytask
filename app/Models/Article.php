<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable=['title','description','image'];
    protected $table = 'articles';
    public $timestamps = true;

    public function images()
    {
        return $this->hasMany('App\Models\ArticleImage', 'article_id');
    }
}
