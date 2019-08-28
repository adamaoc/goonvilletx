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
        $list = $this->getPostListAll();

        foreach ($list as $post) {
            if ($post['slug'] === $slug) {
                return $post;
            }
        }

        return array('error' => "Opps... I couldn't fine the post data...", 'data' => $list);
    }
    public function getPost($slug)
    {
        $fname = Config::get('data/webdata') . 'radio-posts/' . $slug . '/post.html';
        if (file_exists($fname)) {
            $post = file($fname);
            $blog_content = join('', array_slice($post, 0));
            $data = $this->getPostData($slug);

            return array('data' => $data, 'blog' => $blog_content);
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
            return "Opps.. No post slug found " . $id;
        }
    }

    public function updateRadioPost($data)
    {
        $postsListFile = Config::get('data/webdata') . 'radio-posts/post-list.csv';
        // id,post_title,status,slug,date_published,date_updated,author,hero_img,embeded
        $postData = array(
            'id' => $data['id'],
            'post_title' => $data['post_title'],
            'status' => $data['status'],
            'slug' => $data['slug'],
            'date_published' => $data['date_published'],
            'date_updated' => date("Y/d/m"),
            'author' => $data['author'],
            'hero_img' => $data['hero_img'],
            'embeded' => $data['embeded']
        );
        $postData = $this->data->updateWebData($postsListFile, $postData);

        $blogData = $data['blog'];
        $blogPostHTML = Config::get('data/webdata') . 'radio-posts/' . $data['slug'] . '/post.html';
        $blogFile = fopen($blogPostHTML, "w") or die("Unable to open file...");
        fwrite($blogFile, $blogData);
        fclose($blogFile);
        return array('postData' => $postData, 'blog' => $blogData);
    }
}