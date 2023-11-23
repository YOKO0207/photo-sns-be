<?php

namespace App\Services;

use Illuminate\Support\Facades\{DB, Storage};
use Illuminate\Database\Eloquent\Collection;
use Exception;
use App\Repositories\Contracts\ListableCrudRepositoryInterface;
use App\Services\{CommonService};
use App\Http\Requests\PostCreateRequest;
use App\Models\Post;
use App\Exceptions\{FileUploadFailedException, FileDeleteFailedException};
use Illuminate\Pagination\LengthAwarePaginator;

class PostService
{
	private CommonService $commonService;
	private ListableCrudRepositoryInterface $repository;

	/**
	 * Create a new service instance.
	 *
	 * @param CommonService $commonService
	 * @param PostRepositoryInterface $repository
	 */
	public function __construct(
		CommonService $commonService,
		ListableCrudRepositoryInterface $repository,
	) {
		$this->commonService = $commonService;
		$this->repository = $repository;
	}

	/**
	 * Handle a request to get a paginated list
	 * 
	 * @param int $pagination
	 * @return array
	 */
	public function getAllPaginated(int $pagination): LengthAwarePaginator
	{
		return $this->repository->findAllPaginated($pagination);
	}

	/**
	 * Handle a request to get a list
	 * 
	 * @param void
	 * @return array
	 */
	public function getAll(): Collection
	{
		return $this->repository->findAll();
	}

	/**
	 * Handle a request to create a record
	 * 
	 * @param PhotoCreateRequest $request
	 * @return Post
	 */
	public function create(PostCreateRequest $request): Post
	{
		DB::beginTransaction(); // Start a new database transaction

		try {
			$data = $request->validated();

			if ($request->file('src')->isValid()) {
				$path = $request->file('src')->store('public');
				$data['src'] = $path;
			} else {
				throw new FileUploadFailedException("FileUploadFailedException in PostService@create");
			}

			$data['user_id'] = $request->user()->id;
			$data = $this->repository->create($data);

			DB::commit(); // Commit the transaction if everything went well

			return $data;
		} catch (Exception $e) {
			DB::rollBack(); // Rollback the transaction if there's any exception

			if (isset($path)) { // Check if the file was uploaded
				Storage::delete($path); // Delete the uploaded file
			}

			// Handle exception 
			throw $e;
		}
	}

	/**
	 * Handle a request to get a record
	 * 
	 * @param string $id
	 * @return Post
	 */
	public function getDetail(string $id): Post
	{
		return $this->repository->findById($id);
	}

	/**
	 * Handle a request to delete a record
	 * 
	 * @param Post $post
	 * @return void
	 */
	public function delete(Post $post): void
	{
		DB::beginTransaction(); // Start a new database transaction

		try {
			$this->repository->delete($post->id);
			if (!Storage::delete($post->src)) {
				throw new FileDeleteFailedException("FileDeleteFailedException in PostService@delete");
			}
			DB::commit();
		} catch (Exception $e) {
			DB::rollBack(); // Rollback the transaction if there's any exception

			throw $e;
		}
	}
}
