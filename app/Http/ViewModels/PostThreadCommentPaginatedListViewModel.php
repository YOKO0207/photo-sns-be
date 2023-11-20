<?php

namespace App\Http\ViewModels;

class PostThreadCommentPaginatedListViewModel extends BaseViewModel
{
	public $data;

	public function __construct($paginator)
	{
		$this->data = [
			'data' => $paginator->getCollection()->map(function($model) {
				return [
					'id' => $model->id,
					'created_at' => $this->formatDate($model->created_at),
					'updated_at' => $this->formatDate($model->updated_at),
					'content' => $model->content,
					'user' => [
						'name' => $model->user ? $model->user->name : __('deleted user'),
						'id' => $model->user ? $model->user->id : 0,
					]
				];
			})->all(),
			'meta' => $this->getMetaData($paginator), 
		];
	}
}

