<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $casts = [
        'published_at' => 'datetime',
    ];
    public function author(){

       return $this->belongsTo(User::class,'user_id');
    
    }

    public function getReadingTime(){
        $word=round(str_word_count($this->body)/250);
        return $word<1?1:round(str_word_count($this->body)/250);
        

    }
    public function getExcerpt(){

        return Str::limit(strip_tags($this->body), 150,'...');
        
    }
    public function scopePublished($query)
    {
        $query->where('published_at', '<=', Carbon::now());
    }

}
