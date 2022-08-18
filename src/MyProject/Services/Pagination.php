<?php

namespace MyProject\Services;

class Pagination {

	public $total;

	public $limit;

	public $countPages;
	
	public function __construct($total, $limit = 10)
	{
		$this->total = $total; 
		$this->limit = $limit; 
		$this->countPages = ceil($this->total / $this->limit);
	}

	public function get()
	{
		$arr = []; //существующие страницы 
		
		for($page = 1; $page <= $this->countPages; $page++){
			$arr[$page] = $page;
		}

		$links = []; //формируются ссылки 

		$current = $this->currentPage(); //что бы не писать везде $this->currentPage()
		
		
		$key = array_search($current, $arr);

		if($key){

			//левая часть (4 ссылки)
			for($i = 4; $i >= 1; $i--){
				if($current - $i >= 1){
					$links[] = "<a href=\"/articles/page/" . ($current-$i) ."\">" . ($current-$i) . "</a>";
				}
			}

			array_push($links, $current); //активная ссылка

			/*
			 * Максимум 10 страниц
			 * Если слева вывелось 3 страницы
			 * То осталось 7 и это пустое место
			 * Заполнятеся остальными страницами 
			 */
			$freeArraySpaces = 10 - count($links); 

			//правая часть
			for($i = 1; $i <= $freeArraySpaces; $i++){
				if(array_search($current+$i, $arr)){
					$links[] = "<a href=\"/articles/page/" . ($current+$i) ."\">" . ($current+$i) . "</a>";
				}
				
			}
		}

		array_unshift($links, $this->firstPage()); //добавляю ссылку на первую страницу
		array_push($links, $this->lastPage()); //добавляю ссылку на первую страницу
		
		return $links;
	}

	
	
	public function currentPage()
	{

		if($_SERVER["REQUEST_URI"] == '/'){
			$page = 1;
		}
		else {
			preg_match('~^/articles/page/(\d+)$~', $_SERVER["REQUEST_URI"], $matches);
			$page = $matches[1];
		}
		
		return $page;
	}

	public function firstPage()
	{
		return "<a href=\"/articles/page/" . 1 ."\">Первая</a>";
	}

	public function lastPage()
	{
		return "<a href=\"/articles/page/" . $this->countPages ."\">Последняя</a>";
	}
	
}
