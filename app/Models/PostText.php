<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostText extends Model
{
    use HasFactory;

	/**
	 * Relations
	 */
	public function post()
	{
		return $this->belongsTo(Post::class);
	}

	/**
	 * Attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'post_id',
		'content',
		'hash_tag'
	];
}