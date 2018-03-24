<?php

function GetCoinValues($type, $sorttyp) {

include "sys.php";
$type1 = $type;
$sqlFiat = "SELECT * from ValueToFiat";
$resultFiat = mysqli_query($conn, $sqlFiat);
while ($rowFiat = $resultFiat->fetch_assoc()) {
        echo $rowFiat['FiatValue'];
        if ($rowFiat['FiatValuta'] == "USD") { $USDprice = $rowFiat['Value']; }
        if ($rowFiat['FiatValuta'] == "SEK") { $SEKprice = $rowFiat['Value']; }
        if ($rowFiat['FiatValuta'] == "EUR") { $EURprice = $rowFiat['Value']; }

}
if ($sorttyp == "" ) {
        $sorttyp = "CoinSymbol";
}

$sql = "SELECT * from AllCoins order by $sorttyp";
$result = mysqli_query($conn,$sql);
while ($row = $result->fetch_assoc()) {
        if ($row['CoinSymbol'] != "EBG") {
                $CoinInfo[$row['nyckel']]['CoinSymbol'] = $row['CoinSymbol'];                
                $CoinSymbol = $row['CoinSymbol'];
                $CoinInfo[$row['nyckel']]['Antal'] = $row['antal'];
                $CoinInfo[$row['nyckel']]['Var'] = $row['var'];
                $CoinInfo[$row['nyckel']]['Datum'] = $row['datum'];
                $sql1 = "SELECT * from CoinMarketCap where CoinSymbol='$CoinSymbol'";
                $result1 = mysqli_query($conn,$sql1);
                while ($rowCoinMarketCap = $result1->fetch_assoc()) {
                        $CoinInfo[$row['nyckel']]['CoinName'] = $rowCoinMarketCap['CoinName'];
                        $CoinInfo[$row['nyckel']]['Value_4_1_coin_btc'] = $rowCoinMarketCap['Value_btc'];
                        $CoinInfo[$row['nyckel']]['Value_4_1_coin_usd'] = $rowCoinMarketCap['Value_usd'];
                        $CoinInfo[$row['nyckel']]['Total_Value_USD'] =  round($row['antal'] * $rowCoinMarketCap['Value_btc'] * $USDprice,2);
                        $CoinInfo[$row['nyckel']]['Total_Value_EUR'] =  round($row['antal'] * $rowCoinMarketCap['Value_btc'] * $EURprice,2);
                        $CoinInfo[$row['nyckel']]['Total_Value_SEK'] =  round($row['antal'] * $rowCoinMarketCap['Value_btc'] * $SEKprice,2);
                        $CoinInfo[$row['nyckel']]['Total_Value_SEKFromUSD'] = round($row['antal'] * $rowCoinMarketCap['Value_usd']);
                }
        }
}
if ($type == "Json") { return json_encode($CoinInfo); } else { return $CoinInfo; }
}

function GetHistoryValue($CoinSymbol,$Hours) {
       
        if ($Hours == "") { $Hours = "24"; }        
        #echo $CoinSymbol;
        include "sys.php";
        $sqlHistory = "SELECT data, datum FROM CoinHistory WHERE datum < date_sub(now(), interval $Hours hour) order by datum desc limit 1";
        #$sqlHistory = "select data, datum from CoinHistory where date(datum) = '$yesterday' order by datum DESC limit 1";
        $result = mysqli_query($conn, $sqlHistory);
        while ($rs = $result->fetch_assoc()) {        
                $array = json_decode($rs['data'], true);
                $array = $array[$CoinSymbol];
        }
        return $array;
}


function GetCoinFiatValue() {

include "sys.php";
$sqlFiat = "SELECT * from ValueToFiat";
$resultFiat = mysqli_query($conn, $sqlFiat);
while ($rowFiat = $resultFiat->fetch_assoc()) {
        if ($rowFiat['FiatValuta'] == "USD") { $price['USD'] = $rowFiat['Value']; }
        if ($rowFiat['FiatValuta'] == "SEK") { $price['SEK'] = $rowFiat['Value']; }
        if ($rowFiat['FiatValuta'] == "EUR") { $price['EUR'] = $rowFiat['Value']; }

}
return $price;
}


function GetAllHistoryValue($CoinSymbol) {
        include "sys.php";
        $sqlHistory = "SELECT data, datum FROM CoinHistory order by datum";        
        $result = mysqli_query($conn, $sqlHistory);
        while ($rs = $result->fetch_assoc()) {        
                $arrayCoins = json_decode($rs['data'], true);
                #$arrayDates[$rs['datum']] = $arrayCoins[$CoinSymbol];
                $exchangeKey = "binance" + $CoinSymbol; 
                $arrayDates[$rs['datum']] = $arrayCoins[$exchangeKey];
        }
        return $arrayDates;
}



function GetHashRateZclassic() {
//$json = file_get_contents('https://zcl.suprnova.cc/index.php?page=api&action=getuserstatus&api_kChange for GitHub');
$zpool = json_decode($json, true);                                  
$Hashrate = $zpool['getuserstatus']['data']['hashrate'] / 1000;
return $Hashrate;
}

?>

