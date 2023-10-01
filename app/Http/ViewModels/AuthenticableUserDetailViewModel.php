<?php

namespace App\Http\ViewModels;

class AuthenticableUserDetailViewModel extends BaseViewModel {

	public $data;

	public function __construct($model)
	{
		$this->data = [
			'data' => 
			[
				'id' => $model->id,
				'name' => $model->name,
				'email' => $model->email,
			]
		];
	}
}