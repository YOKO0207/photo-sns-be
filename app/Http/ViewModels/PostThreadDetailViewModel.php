<?php

namespace App\Http\ViewModels;

class PostThreadDetailViewModel extends BaseViewModel {

	public $data;

	public function __construct($model)
	{
		$this->data = [
			'data' => 
			[
				'id' => $model->id,
				'created_at' => $this->formatDate($model->created_at),
				'updated_at' => $this->formatDate($model->updated_at),
				'x' => $model->x,
				'y' => $model->y,
				'user' => [
					'name' => $model->user ? $model->user->name : __('deleted user'),
				]
			]
		];
	}
}