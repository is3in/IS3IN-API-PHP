<?php

/*
 * The MIT License (MIT)
 * 
 * Copyright (c) 2014 IS3in

 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 * @author: Niket Malik <niketmalik@gmail.com>  
 *
*/

/* Custom Exception Class */
class APIException extends Exception {}

class is3 {
	
	/*
	 * The API base URL
	*/
	const API_URL = 'https://is3.in/api/';
	
	/*
	 * The API Auth URL
	*/ 
	const AUTH_URL = 'https://is3.in/api/auth/';
	
	/*
     * The user access token
     * @var string
    */
	private $_accesstoken = NULL;
	
	/*
     * Current scope
     * @var string
    */
	private $_scope = NULL;
	
	/*
     * The call operator
     *
     * @param array $params      			Request parameters
     * @param string $method		        Method to make request
	 * @param boolean [optional] $auth      Whether the scope requires an access token
	 * @param string [optional] $token		Access token   
	 *
	 * @return array
    */
	private function _makeCall($params, $method, $auth = FALSE, $token = FALSE) {
		
		$url = ($auth) ? self::AUTH_URL : self::API_URL;
		
		//searlize
		$data = http_build_query($params);
		
		if(!curl_init()) {
			throw new APIException('Curl is disabled, please make sure curl is enabled/installed');
		} else {
		
			//initiate
			$ch = curl_init();

			if($method === 'GET') {
				$url = $url . '?' . $data;
				curl_setopt($ch, CURLOPT_URL, $url);
			} elseif($method === 'POST') {
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			} elseif($method === 'DELETE') {
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			} else {
				throw new APIException('Method not specified');
			}
			
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			//some host does require this
			curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__)."/cacert.pem");

			$return = curl_exec($ch);
			
			$error = curl_error($ch);
			
			//check for errors
			if(TRUE === $error) {
				throw new APIException('An error occurred: ' . $error);
			}
			
			//close connection
			curl_close($ch);
			
