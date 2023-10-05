<?php

namespace App\Http\ViewModels;

class PostDetailViewModel extends BaseViewModel {

	public $data;

	public function __construct($model)
	{
		$this->data = [
			'data' => 
			[
				'id' => $model->id,
				'created_at' => $this->formatDate($model->created_at),
				'post_name' => $model->post_name,
				'post_content' => $model->post_content,
				'src' => asset(str_replace('public/', 'storage/', $model->src)),
				'user' => [
					'name' => $model->user->name,
				],

			]
		];
	}
}