<?php

//токен
$bearer = 'hbGciOiJIUzI1NiIsI5cCI6IkpXVCJ9.fZ3Vlc32iOmZhbLCJ0eXBlIjoiQUNDRVNTIiwiaXNzIjoiYmx1bSIsInN1YiI1IjViZImV4cC11MTcyNDIyNzU4MSwiaWF4IjoxNzI0MjIzOTgxfQ.mELHEKlpGkzVgi9SMjQCB8JdikjdKVCwBBsvIKo';

//получаем gameId
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://game-domain.blum.codes/api/v1/game/play',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_HTTPHEADER => array(
    'Origin: https://telegram.blum.codes',
    'Authorization: Bearer ' . $bearer,
  ),
));

$game = curl_exec($curl);
curl_close($curl);
$game = json_decode($game);
$game = (array) $game;


//отправляем клики
if($game and array_key_exists('gameId',$game)) {
	$gameId = $game['gameId'];
	$points = mt_rand(200,250);
	$seconds = mt_rand(35,45);
	echo 'Игра '.$gameId .' ждем '.$seconds.' секунд <br>';
	sleep($seconds);
	
	$data = [
		'gameId' => $gameId,
		'points' => $points,
	];
	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://game-domain.blum.codes/api/v1/game/claim',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'POST',
	  CURLOPT_POSTFIELDS => $data,
	  CURLOPT_HTTPHEADER => array(
		'Origin: https://telegram.blum.codes',
		'Authorization: Bearer ' . $bearer,
	  ),
	));

	$claim = curl_exec($curl);
	curl_close($curl);
	echo 'Отправили '.$points.' очков <br>';
}
