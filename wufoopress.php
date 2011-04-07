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


    include('/Applications/MAMP/htdocs/cfa_wordpress/wp-includes/class-IXR.php');
    $client = new IXR_Client('http://localhost/cfa_wordpress/xmlrpc.php');  
    
    // get Recent Posts & WufooID Custom field number
    $client->query('metaWeblog.getRecentPosts', '', 'abhi', 'password', 1);
    $posts = $client->getResponse();
    $latestpost = $posts[0];
    
    foreach ( ($latestpost["custom_fields"]) as $meta ) {
        $custom_fields[$meta["key"]] = $meta['value'];
        }
    
   $WufooIDFilter = 'Filter1=EntryId+Is_greater_than+1'.$custom_fields["WufooID"];    
    
          
    // got wufoo form entries
    
    require_once('lib/wufoo/WufooApiWrapper.php');
    $wrapper = new WufooApiWrapper('Z5TN-C4X6-B2XV-8YHB', 'codeforamerica'); //create the class
    $entries = $wrapper->getEntries('x7x3q1', 'forms', $WufooIDFilter );
    $fields = $wrapper->getFields('x7x3q1', 'forms');

    //array remove helps work with the categories

    function array_remove_empty($arr){
        $narr = array();
        while(list($key, $val) = each($arr)){
            if (is_array($val)){
                $val = array_remove_empty($val);
                // does the result array contain anything?
                if (count($val)!=0){
                    // yes :-)
                    $narr[$key] = $val;
                }
            }
            else {
                if (trim($val) != ""){
                    $narr[$key] = $val;
                }
            }
        }
        unset($arr);
        return $narr;
    }
    
    // post wufoo entries as posts

   foreach ($entries as $app)
    {
        $content['title'] = $app->Field1." ". $app->Field2;
        
        //description is the post text, which is where most of the fields will go
        $content['description'] =  
                "<h3>Email</h3><p>".$app->Field3."</p>
                <h3>Phone Number</h3><p>".$app->Field4."</p>
                <h3>Location</h3><p>".$app->Field361." ".$app->Field364." ".$app->Field374."</p>
                <h3>Application Preference</h3><p>".$app->Field372."</p>
                <h3>Role</h3><p>".$app->Field257." ".$app->Field259." ".$app->Field258."    ".$app->Field260." ".$app->Field261." ".$app->Field262." ".$app->Field264." ".$app->Field265."</p>
                <h3>Skills</h3><p>".$app->Field479."</p>
                <h3>LinkedIn Profile URL</h3><p>".$app->Field370."</p>
                <h3>GitHub Profile URL</h3><p>".$app->Field358."</p>
                <h3>Website or Portfolio URL</h3><p>".$app->Field368."</p>
                <h3>Twitter Profile URL</h3><p>".$app->Field359."</p>
                <h3>Why do you want to be a Code for America Fellow?</h3><p>".$app->Field366."</p>
                <h3>Relevant work experience?</h3><p>".$app->Field477."</p>
                <h3>URL for Project 1</h3><p>".$app->Field230."</p>
                <h3>Please describe your role and impact on this project in under 140 characters.</h3><p>".$app->Field235."</p>
                <h3>URL for Project 2</h3><p>".$app->Field234."</p>
                <h3>Please describe your role and impact on this project in under 140 characters.</h3><p>".$app->Field231."</p>
                <h3>How did you hear about Code for America?</h3><p>".$app->Field255."</p>";
       
        $content['mt_excerpt'] = "<p>".$app->Field366."</p>";
        
        $content['custom_fields'] = array(
            	array( 'key' => 'WufooID', 'value' => $app->EntryId )
            	);
        
        //get and format the categories, eliminating empty values
        $categories = array($app->Field257, $app->Field259, $app->Field258,     $app->Field260, $app->Field261, $app->Field262, $app->Field262, $app->Field264, $app->Field265);
        $cats = array_remove_empty($categories);
        usort($cats);
        $content['categories'] = $cats;
 
        //POST THEM!
        $client->query('metaWeblog.newPost', '', 'abhi', 'password', $content, true);

        if ($client->message->faultString)

        {
            echo "Failure - ".$client->message->faultString."<br />";
            
        } else {

            echo "Success - ".$status->text."<br />";
            
        } 

    } 



?>
