<?php

class RadioModel {
    private $data = null;
    public function __construct()
    {
      $this->data = new Data;
    }

    public function getPostListAll()
    {
        $file = Config::get('data/webdata') . 'radio-posts/post-list.csv';
        $list = $this->data->getWebData($file);
        return $list;
    }

    public function getPostList()
    {
        $file = Config::get('data/webdata') . 'radio-posts/post-list.csv';
        $list = $this->data->getWebData($file);
        $publishedList = array();
        foreach ($list as $post) {
            if ($post['status'] === 'published') {
                $publishedList[] = $post;
            }
        }
        return $publishedList;
    }

    public function recentListSet($startnum, $endnum)
    {
        $list = $this->getPostList();
        $count = count($list);
        if ($count < $endnum) {
            $endnum = $count;
        }
        array_multisort($list, SORT_DESC);
        $buildarr = array();
		for($i = $startnum; $i < $endnum; ++$i) {
			$buildarr[] = $list[$i];
		}
		return $buildarr;
    }
    
    public function getPostData($slug)
    {
        $list = $this->getPostList();

        foreach ($list as $post) {
            if ($post['slug'] === $slug) {
                return $post;
            }
        }

        return null;
    }
    public function getPost($slug)
    {
        $fname = Config::get('data/webdata') . 'radio-posts/' . $slug . '/post.html';
        if (file_exists($fname)) {
            $post = file($fname);
            $blog_content = join('', array_slice($post, 0));
            return $blog_content;
        } else {
            return "Opps... There is no content here.";
        }
    }

    public function getPostById($id)
    {
        $postSlug = null;
        $allPosts = $this->getPostListAll();
        foreach ($allPosts as $post) {
            if ($post['id'] === $id) {
                $postSlug = $post['slug'];
            }
        }
        if (!empty($postSlug)) {
            return $this->getPost($postSlug);
        } else {
            return null;
        }
    }
}