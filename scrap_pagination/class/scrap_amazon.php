<?php

/**
* Create a class based data scraping engine to get data from Amazon.
*
* @author Kavya V Sagar<kavyavidyasagar15@gmail.com>
* @date 30-01-2016
*/

require(ROOT_DIR . DIRECTORY_SEPARATOR ."inc" .DIRECTORY_SEPARATOR. "simple_html_dom.php");

class Scrap_amazon {

	private $aResult = [];

	public function index(){

		$qry = isset($_POST['qry'])?trim($_POST['qry']) : null;

		$page = isset($_POST['page'])?trim($_POST['page']) : null;

		return $this->getProducts(urlencode($qry),$page);	

	}

	// return products
	private function getProducts($qry,$page){

		$html = $this->connection("http://www.amazon.com/s/?url=search-alias%3Daps&field-keywords=".$qry."&page=".$page);

		$this->parsing($html);
		
		// sorting performed
		$sorted_products  = $this->sorting(); 
		
		return $sorted_products;
	}

	// connecting to outward url, scrapping
	private function connection($url){
		return file_get_contents($url);
	}


	// parse data into sortable arrays
	private function parsing($scrappedData){

		$result = [];

		//Create a DOM parser object
		$html = new simple_html_dom();

		//Parse the HTML from Amazon.
		$html->load($scrappedData);

		# Iterate over all the  tags
		foreach($html->find('li[class=s-result-item]') as $key=>$innerData) {
			
			//image
			foreach($innerData->find('img[class=s-access-image]') as $img) {
				$atmp['image'] = $img->getAttribute('src');
			}
			//title
			foreach($innerData->find('h2[class=s-access-title]') as $title) {
				$atmp['title'] = $title->innertext();
			}			
			//price
			foreach($innerData->find('span[class=s-price]') as $price) {
				$price = $price->innertext();					
				$atmp['price'] = $price;
				
				$atmp['numPrice'] = str_replace(",",'',substr($price, 1));
			}

			//total page
			foreach($html->find('span[class=pagnDisabled]') as $maxPage) {
				$atmp['totalPage'] = $maxPage->innertext();
			}	

		    # Show the <a href>
			if(isset($atmp)){
				$result[$key] = $atmp;				
			}
		}	
		
		return $this->aResult = $result;
		
	}

    // sortby price	   
	private function sorting() {

		$price = array();
		$res = $this->aResult; 

		foreach ($this->aResult as $key => $row)
		{
			$price[$key] = isset($row['numPrice']) ? (float) $row['numPrice'] : '-';

		}		
		array_multisort($price, $res);

		return $res;
	}

}