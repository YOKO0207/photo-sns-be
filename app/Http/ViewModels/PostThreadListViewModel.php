<?php

namespace App\Http\ViewModels;

class PostThreadListViewModel extends BaseViewModel
{
	public $data;

	public function __construct($models)
	{
		$this->data = [
			'data' => $models->map(function($model) {
				return [
					'id' => $model->id,
					'created_at' => $this->formatDate($model->created_at),
					'updated_at' => $this->formatDate($model->updated_at),
					'x' => $model->x,
					'y' => $model->y,
					'user' => [
						'name' => $model->user ? $model->user->name : __('deleted user'),
					]
				];
			})->all()
		];
	}
}

