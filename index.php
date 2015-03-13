<!DOCTYPE html>
<html lang="en">
<!-- page header (not in section of body) -->
<head>
<meta charset="UTF-8">
<title>simple blog</title>
<link href="default.css" rel="stylesheet" type="text/css" />
<?php

    /* 
     * Include the necessary files 
     */
    include_once 'inc/functions.inc.php';
    include_once 'inc/db.inc.php';
	
	 // Open a database connection
    $db = new PDO(DB_INFO, DB_USER, DB_PASS);
	
	/*
    * Figure out what page is being requested (default is blogo)
    * Perform basic sanitization on the variable as well
    */
   if(isset($_GET['page']))
   {
       $page = htmlentities(strip_tags($_GET['page']));
   }
   else 
   { 
       $page = 'blogo';
   } 

    // Determine if an entry URL was passed
    $url = (isset($_GET['url'])) ? $_GET['url'] : NULL;

    // Load the entries
    $e = retrieveEntries($db, $page, $url);
	
	   // Get the fulldisp flag and remove it from the array
   $fulldisp = array_pop($e);
   // Sanitize the entry data
   $e = sanitizeData($e); 

?> 
</head>
<body>

    <h1> Simple Blog Application </h1>

    <div id="entries">
 <?php


// If the full display flag is set, show the entry
if($fulldisp==1)
{ 
 // Get the URL if one wasn't passed
    $url = (isset($url)) ? $url : $e['url']; 
?>

        <h2> <?php echo $e['title'] ?> </h2>
        <p> <?php echo $e['entry'] ?> </p>
        <?php if($page=='blogo'): ?>
        <p class="backlink">
            <a href="./">Back to Latest Entries</a>
        </p>
        <?php endif; ?> 

<?php

} // End the if statement
// If the full display flag is 0, format linked entry titles
else
{
    // Loop through each entry
    foreach($e as $entry) {

?>

        <p> 
             <a href="/blog/<?php echo $entry['page'] ?>/<?php echo $entry['url'] ?>">

                <?php echo $entry['title'] ?>

            </a>
        </p> 
		
<?php

    } // End the foreach loop
} // End the else 


?>  


           <p class="backlink">
   <?php if($page=='blogo'): ?>
       <a href="/blog/admin/<?php echo $page ?>">
           Post a New Entry
       </a>
   <?php endif; ?>
   </p> 

    </div>

</body>

</html> 
