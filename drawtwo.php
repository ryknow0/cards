<?php
//Start session
session_start();
//add availability of required libraries by using require
require 'vendor/autoload.php';

//Create client object from guzzel library
$client = new \GuzzleHttp\Client();
//Use -> to access methods of an object
//request method of the $cliante object
//will return a json object as can be seen from deckofcardsapi.com
$response = $client->request('GET', 'https://deckofcardsapi.com/api/deck/new/shuffle/?deck_count=1');
//run json decode = convert the content $response from json object to an associative array
$response_data = json_decode($response->getBody(), TRUE);

//2nd response fromt he deck of cards api
//get a new card from the deck passing the deck id as part of the git request, get 2 cards
$response2 = $client->request('GET', 'https://deckofcardsapi.com/api/deck/'.$response_data['deck_id'].'/draw/?count=2');
//decode json respone into an associative array
$response_data2 = json_decode($response2->getBody(), TRUE);

//Get the 2 cards from the response2 array
//we will keep track o$card_array = $response_data2['cards'];
//See the cards in the card array
$card_array = $response_data2['cards'];
$card_total = calc_card_total($card_array);
//Assigning values to session variables
$_SESSION['card_array'] = $card_array;
$_SESSION['deck_id'] = $response_data['deck_id'];

//function to check against the different potential value of the ACE card
function calc_card_total($card_array1){
    //If the total is <=21 then use the larger value, if the total is less than 21 then use the 1 Values
    $card_value1=["KING"=>10, "QUEEN"=>10, "JACK"=>10,"ACE"=>1, "2"=>2, "3"=>3, "4"=>4, "5"=>5, "6"=>6, "7"=>7, "8"=>8, "9"=>9, "10"=>10 ];
    $card_value2=["KING"=>10, "QUEEN"=>10, "JACK"=>10,"ACE"=>11, "2"=>2, "3"=>3, "4"=>4, "5"=>5, "6"=>6, "7"=>7, "8"=>8, "9"=>9, "10"=>10 ];
    $card_total1 = 0;
    $card_total2 = 0;
    $card_face="";
    foreach($card_array1 as $card){
        $card_face = $card['value'];
        $card_total1 = $card_total1 + $card_value1[$card_face];
        $card_total2 = $card_total2 + $card_value2[$card_face];
    }
    if($card_total2 <= 21){
        return $card_total2;
    } else {
        return $card_total1;
    }
 }
 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php 
    //iterate through the card array to display the images of the cards that we have drawn
    //
    foreach($card_array as $card) : ?>
 
       <img src="<?php echo $card['image'];?>">
   <?php endforeach; ?>

   <h1><?php echo "Your card total is $card_total"; ?></h1>
   
   <?php if($card_total > 21): ?>
       Sorry your total is above 21
       <a href="index.php">Play Again</a>
   <?php elseif($card_total == 21): ?>
       You win, take a trip to Vegas
       <a href="index.php">Play Again</a>
   <?php else: ?>
       <a href="drawagain.php">Draw again</a>
   <?php endif; ?>

</body>
</html>