			return json_decode($return, TRUE);
		
		}
	}
	
	/*
     * Access Token Setter
     * @return array
    */
	public function setAccessToken() {
		$params = array(
					'key' => APP_ID,
					'secret' => APP_SECRET
				);
		
		$token = $this->_makeCall($params, 'POST', TRUE);
		
		if($token['status'] === 200) {
			$this->_accesstoken = $token['token'];
		} else {
			throw new APIException('An error occurred: HTTP STATUS: ' . $token['status'] . ' MESSAGE: ' . $token['message']);
		}
		
	}
	
	/*
     * Shorten Url
     *
	 * @param array $url      				The long url to be shortened
     * @param array [optional] $desc      	The description of the long url
	 * @param string [optional] $token		Access token
	 *
     * @return array
    */
	public function doShortUrl($url, $desc = NULL, $token = FALSE) {
		$this->_scope = 'shortUrl';
		
		if((ANON === FALSE) && ($token === FALSE)) {
			try {
				$this->setAccessToken();
			} catch(APIException $e) {
				return $e->getMessage();
			}
			$token = $this->_accesstoken;
		} else {
			$token = FALSE;
		}
		
		$params = array(
					'scope' => $this->_scope,
					'longUrl' => $url,
					'description' => $desc,
					'token' => $token
				);
		
		$data = $this->_makeCall($params, 'POST');
		
		if($data['status'] === 200) {
			return $data['scope']['shortUrl'];
		} else {
			throw new APIException('An error occurred: HTTP STATUS: ' . $data['status'] . ' MESSAGE: ' . $data['message']);
		}
		
	}
	
	/*
     * Expand Url
     *
	 * @param array $url      	The url to expand
	 *
     * @return array
    */
	public function doLongUrl($url) {
		$this->_scope = 'longUrl';
		
		$params = array(
					'scope' => $this->_scope,
					'shortUrl' => $url,
				);
		
		$data = $this->_makeCall($params, 'GET');
		
		if($data['status'] === 200) {
			return $data['scope']['longUrl'];
		} else {
			throw new APIException('An error occurred: HTTP STATUS: ' . $data['status'] . ' MESSAGE: ' . $data['message']);
		}
		
	}
	
	/*
     * Analytics of a url
     *
	 * @param string $url      	The url to get analytics of
	 *
     * @return array
    */
	private function _doAnalytics($url) {
		$this->_scope = 'analytics';
		
		$params = array(
					'scope' => $this->_scope,
					'id' => $url,
				);
		
		$data = $this->_makeCall($params, 'GET');
		
		if($data['status'] === 200) {
			return $data['scope']['analytics']['data'];
		} else {
			throw new APIException('An error occurred: HTTP STATUS: ' . $data['status'] . ' MESSAGE: ' . $data['message']);
		}
		
	}
	
	/*
     * Analytics of a url
     *
	 * @param string $url      	The url to get analytics of
	 *
     * @return array
    */
	public function analytics($url) {
		$data = $this->_doAnalytics($url);
		return $data;
	}
	
	/*
     * List of browsers with clicks
     *
	 * @param string $url      	The url to get analytics of
	 *
     * @return array
    */
	public function browser($url) {
		$data = $this->_doAnalytics($url);
		$browser = $data['browser'];
		return $browser;
	}
	
	/*
     * List of countries with clicks
     *
	 * @param string $url      	The url to get analytics of
	 *
     * @return array
    */
	public function country($url) {
		$data = $this->_doAnalytics($url);
		$country = $data['country'];
		return $country;
	}
	
	/*
     * List of OS with clicks
     *
	 * @param string $url      	The url to get analytics of
	 *
     * @return array
    */
	public function os($url) {
		$data = $this->_doAnalytics($url);
		$os = $data['os'];
		return $os;
	}
	
	/*
     * List of Referrer with clicks
     *
	 * @param string $url      	The url to get analytics of
	 *
     * @return array
    */
	public function referrer($url) {
		$data = $this->_doAnalytics($url);
		$referrer = $data['referrer'];
		return $referrer;
	}
	
	/*
     * Latest Short Urls
     *
     * @return array
    */
	public function latest() {
		$this->_scope = 'latest';
		
		$params = array(
					'scope' => 'latest',
				);
		
		$data = $this->_makeCall($params, 'GET');
		
		if($data['status'] === 200) {
			return $data['scope']['latest']['data'];
		} else {
			throw new APIException('An error occurred: HTTP STATUS: ' . $data['status'] . ' MESSAGE: ' . $data['message']);
		}
	}
	
	/*
     * Popular Latest Short Urls
     *
     * @return array
    */
	public function popular() {
		$this->_scope = 'popular';
		
		$params = array(
					'scope' => 'popular',
				);
		
		$data = $this->_makeCall($params, 'GET');
		
		if($data['status'] === 200) {
			return $data['scope']['popular']['data'];
		} else {
			throw new APIException('An error occurred: HTTP STATUS: ' . $data['status'] . ' MESSAGE: ' . $data['message']);
		}
	}

	/*
     * Delete a short url
	 * NOTE: allows to delete only urls under your account, for obvious reasons
     *
	 * @param array $id			The short Url ID to delete
	 *
     * @return array
    */
	public function deleteUrl($id) {
		$this->_scope = 'deleteShort';
		try {
			$this->setAccessToken();
		} catch(APIException $e) {
			return $e->getMessage();
		}
		
		$params = array(
					'scope' => $this->_scope,
					'id' => $id,
					'token' => $this->_accesstoken
				);
		
		$data = $this->_makeCall($params, 'DELETE');
		
		if(($data['status'] === 200) && ($data["scope"][$this->_scope]["status"] === 410)) {
			return $data;
		} else {
			throw new APIException('An error occurred: HTTP STATUS: ' . $data['status'] . ' MESSAGE: ' . $data['message']);
		}
	}
	
	/*
     * Purge a valid token
	 *
     * @return array
    */
	public function purgeToken() {
		
		$this->_scope = 'purgeToken';
		
		$params = array(
					'scope' => $this->_scope,
					'key' => APP_ID,
					'secret' => APP_SECRET
				);
		
		$data = $this->_makeCall($params, 'DELETE');
		
		if(($data['status'] === 200) && ($data["scope"][$this->_scope]["status"] === 410)) {
			return $data;
		} else {
			throw new APIException('An error occurred: HTTP STATUS: ' . $data['status'] . ' MESSAGE: ' . $data['message']);
		}
	}

}

?>