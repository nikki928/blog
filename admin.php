<?php
if(isset($_GET['page'])) 
{ 
    $page = htmlentities(strip_tags($_GET['page']));
}
else
{
    $page = 'blogo';
}
?> 
<!DOCTYPE html>
<html lang="en">
<!-- page header (not in section of body) -->
<head>
<meta charset="UTF-8">
<title>simple blog</title>
<link href="default.css" rel="stylesheet" type="text/css" />
</head>


<body>
    <h1> Simple Blog Application </h1>

   <form method="post" action="/blog/inc/update.inc.php">

        <fieldset>
            <legend>New Entry Submission</legend>
            <label>Title
                <input type="text" name="title" maxlength="150" />
            </label>
            <label>Entry
                <textarea name="entry" cols="45" rows="10"></textarea>            </label>
				  <input type="hidden" name="page"
                value="<?php echo $page ?>" /> 
            <input type="submit" name="submit" value="Save Entry" />
            <input type="submit" name="submit" value="Cancel" />
        </fieldset>
    </form>
</body>


</html>