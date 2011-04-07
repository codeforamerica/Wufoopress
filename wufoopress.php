<?php

require_once('lib/wufoo/WufooApiWrapper.php');
    $wrapper = new WufooApiWrapper('Z5TN-C4X6-B2XV-8YHB', 'codeforamerica'); //create the class
    print_r($wrapper->getEntries('x7x3q1', 'forms')); //Notice the filter


?>
