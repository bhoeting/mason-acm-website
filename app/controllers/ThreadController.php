<?php

use MasonACM\Repositories\Forum\ThreadRepositoryInterface;
use MasonACM\Exceptions\ModelNotValidException;

class ThreadController extends BaseController {

	/**
	 * @var ThreadRepositoryInterface
	 */
	private $threadRepo;

	/**
	 * @param ThreadRepositoryInterface $threadRepo
	 */
	public function __construct(ThreadRepositoryInterface $threadRepo)
	{
		$this->threadRepo = $threadRepo;
	}

	/**
	 * Display the main forum page.
	 *
	 * @return Response
	 */
	public function index()
	{
		$threads = $this->threadRepo->getAllPaginated(8);

		return View::make('forum.index')->withThreads($threads);
	}

	/**
	 * Display the Thread creation page.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('forum.create');	
	}

	/**
	 * Store a newly created Thread in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();

		$input['user_id'] = Auth::user()->id;

		try
		{
			$thread = $this->threadRepo->create($input);

			return Redirect::route('thread.show', $thread->id);
		}
		catch (ModelNotValidException $e)
		{
			return Redirect::back()->withInput()->withErrors($e->errors());
		}
	}

	/**
	 * Display the single Thread page.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		if ( ! $thread = $this->threadRepo->getById($id))
		{
			return Redirect::route('forum.index');
		}

		$posts = $this->threadRepo->getPostsPaginated($thread, 5);

		return View::make('forum.thread')->withPosts($posts)->withThread($thread);
	}

	/**
	 * Remove the specified Thread from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$this->threadRepo->destroy($id);
	}

}