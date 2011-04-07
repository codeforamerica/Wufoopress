<?php

require_once('WufooApiWrapper.php');

/**
 * All available methods and an example of how to call them.
 *
 * @package default
 * @author Timothy S Sabat
 */
class WufooApiExamples {
	
	private $apiKey;
	private $subdomain;
	
	public function __construct($apiKey, $subdomain, $domain = 'wufoo.com') {
		$this->apiKey = $apiKey;
		$this->subdomain = $subdomain;
		$this->domain = $domain;
	}
	
	public function getForms($identifier = null) {
		$wrapper = new WufooApiWrapper($this->apiKey, $this->subdomain, $this->domain);
		return $wrapper->getForms($identifier); 
	}
	
	public function getFields($identifier) {
		$wrapper = new WufooApiWrapper($this->apiKey, $this->subdomain, $this->domain);
		return $wrapper->getFields($identifier); 
	}
	
	public function getEntries($identifier) {
		$wrapper = new WufooApiWrapper($this->apiKey, $this->subdomain, $this->domain);
		return $wrapper->getEntries($identifier); 
	}
	
	public function getEntryCount($identifier) {
		$wrapper = new WufooApiWrapper($this->apiKey, $this->subdomain, $this->domain);
		return $wrapper->getEntryCount($identifier);
	}
	
	public function getUsers() {
		$wrapper = new WufooApiWrapper($this->apiKey, $this->subdomain, $this->domain);
		return $wrapper->getUsers(); 
	}
	
	public function getReports($identifier = null) {
		$wrapper = new WufooApiWrapper($this->apiKey, $this->subdomain, $this->domain);
		return $wrapper->getReports($identifier); 
	}
	
	public function getWidgets($identifier) {
		$wrapper = new WufooApiWrapper($this->apiKey, $this->subdomain, $this->domain);
		return $wrapper->getWidgets($identifier); 
	}
	
	public function getReportFields($identifier) {
		$wrapper = new WufooApiWrapper($this->apiKey, $this->subdomain, $this->domain);
		return $wrapper->getReportFields($identifier); 
	}
	
	public function getReportEntries($identifier) {
		$wrapper = new WufooApiWrapper($this->apiKey, $this->subdomain, $this->domain);
		return $wrapper->getReportEntries($identifier); 
	}
	
	public function getReportEntryCount($identifier) {
		$wrapper = new WufooApiWrapper($this->apiKey, $this->subdomain, $this->domain);
		return $wrapper->getReportEntryCount($identifier);
	}
	
	public function getComments($identifier) {
		$wrapper = new WufooApiWrapper($this->apiKey, $this->subdomain, $this->domain);
		return $wrapper->getComments($identifier);
	}
	
	public function entryPost($identifier, $postArray = '') {
		$wrapper = new WufooApiWrapper($this->apiKey, $this->subdomain, $this->domain);
		$postArray = array(new WufooSubmitField('Field1', 'Booyah!'), new WufooSubmitField('Field1', '/files/myFile.txt', $isFile = true));
		return $wrapper->entryPost($identifier, $postArray);	
	}
	
	public function webHookPut($identifier, $urlToAdd, $handshakeKey, $metadata = false) {
		$wrapper = new WufooApiWrapper($this->apiKey, $this->subdomain, $this->domain);
		return $wrapper->webHookPut($identifier, $urlToAdd, $handshakeKey, $metadata = false);
	}

}


$twitterUser = "mirmillo";

$url = "http://twitter.com/statuses/user_timeline/$twitterUser.xml";

$xml = new SimpleXMLElement(file_get_contents($url));

 

include('../../../wp-includes/class-IXR.php');

$client = new IXR_Client('http://localhost/wordpress/xmlrpc.php');  

 

foreach ($xml->status as $status)

{

    /* set up the post - there are many more keys you can include */

    $content['title'] = "Tweet from $status->created_at";

    $content['description'] = "<p>".$status->text."</p>";

    /* post the tweet */

    $client->query('metaWeblog.newPost', '', 'admin', 'password', $content, true);

    if ($client->message->faultString)

    {

        echo "Failure - ".$client->message->faultString."<br />";

    } else {

        echo "Success - ".$status->text."<br />";

    }

}



?>
