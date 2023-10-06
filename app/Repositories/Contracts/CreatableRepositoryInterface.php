<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;

interface CreatableRepositoryInterface
{
	/**
	 * Create a record.
	 * 
	 * @param array $data
	 * @return Model
	 */
	public function create(array $data): Model;
}
