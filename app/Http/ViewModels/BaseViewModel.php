<?php

namespace App\Http\ViewModels;

class BaseViewModel
{
	public function getMetaData($paginator): array
	{
		return [
			'current_page' => $paginator->currentPage(),
			'last_page' => $paginator->lastPage(),
			'per_page' => $paginator->perPage(),
			'total' => $paginator->total(),
			'query_string' => http_build_query(request()->except('per_page', 'page')),
			'has_more_pages' => $paginator->hasMorePages(),
		];
	}

	public function formatDate($dateString, $format = 'Y.m.d H:i'): string
	{
		$date = new \DateTime($dateString);
		$date->setTimezone(new \DateTimeZone(config('app.timezone')));
		return $date->format($format);
	}
}
