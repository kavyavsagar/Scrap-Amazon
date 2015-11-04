<?php

	// create Class Object
    $obj =  new scrap_amazon();
    $return =  $obj->scrappingProcess();
    
//    print_r($return);

    echo json_encode($return);

    //Create Class
	class scrap_amazon {

		private $qry;
		private $aResult;
		
		public function __construct()
		{
		    $str = trim($_POST['qry'])?trim($_POST['qry']) : null;
			$this->qry  = urlencode($str);	
			$this->aResult = [];
		}

		//Scrapping Performed
		public function scrappingProcess(){
		
			$scraped_page = $this->curl("http://www.amazon.com/s/?url=search-alias%3Daps&field-keywords=".$this->qry);
			
			$this->parsing($scraped_page);
			
			// sorting performed
			$sorted  = $this->sortbyPrice(); 
			
			return $sorted;
		}

	    //Defining the basic cURL function
	    protected function curl($url) {
	    	if (!function_exists('curl_init')){
	     		die('cURL is not installed. Install and try again.');
	    	}

	        $ch = curl_init();  // Initialising cURL
	        curl_setopt($ch, CURLOPT_URL, $url);    // Setting cURL's URL option with the $url variable passed into the function
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); // Setting cURL's option to return the webpage data
	        $data = curl_exec($ch); // Executing the cURL request and assigning the returned data to the $data variable
	        curl_close($ch);    // Closing cURL

	        return $data;   // Returning the data from the function
	    } 

	    //Parsing HTML
	    protected function parsing($input){

			include_once("simple_html_dom.php");

			# Create a DOM parser object
			$html = new simple_html_dom();
			# Parse the HTML from Amazon.
			$html->load($input);

			$result = [];

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
			    # Show the <a href>
				$result[$key] = $atmp;				
			}	
			
			if(!empty($result)) return $this->aResult = $result;
			
	    }

	    // sortby price	   
	    protected function sortbyPrice() {

	        $price = array();
	        $res = $this->aResult; 

			foreach ($this->aResult as $key => $row)
			{
			    $price[$key] = (float) $row['numPrice'];

			}		
			array_multisort($price, $res);
			

			return $res;
     }

}
?>