<?php

class Link
{
	protected $base_url;
	protected $default_url;
	protected $banner_url;
	protected $forum_url;
	protected $now_playing_url;
	protected $next_playing_url;
	
	protected $banner_data;
	protected $forum_data;
	
	public function __construct($default = 'http://ah.fm')
	{
		$this->base_url = 'http://www.ah.fm/forum/showthread.php';
		$this->default_url = $default;
		$this->banner_url = 'http://www.ah.fm/stats/bannercurrent.xml';
		$this->forum_url = 'http://www.ah.fm/forum/external.php?type=XML&forumids=178&count=500';
		
		$this->obtainData();
		$this->run();
		
		$this->finalize();
	}
	
	public function obtainData()
	{
		$this->banner_data = 
			simplexml_load_string(file_get_contents($this->banner_url));
		$this->forum_data = 
			simplexml_load_string(file_get_contents($this->forum_url));
	}
	
	public function cleanTitle($title)
	{
		$result = $title;
		if ($pos = strpos($title, ' on AH.FM'))
			$result = substr($result, 0, strpos($title, ' on AH.FM'));
		
		if (strtotime(substr($result, 0, 10)))
			$result = substr($result, 11);
		
		$result = str_replace('<![CDATA[ ', '', $result);
		$result = str_replace(' ]]>', '', $result);
		
		return $result;
	}
	
	public function constructUrl($id, $title)
	{
		$result = $this->base_url ."?$id-";
		$result .= $this->cleanTitle($title);
		$result = str_replace(' ', '-', $result);
		$result = str_replace('---', '-', $result);
	
		return $result;
	}
	
	public function finalize()
	{
		if (!isset($this->now_playing_url))
			$this->now_playing_url = $this->default_url;
		
		if (!isset($this->next_playing_url))
			$this->next_playing_url = $this->default_url;
	}
	
	public function run()
	{
		foreach ($this->forum_data as $data)
		{
			if (strtolower($this->cleanTitle($data->title)) == strtolower($this->cleanTitle($this->banner_data->now_playing)))
				$this->now_playing_url = $this->constructUrl($data->attributes()->id, $data->title);
				
			if (strtolower($this->cleanTitle($data->title)) == strtolower($this->cleanTitle($this->banner_data->next_playing)))
				$this->next_playing_url = $this->constructUrl($data->attributes()->id, $data->title);
		}
	}
	
	public function get_now_playing_url()
	{
		return $this->now_playing_url;
	}
	
	public function get_next_playing_url()
	{
		return $this->next_playing_url;
	}
}

$link = new Link();

echo $link->get_now_playing_url() ."\n";
echo $link->get_next_playing_url() ."\n";

?>