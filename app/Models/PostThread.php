<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostThread extends Model
{
    use HasFactory;

	/**
	 * Relations
	 */
	public function post()
	{
		return $this->belongsTo(Post::class);
	}
	public function postThreadComments()
	{
		return $this->hasMany(PostThreadComment::class);
	}
	public function user()
	{
		return $this->belongsTo(User::class);
	}

	/**
	 * Attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'post_id',
		'x',
		'y',
	];
}