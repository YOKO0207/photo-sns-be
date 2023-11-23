<?php

namespace App\Http\ViewModels;

class UserDetailViewModel extends BaseViewModel {

	public $data;

	public function __construct($model)
	{
		$this->data = [
			'data' => 
			[
				'id' => $model->id,
				'name' => $model->name,
				'email' => $model->email,
				'access_token' => $model->accessToken,
			]
		];
	}
}