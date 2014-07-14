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

require '../config.php';
require '../library/is3.lib.php';

$is3 = new is3;

/*
 * Complete analytics
*/

try {
	$a1 = $is3->analytics('LQgG');
	//var_dump($is3->analytics('LQgG'));
} catch(APIExeption $e) {
	die($e->getMessage());
}

/*
 * OS
*/

try {
	$a2 = $is3->os('LQgG');
	//var_dump($is3->os('LQgG'));
} catch(APIExeption $e) {
	die($e->getMessage());
}

/*
 * Browser
*/

try {
	$a3 = $is3->browser('LQgG');
	//var_dump($is3->browser('LQgG'));
} catch(APIExeption $e) {
	die($e->getMessage());
}

/*
 * Country
*/

try {
	$a4 = $is3->country('LQgG');
	//var_dump($is3->country('LQgG'));
} catch(APIExeption $e) {
	die($e->getMessage());
}

/*
 * Referrer
*/

try {
	$a5 = $is3->referrer('LQgG');
	//var_dump($is3->referrers('LQgG'));
} catch(APIExeption $e) {
	die($e->getMessage());
}

/* ------- OUTPUT --------- */

$browser = array(
				'Internet Explorer',
                'Firefox',
                'Safari',
                'Chrome',
                'Opera',
                'Netscape',
                'Maxthon',
                'Konqueror',
                'Handheld Browser(Unknown Browser)'
			);

$os = array(
			'Windows 8.1',
			'Windows 8',
            'Windows 7',
            'Windows Vista',
            'Windows Server 2003/XP x64',
            'Windows XP',
            'Windows 2000',
            'Windows ME',
            'Windows 98',
            'Windows 95',
            'Windows 3.11',
            'Mac OS X',
            'Mac OS 9',
            'Linux',
            'Ubuntu',
            'iPhone',
            'iPod',
            'iPad',
            'Android',
            'BlackBerry',
            'Mobile'
		);
						
echo '<h1>Supported Browser:</h1>';
echo '<pre>' . print_r($browser, TRUE) . '</pre>';

echo '<h1>Supported Operating System:</h1>';
echo '<pre>' . print_r($os, TRUE) . '</pre>';

echo '<h1>Complete Analytics:</h1>';
echo '<pre>' . print_r($a1, TRUE) . '</pre>';

echo '<h1>Operating System:</h1>';
echo '<pre>' . print_r($a2, TRUE) . '</pre>';

echo '<h1>Browser:</h1>';
echo '<pre>' . print_r($a3, TRUE) . '</pre>';

echo '<h1>Country:</h1>';
echo '<pre>' . print_r($a4, TRUE) . '</pre>';

echo '<h1>Referrer:</h1>';
echo '<pre>' . print_r($a5, TRUE) . '</pre>';

?>