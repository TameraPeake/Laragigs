<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    // protected $fillable = ['title', 'company', 'location', 'website', 'email', 'description', 'tags']; typically required for submitting info to db. But added unguard to providers/appserviceProvider to override this

    public function scopeFilter($query, array $filters) { //this allows you to filter
        if($filters['tag'] ?? false) { //if filters tag isn't false
            $query->where('tags', 'like', '%'.request('tag').'%'); //so this is an sql query. Select * from table where tags like %(the requested tag)%
        }

        if($filters['search'] ?? false) { //if filters tag isn't false
            $query->where('title', 'like', '%'.request('search').'%') //so this is an sql query. Select * from table where title like %(the requested search term)%
                ->orWhere('description', 'like', '%'.request('search').'%')
                ->orWhere('tags', 'like', '%'.request('search').'%');

            // if($query == false) {
            //     return "no listings";
            // }
        }
    }

    //Relationship to User
    public function user() {
        return $this->belongsTo(User::class, 'user_id'); //so the listing belongs to this user and find based on user id
    }
}
