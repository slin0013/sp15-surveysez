<?php
/**
 * demo_list.php along with demo_view.php provides a sample web application
 * 
 * @package nmListView
 * @author Bill Newman <williamnewman@gmail.com>
 * @version 2.10 2012/02/28
 * @link http://www.newmanix.com/
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License ("OSL") v. 3.0
 * @see demo_view.php
 * @todo none
 */

# '../' works for a sub-folder.  use './' for the root  
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials 
 
# SQL statement
$sql = "select CONCAT(a.FirstName, ' ', a.LastName) AdminID, s.SurveyID, s.Title, s.Description, date_format(s.DateAdded, '%W %D %M %Y %H:%i') 'DateAdded' from " . PREFIX . "surveys s, " . PREFIX . "Admin a where s.AdminID=a.AdminID order by s.DateAdded desc";

#Fills <title> tag. If left empty will default to $PageTitle in config_inc.php  
$config->titleTag = 'Surveys made with love & PHP in Seattle';

#Fills <meta> tags.  Currently we're adding to the existing meta tags in config_inc.php
$config->metaDescription = 'Seattle Central\'s ITC250 Class Surveys are made with pure PHP! ' . $config->metaDescription;
$config->metaKeywords = 'Surveys,PHP,Fun,Bran,Regular,Regular Expressions,'. $config->metaKeywords;

/*
$config->metaDescription = 'Web Database ITC281 class website.'; #Fills <meta> tags.
$config->metaKeywords = 'SCCC,Seattle Central,ITC281,database,mysql,php';
$config->metaRobots = 'no index, no follow';
$config->loadhead = ''; #load page specific JS
$config->banner = ''; #goes inside header
$config->copyright = ''; #goes inside footer
$config->sidebar1 = ''; #goes inside left side of page
$config->sidebar2 = ''; #goes inside right side of page
$config->nav1["page.php"] = "New Page!"; #add a new page to end of nav1 (viewable this page only)!!
$config->nav1 = array("page.php"=>"New Page!") + $config->nav1; #add a new page to beginning of nav1 (viewable this page only)!!
*/

# END CONFIG AREA ---------------------------------------------------------- 

get_header(); #defaults to theme header or header_inc.php
?>
<h3 align="center"><?=smartTitle();?></h3>

<p>This page, along with <b>survey_view.php</b>, demonstrate a List/View web application.</p>
<p>It was built on the mysql shared web application page, <b>demo_shared.php</b></p>
<p>This page is the entry point of the application, meaning this page gets a link on your web site.  Since the current subject is surveys, we could name the link something clever like <a href="<?php echo VIRTUAL_PATH; ?>index.php">Surveys</a></p>
<p>Use <b>index.php</b> and <b>survey_view.php</a></b> as a starting point for building your own List/View web application!</p> 
<?php

# connection comes first in mysqli (improved) function
$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));
if (mysqli_num_rows($result) > 0)//at least one record!
	{//show results
		echo '<table align="center" border="1" style="border-collapse:collapse" cellpadding="3" cellspacing="3">';
		echo '<tr>
                  <th>SurveyID</th>
                  <th>AdminID</th>                                 
                  <th>Title</th>                
                  <th>Description</th>
                  <th>DateAdded</th>                
			</tr>
			';
		while ($row = mysqli_fetch_assoc($result))
		{//dbOut() function is a 'wrapper' designed to strip slashes, etc. of data leaving db
			echo "<tr>";
			
		
			echo '<td><a href="survey_view.php?id=' . (int)$row['SurveyID'] . '">' . dbOut($row['SurveyID']) . '</a></td>';				    
			echo '<td>' . dbOut($row['AdminID']) . '</td>';				    
			echo '<td>' . dbOut($row['Title']) . '</td>';			
			echo '<td>' . dbOut($row['Description']) . '</td>';
			echo '<td>' . dbOut($row['DateAdded']) . '</td>';		  
                    
			echo "<tr>";
		
		}
		echo '</table>';
		
		/*
			 echo '<tr>
					<td>' . (int)$row['SurveyID'] . '</td>				    
				    <td>' . dbOut($row['AdminID']) . '</td>				    
				    <td>' . dbOut($row['Title']) . '</td>			
				    <td>' . dbOut($row['Description']) . '</td>
				    <td>' . dbOut($row['DateAdded']) . '</td>		  
                    
				</tr>
		';
		}
		echo '</table>';
		*/
	  
		/*
	  	echo '<div align="center"><a href="' . VIRTUAL_PATH . 'surveys/survey_view.php?id=' . (int)$row['SurveyID'] . '">' . dbOut($row['AdminID']) . ', ' . dbOut($row['Title']) . ', ' . dbOut($row['Description']) . ', ' . dbOut($row['DateAdded']) . '</a></div>';       
	
	*/
		
		
}else{#no records
    echo "<div align=center>What! No Surveys?  There must be a mistake!!</div>";	
}
@mysqli_free_result($result);

get_footer(); #defaults to theme footer or footer_inc.php
?>
