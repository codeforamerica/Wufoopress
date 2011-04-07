<?php

    include('/Applications/MAMP/htdocs/cfa_wordpress/wp-includes/class-IXR.php');
    $client = new IXR_Client('http://localhost/cfa_wordpress/xmlrpc.php');  
    
    // get Recent Posts & WufooID Custom field number
    $client->query('metaWeblog.getRecentPosts', '', 'abhi', 'password', 1);
    $posts = $client->getResponse();
    $latestpost = $posts[0];
    
    foreach ( ($latestpost["custom_fields"]) as $meta ) {
        $custom_fields[$meta["key"]] = $meta['value'];
        }
    
    $WufooIDFilter = 'Filter1=EntryId+Is_greater_than+'.$custom_fields["WufooID"];    
    
          
    // got wufoo form entries
    
    require_once('lib/wufoo/WufooApiWrapper.php');
    $wrapper = new WufooApiWrapper('Z5TN-C4X6-B2XV-8YHB', 'codeforamerica'); //create the class
    $entries = $wrapper->getEntries('x7x3q1', 'forms', $WufooIDFilter );
    $fields = $wrapper->getFields('x7x3q1', 'forms');

    // post wufoo form entries as posts

   foreach ($entries as $app)
    {
        $content['title'] = "$app->Field1";
        $content['description'] = "<p>".$app->Field3."</p>";
        $content['mt_excerpt'] = "<p>".$app->Field366."</p>";
        $content['mt_excerpt'] = "<p>".$app->Field366."</p>";
        $content['custom_fields'] = array(
            	array( 'key' => 'WufooID', 'value' => $app->EntryId )
            	);
        $client->query('metaWeblog.newPost', '', 'abhi', 'password', $content, true);

        if ($client->message->faultString)

        {
            echo "Failure - ".$client->message->faultString."<br />";
            
        } else {

            echo "Success - ".$status->text."<br />";
            
        }

    } 



?>
