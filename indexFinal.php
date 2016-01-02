<?php
$searchkey = 'Red';
$apikey = 'kzpcsf9srskyhfgk9ya7fu4t';
$searchkey = urlencode($searchkey);
if(isset($_POST['moviesrch']))
    {
  	$searchkey = urlencode($_POST["srchkeyinput"]);
    }
$movierequesturl = 'http://api.rottentomatoes.com/api/public/v1.0/movies.json?apikey='.$apikey.'&q='.$searchkey;
    // setup curl to make a call to the endpoint
       $session = curl_init($movierequesturl);

   // indicates that we want the response back
      curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

   // exec curl and get the data back
     $data = curl_exec($session);

   // remember to close the curl session once we are finished retrieveing the data
      curl_close($session);

   // decode the json data to make it easier to parse the php
   $search_results = json_decode($data);
   if ($search_results === NULL) die('Error parsing json');

   // play with the data!
    $movies = $search_results->movies;
    echo "<hr style='height:2px;border-width:0;color:gray;background-color:gray' />";
    echo "Search results for your query='<b>".$searchkey."</b>'<hr style='height:2px;border-width:0;color:gray;background-color:gray' />";
    foreach ($movies as $movie)
    {
      echo '<b>Title</b>:'.$movie->title;
      echo '<br>';
      echo '<b>Year:</b>'.$movie->year;
      echo '<br>';
      echo '<b>Run Time:</b>'.$movie->runtime;
      echo '<br> </b> <br>';
      $mcast = $movie->abridged_cast;
      foreach ($mcast as $castarray)
      {
        echo $castarray->name."<br>";
      }
      echo "<table border='1'>";
		  echo '<tr>
			  <td> <a href="'.$movie->posters->thumbnail.'"> <img src="'.$movie->posters->thumbnail.'"/></a> </td>';
			  echo '<td>
				<a href="'.$movie->posters->profile.'">
					<img src="'.$movie->posters->profile.'"/>
				</a>
			  </td>
		  </tr>
	  </table>';
    }?>
