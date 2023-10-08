<?php

namespace App\Queries\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use App\Models\PostThreadComment;
use App\Queries\Contracts\ScopedListQueryInterface;

class PostThreadCommentQuery implements ScopedListQueryInterface
{
	/**
	 * Search for a list with parameters
	 *
	 * @param string $postThreadId
	 * @return Builder $query
	 */
	public function searchAll(string $postThreadId): Builder
	{
		$query = PostThreadComment::query()->orderBy('id', 'asc');

		$query->where('post_thread_id', $postThreadId);

		return $query;
	}
}
