<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'img',
        'user',
        'category'
    ];

    public function userModel()
    {
        return $this->hasOne(User::class, 'id', 'user');
    }

    public function categoryModel()
    {
        return $this->hasOne(Category::class, 'id', 'category');
    }
}
