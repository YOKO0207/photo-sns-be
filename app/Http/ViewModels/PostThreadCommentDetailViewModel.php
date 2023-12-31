<?php

namespace App\Http\ViewModels;

class PostThreadCommentDetailViewModel extends BaseViewModel {

	public $data;

	public function __construct($model)
	{
		$this->data = [
			'data' => 
			[
				'id' => $model->id,
				'created_at' => $this->formatDate($model->created_at),
				'updated_at' => $this->formatDate($model->updated_at),
				'content' => $model->content,
				'user' => [
					'name' => $model->user ? $model->user->name : __('deleted user'),
					'id' => $model->user ? $model->user->id : 0,
				]
			]
		];
	}
}