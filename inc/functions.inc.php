<?php

function retrieveEntries($db, $page, $url=NULL) 
{
    /* 
     * If an entry URL was supplied, load the associated entry
     */ 
    if(isset($url))
    { 
        $sql = "SELECT id, page, title, entry
                FROM entries
                WHERE url=?
                LIMIT 1"; 
        $stmt = $db->prepare($sql);
        $stmt->execute(array($url)); 
 

        // Save the returned entry array
        $e = $stmt->fetch();

        // Set the fulldisp flag for a single entry
        $fulldisp = 1; 
   }
    /* 
     * If no entry URL provided, load all entry info for the page
     */
    else
    { 
        $sql = "SELECT id, page, title, entry, url
                FROM entries
                WHERE page=?
                ORDER BY created DESC"; 
    $stmt = $db->prepare($sql);
    $stmt->execute(array($page));

    $e = NULL; // Declare the variable to avoid errors 


        // Loop through returned results and store as an array
        while($row = $stmt->fetch()) {
        $e[] = $row;
    } 

        // Set the fulldisp flag for multiple entries
        $fulldisp = 0; 
		   /*
    * If no entries were returned, display a default
    * message and set the fulldisp flag to display a
    * single entry
    */ 
	  if(!is_array($e))
        {
            $fulldisp = 1;
            $e = array(
                'title' => 'No Entries Yet',
                'entry' => '<a href="admin.php">Post an entry!</a>'
            );
        } 
   } 
  // Add the $fulldisp flag to the end of the array
    array_push($e, $fulldisp);

    return $e; 

}

function sanitizeData($data)
{
    // If $data is not an array, run strip_tags()
    if(!is_array($data))
    {
        // Remove all tags except <a> tags
        return strip_tags($data, "<a>");
    }

    // If $data is an array, process each element
    else
    {
        // Call sanitizeData recursively for each array element
        return array_map('sanitizeData', $data);
    }
} 
function makeUrl($title)
{
    $patterns = array(
        '/\s+/',
        '/(?!-)\W+/'
    );
    $replacements = array('-', '');
    return preg_replace($patterns, $replacements, strtolower($title));
} 



?> 