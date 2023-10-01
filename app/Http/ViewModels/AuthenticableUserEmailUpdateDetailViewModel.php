<?php

namespace App\Http\ViewModels;

class AuthenticableUserEmailUpdateDetailViewModel extends BaseViewModel {

	public $data;

	public function __construct($model)
	{
		$this->data = [
			'data' => 
			[
				'id' => $model->id,
				'new_pending_email' => $model->new_pending_email,
			]
		];
	}
}