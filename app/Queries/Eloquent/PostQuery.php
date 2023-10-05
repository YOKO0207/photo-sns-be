<?php

namespace App\Queries\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use App\Queries\Contracts\ListQueryInterface;
use App\Models\Post;

class PostQuery implements ListQueryInterface
{
	/**
	 * Search for a list with parameters
	 *
	 * @param void
	 * @return Builder $query
	 */
	public function searchAll(): Builder
	{
		$query = Post::query()->orderBy('id', 'asc');

		return $query;
	}
}
