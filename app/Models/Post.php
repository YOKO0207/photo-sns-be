<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

	/**
	 * Relations
	 */
	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function postText()
	{
		return $this->hasOne(PostText::class);
	}

	public function postImage()
	{
		return $this->hasOne(PostImage::class);
	}

	public function postThreads()
	{
		return $this->hasMany(PostThread::class);
	}

	/**
	 * Attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'user_id',
	];
}
