<?php

namespace App\Http\ViewModels;

class PostPaginatedListViewModel extends BaseViewModel
{
	public $data;

	public function __construct($paginator)
	{
		$this->data = [
			'data' => $paginator->getCollection()->map(function($model) {
				return [
					'id' => $model->id,
					'created_at' => $this->formatDate($model->created_at),
					'src' => $model->src,
					'post_name' => $model->post_name,
					'post_content' => $model->post_content,
					'user' => [
						'name' => $model->user->name,
						'id' => $model->user->id,
					],
				];
			})->all(),
			'meta' => $this->getMetaData($paginator), 
		];
	}
}

