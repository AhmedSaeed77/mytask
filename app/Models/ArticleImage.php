<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleImage extends Model
{
    use HasFactory;

    protected $table ='article_images';
    public $timestamps = true;

    protected $fillable = ['image','article_id'];

    public function blog()
    {
        return $this->belongsTo('App\Models\Article','article_id');
    }
}
