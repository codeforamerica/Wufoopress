<?php
/*
Plugin Name: WufooPress
Plugin URI: https://github.com/codeforamerica/Wufoopress
Description: Uses Wufoo API to create posts when a Wufoo form is submitted
Version: 0.1
Author: Code for America
Author URI: http://codeforamerica.org
License: be_nice
*/


    require_once('lib/wufoo/WufooApiWrapper.php');
    $wrapper = new WufooApiWrapper('Z5TN-C4X6-B2XV-8YHB', 'codeforamerica'); //create the class
//    echo "<br /><h2>Entries</h2>";
//    print_r($wrapper->getEntries('x7x3q1', 'forms')); //Notice the filter
//    echo "<br /><h2>Fields</h2>";
//  print_r($wrapper->getFields('x7x3q1', 'forms')); //Notice the filter

    $entries = $wrapper->getEntries('x7x3q1', 'forms');
    $fields = $wrapper->getFields('x7x3q1', 'forms');
    
    include('/Applications/MAMP/htdocs/cfa_wordpress/wp-includes/class-IXR.php');

    $client = new IXR_Client('http://localhost/cfa_wordpress/xmlrpc.php');  




    $client->query('metaWeblog.getRecentPosts', '', 'abhi', 'password', 1);

$posts = $client->getResponse();
$latestpost = $posts[0];
foreach ( ($latestpost["custom_fields"]) as $meta ) {
    $custom_fields[$meta["key"]] = $meta['value'];
}

print_r($custom_fields["WufooID"]);


/* foreach ($entries as $app)

    {
        
        

   $content['title'] = "$app->Field1";

         $content['description'] = "<p>".$app->Field3."</p>";
         
         
         $content['mt_excerpt'] = "<p>".$app->Field366."</p>";


        $client->query('metaWeblog.newPost', '', 'abhi', 'password', $content, true);

        if ($client->message->faultString)

        {

            echo "Failure - ".$client->message->faultString."<br />";

        } else {

            echo "Success - ".$status->text."<br />";

        }

    } */




?>
