<?php
//This section is in charge of receiving the 'crypto' parameter sent from the user's browser to request information about cryptocurrencies.

if ( isset( $_REQUEST['crypto'] ) ) {
    $url = 'https://min-api.cryptocompare.com/data/pricemultifull?fsyms=BTC,ETH,LTC,XRP,MIOTA&tsyms=USD&api_key=f679c0c70cac07a0a06add6df125f7fd5589a20eb1e5c4e0bfc6862f56414e6e'; //URL de la API con los respectivos parametros de las criptomonedas a visualizar y su equivalente en USD, ademas de la clave API de Crypto Compare.
	
	/*
		Cryptocurrencies requesting:
		BTC=Bitcoin
		ETH=Ethereum
		LTC=Litecoin
		XRP=Ripple
		MIOTA=IOTA
	*/

    $curl = curl_init(); //Initializing cURL

    curl_setopt_array( $curl, array( //Passing parameters to the cURL and indicating that we expect a response
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => 1
    ) );

    $response = curl_exec( $curl ); //Running cURL and assigning response to a variable
	
	$res=json_decode($response,true); //Decoding the JSON response obtained from the Cypto Compare server
	
	$btc=array('symbol'=>$res['RAW']['BTC']['USD']['FROMSYMBOL'],'price'=>$res['RAW']['BTC']['USD']['PRICE'],'change'=>$res['RAW']['BTC']['USD']['CHANGE24HOUR'],'name'=>'BITCOIN');
	$eth=array('symbol'=>$res['RAW']['ETH']['USD']['FROMSYMBOL'],'price'=>$res['RAW']['ETH']['USD']['PRICE'],'change'=>$res['RAW']['ETH']['USD']['CHANGE24HOUR'],'name'=>'ETHEREUM');
	$ltc=array('symbol'=>$res['RAW']['LTC']['USD']['FROMSYMBOL'],'price'=>$res['RAW']['LTC']['USD']['PRICE'],'change'=>$res['RAW']['LTC']['USD']['CHANGE24HOUR'],'name'=>'LITECOIN');
	$xrp=array('symbol'=>$res['RAW']['XRP']['USD']['FROMSYMBOL'],'price'=>$res['RAW']['XRP']['USD']['PRICE'],'change'=>$res['RAW']['XRP']['USD']['CHANGE24HOUR'],'name'=>'RIPPLE');
	$miota=array('symbol'=>$res['RAW']['MIOTA']['USD']['FROMSYMBOL'],'price'=>$res['RAW']['MIOTA']['USD']['PRICE'],'change'=>$res['RAW']['MIOTA']['USD']['CHANGE24HOUR'],'name'=>'IOTA');
	
	//These variables obtain an array that contains the information that I chose from what the API returned to me in response to the cryptocurrencies that I requested.
	
	$data=array('data'=>array($btc,$eth,$ltc,$xrp,$miota)); //I create an array with the key 'data' so that it is interpreted by DataTables automatically with the variables created previously with the information of the chosen cryptocurrencies
	
    echo json_encode($data); //I show this array processed to JSON to be received by the user and processed by DataTables

    curl_close( $curl ); //Closing cURL
}

?>