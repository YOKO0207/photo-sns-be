<?php

namespace App\Queries\Contracts;

use Illuminate\Database\Eloquent\Builder;

/**
 * Interface for queries.
 */
interface ListQueryInterface
{
	/**
	 * Search for a list with parameters
	 * 
	 * @param void
	 */
	public function searchAll(): Builder;
}
