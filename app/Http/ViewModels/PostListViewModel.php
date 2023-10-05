<?php

namespace App\Http\ViewModels;

class PostListViewModel extends BaseViewModel
{
	public $data;

	public function __construct($models)
	{
		$this->data = [
			'data' => $models->map(function($model) {
				return [
					'id' => $model->id,
					'created_at' => $this->formatDate($model->created_at),
					'src' => asset(str_replace('public/', 'storage/', $model->src)),
					'post_name' => $model->post_name,
					'post_content' => $model->post_content,
					'user' => [
						'name' => $model->user->name,
					],
				];
			})->all()
		];
	}
}

