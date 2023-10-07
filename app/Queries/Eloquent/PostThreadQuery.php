<?php

namespace App\Queries\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use App\Models\PostThread;
use App\Queries\Contracts\ScopedListQueryInterface;

class PostThreadQuery implements ScopedListQueryInterface
{
	/**
	 * Search for a list with parameters
	 *
	 * @param string $postId
	 * @return Builder $query
	 */
	public function searchAll(string $postId): Builder
	{
		$query = PostThread::query()->orderBy('id', 'asc');

		$query->where('post_id', $postId);

		return $query;
	}
}
