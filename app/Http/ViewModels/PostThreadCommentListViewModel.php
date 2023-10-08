<?php

namespace App\Http\ViewModels;

class PostThreadCommentListViewModel extends BaseViewModel
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
					'content' => $model->content,
					'user' => [
						'name' => $model->user ? $model->user->name : __('deleted user'),
					]
				];
			})->all()
		];
	}
}

