<?php
class Posts extends Controller {
	public function __construct() {
        $this->postModel = $this->model('Post');
    }
	
	public function index() {
        $posts = $this->postModel->findAllPosts();
		//pass in the post to the view
		$data = [
		'posts' =>$posts
		];
	
		$this->view('posts/index', $data);
	}
}