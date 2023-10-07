<?php

namespace App\Queries\Contracts;

use Illuminate\Database\Eloquent\Builder;

/**
 * Interface for queries.
 */
interface ScopedListQueryInterface
{
	/**
	 * Search for a list with parameters
	 * 
	 * @param string $parentId
	 */
	public function searchAll(string $parentId): Builder;
}
