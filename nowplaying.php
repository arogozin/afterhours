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
		
		$tmp = explode(' ', $result);
		if (is_numeric($tmp[0]))
		{
			$offset = strlen($tmp[0]) + 1;
			$result = substr($result, $offset);
		}
		
		$result = str_replace('<![CDATA[ ', '', $result);
		$result = str_replace(' ]]>', '', $result);
		
		$result = preg_replace('/ \d{2}\-\d{2}-\d{4}/', '', $result);
		
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
			
			else if ($tmp = strpos(strtolower($this->cleanTitle($data->title)), strtolower(reset(explode(' - ', $this->cleanTitle($this->banner_data->now_playing))))) !== false)
				$this->now_playing_url = $this->constructUrl($data->attributes()->id, $data->title);
			
			if (strtolower($this->cleanTitle($data->title)) == strtolower($this->cleanTitle($this->banner_data->next_playing)))
				$this->next_playing_url = $this->constructUrl($data->attributes()->id, $data->title);
			else if ($tmp = strpos(strtolower($this->cleanTitle($data->title)), strtolower(reset(explode(' - ', $this->cleanTitle($this->banner_data->next_playing))))) !== false)
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
	
	public function print_links()
	{
		echo "<url_link>". $this->get_now_playing_url() ."</url_link>\n";
		echo "<next_link>". $this->get_next_playing_url() ."</next_link>\n";
	}
}

$link = new Link();

$title = 'Marcus Schossow - Tone Diary 283 03-10-2013';
$link->print_links();

?>