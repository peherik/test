<!DOCTYPE html>
<?php
include "funktions.php";
?>
<html>
<head>
	<title>Dajj AB</title>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1">	
	<link rel="stylesheet" href="../jquery.mobile-1.4.5/jquery.mobile-1.4.5.min.css" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="../jquery.mobile-1.4.5/jquery.mobile-1.4.5.min.js"></script>
	
	

<style>	
@media screen and (min-width: 35em) and (max-width: 95em ) {
    .widthOnUpload-ac {
	width:22% !important;
    }
    .widthOnUpload-b {
	width:66% !important;
    }
}

.custom-corners .ui-bar {
-webkit-border-top-left-radius: inherit;
border-top-left-radius: inherit;
-webkit-border-top-right-radius: inherit;
border-top-right-radius: inherit;
}
.custom-corners .ui-body {
border-top-width: 0;
-webkit-border-bottom-left-radius: inherit;
border-bottom-left-radius: inherit;
-webkit-border-bottom-right-radius: inherit;
border-bottom-right-radius: inherit;
}

.movie-list thead th,
.movie-list tbody tr:last-child {
    border-bottom: 1px solid #d6d6d6; /* non-RGBA fallback */
    border-bottom: 1px solid rgba(0,0,0,.1);
}
.movie-list tbody th,
.movie-list tbody td {
    border-bottom: 1px solid #e6e6e6; /* non-RGBA fallback  */
    border-bottom: 1px solid rgba(0,0,0,.05);
}
.movie-list tbody tr:last-child th,
.movie-list tbody tr:last-child td {
    border-bottom: 0;
}
.movie-list tbody tr:nth-child(odd) td,
.movie-list tbody tr:nth-child(odd) th {
    background-color: #eeeeee; /* non-RGBA fallback  */
    background-color: rgba(0,0,0,.04);
}

</style>
</head>
<body>
<div data-role="page">
    <div data-role="header">
        <h1>Admin F&ouml;r Dajj AB</h1>
    </div><!-- /header -->
    <div data-role="content">           
        <div class="ui-block-solo">
        <div class="ui-corner-all custom-corners">
            <div class="ui-bar ui-bar-a ui-overlay-shadow">
				<div class="ui-grid-a">
            		<div class="ui-block-a">
 						<?php
            			$json = file_get_contents('https://api-zcash.flypool.org/miner/*removed from github*/currentStats');
						$zpool = json_decode($json, true);                                 
						$averageHashrate = $zpool['data']['averageHashrate'];
						?>
            			<div style="float: left;"><font size="1" style="font-style: italic; color:#000;">Medelhastighet ZCash: <?=number_format(round($averageHashrate,2),2,'.',' ');?> sol/s (24h)</font></div>
            		</div>
            		<div class="ui-block-b">
            		<?php $FiatValue = GetCoinFiatValue(); ?>
            		<div style="float: right;"><font size="1" style="font-style: italic; color:#000;">PacCoin stämmer nu :)</font></div>
            		</div>
            		<div class="ui-block-a"><?php
            					$json = file_get_contents('https://api.ethermine.org/miner/*removed from github/currentStats');
            					$etherpool = json_decode($json, true);
            					$averageHashrate = $etherpool['data']['averageHashrate'] / 1000000; ?>

						<div style="float: left;"><font size="1" style="font-style: italic; color:#000;">Medelhastighet ETH: <?=number_format(round($averageHashrate,2),2,'.',' ');?> MH/s (24h)</font></div>
            		</div>
            		<div class="ui-block-b">
						<div style="float: right";><font size="1" style="font-style: italic; color:#000;">USD: <?=number_format(round($FiatValue['USD'],2),2,'.',' ');?></font>&nbsp;
            			<font size="1" style="font-style: italic; color:#000;">SEK: <?=number_format(round($FiatValue['SEK'],2),2,'.',' ');?></font></div>  
            		
            		</div>
	  </div>	
	    <div class="ui-body ui-body-a ui-corner-all ui-overlay-shadow">
	        
	        <div class="ui-grid-solo" >

	          <center><a  style="font-size: 12px;" href="myntold2.php">Experiment version, baserat på USD-värdet från Coinmarketcap istället för på BTC-värdet</a> </center>
	          <br><br>
		<table style='font-size:smaller;' data-role="table" id="movie-table-custom" data-mode="reflow" class="movie-list ui-responsive">
			<thead>
			<tr>
			<?php
			$sort_typ = $_GET['sort_typ'];
			?>			
			<th style="width:40%"><a href="myntold1.php?sort_typ=CoinSymbol">Mynt Namn</a></th>
			<th data-priority="2">Symbol</th>
			<th data-priority="3">Exchange</th>
			<th data-priority="4"><a href="myntold1.php?sort_typ=antal"><abbr title="Antal">Antal</abbr></a></th>
			<th data-priority="1"><a href="myntold1.php?sort_typ=varde">Värde</a></th>
			<th data-priority="3">
			<?php
			$Hours = $_GET['Hours'];			
			if (($Hours == "") or ($Hours == "24")) { ?>
				<font size="-2"><a href="myntold1.php?Hours=168">7d</a></font>
				<font size="-2">&nbsp;</font>				
				<font size="3"> % 24h</font>
				<font size="-2">&nbsp;</font>
				<font size="-2"><a href="myntold1.php?Hours=12">12h</a/></font>
				<font size="-2">&nbsp;</font>
				<font size="-2"><a href="myntold1.php?Hours=1">1h</a></font> 
			<?php
			}
			else if ($Hours == "12") { ?>
				<font size="-2"><a href="myntold1.php?Hours=168">7d</a></font>
				<font size="-2">&nbsp;</font>
				<font size="-2"><a href="myntold1.php?Hours=24">24h</a></font>
				<font size="-2">&nbsp;</font>
				<font size="3">% 12h</a/></font>
				<font size="-2">&nbsp;</font>
				<font size="-2"><a href="myntold1.php?Hours=1">1h</a></font>
			<?php 
			} 
			else if ($Hours == "1") { ?>
				<font size="-2"><a href="myntold1.php?Hours=168">7d</a></font>
				<font size="-2">&nbsp;</font>
				<font size="-2"><a href="myntold1.php?Hours=24">24h</a></font>
				<font size="-2">&nbsp;</font>
				<font size="-2"><a href="myntold1.php?Hours=12">12h</a/></font>
				<font size="-2">&nbsp;</font>
				<font size="3">% 1h</font>
			<?php
			}
			else if ($Hours == "168") { ?>
				<font size="3">% 7d</a></font>
				<font size="-2">&nbsp;</font>
				<font size="-2"><a href="myntold1.php?Hours=24">24h</a></font>
				<font size="-2">&nbsp;</font>
				<font size="-2"><a href="myntold1.php?Hours=12">12h</a/></font>
				<font size="-2">&nbsp;</font>
				<font size="-2"><a href="myntold1.php?Hours=1">1h</a></font> 
			<?php
			}
			?>
			</th>
			<th data-priority="5">Uppdaterad</th>
		</tr>
		</thead>
			<?php
			if ($sort_typ == "varde") {$sort_typ = "";}
			$Coins = GetCoinValues("Array", $sort_typ);
			if ($_GET['sort_typ'] == "varde") {

				usort($Coins, function($a, $b) {
					return $a['Total_Value_SEK'] - $b['Total_Value_SEK'];
				});
			}
			$Summa = 0;
			$keys = array_keys($Coins);						
			for ($x=0; $x < count($keys); $x++) {
				$CoinSymbol = $keys[$x]; 
				
				if ($CoinSymbol != "coinmateEUR") { ?> 
					<tr>
					<?php
					$max = 0;
					$min = 0;
					$link = str_replace(" ","-",$Coins[$keys[$x]]['CoinName']); ?>
					<td class="title"><a href="https://coinmarketcap.com/currencies/<?=$link;?>/" data-rel="external"><?=$Coins[$keys[$x]]['CoinName']?></a></td>
					<td><a href="#CoinDetailed<?=$Coins[$keys[$x]]['CoinSymbol']?>" class="" data-rel="popup" data-position-to="window"><?=$Coins[$keys[$x]]['CoinSymbol']?></a></td>
					<div style="padding:10px 20px"; data-role="popup" id="CoinDetailed<?=$Coins[$keys[$x]]['CoinSymbol']?>" data-overlay-theme="a" class="ui-corner-all">
						<?php 
						#$arrayOldValues = GetAllHistoryValue($Coins[$keys[$x]]['CoinSymbol']);
						#print_r($arrayOldValues);
						$max = max(array_column($arrayOldValues, 'Total_Value_SEK'));
						$min = min(array_column($arrayOldValues, 'Total_Value_SEK'));
						?>
						<div>
						Högsta Värdet: <?=number_format(round($max,2),2,'.',' ');?> kr<br>
						Lägsta Värdet: <?=number_format(round($min,2),2,'.',' ');?> kr<br>
						<div>
						<div data-role="collapsible" data-theme="b">
							<h3>Detaljerat</h3>
						<p>
							<?php
								$keys1 = array_keys($arrayOldValues);
								for ($i=0; $i < count($arrayOldValues); $i++) { 
									if ($arrayOldValues[$keys1[$i]]['Total_Value_SEK'] == $max) { $Color = "style='color:#74ea2ded;'"; } 
										else if ($arrayOldValues[$keys1[$i]]['Total_Value_SEK'] == $min) { $Color = "style='color:red;'"; } else { $Color = ""; }
									echo "<div $Color>" .$keys1[$i]. "";
									echo "&nbsp;";
									echo  $arrayOldValues[$keys1[$i]]['Total_Value_SEK']. "</div>";
								}
							?>
						</p>
						</div>
					</div>
					<td><?=$Coins[$keys[$x]]['Var']?></td>
					<td><?=$Coins[$keys[$x]]['Antal']?></td>			
					<td style="white-space: nowrap;"><?=number_format(round($Coins[$keys[$x]]['Total_Value_SEK'],2),2,'.',' ');?> kr</td>
					<td>
					<?php
					$HistoryValue = GetHistoryValue($CoinSymbol,$Hours);
					#print_r ($HistoryValue);
					if ($HistoryValue['Total_Value_SEK'] == "") {$HistoryValue['Total_Value_SEK'] = $Coins[$keys[$x]]['Total_Value_SEK'];}
					
					$proc = round($Coins[$keys[$x]]['Total_Value_SEK'] / $HistoryValue['Total_Value_SEK'] * 100 - 100, 2); 
					
					if ($proc > 0) {
						echo "<div style='color:#58ea0e; white-space: nowrap;'>$proc %</div>";}
					elseif ($proc < 0) {
						echo "<div  style='color:red; white-space: nowrap;'>$proc %</div>";}
					elseif ($proc == 0) {
						echo "<div style='white-space: nowrap;'>$proc %</div>";
					}
					?>

					</td>
					<?php
$createDate = new DateTime($Coins[$keys[$x]]['Datum']);

$strip = $createDate->format('Y-m-d');
					?>
					<td style="white-space: nowrap;"><?=$strip;?></td>
					
					</tr>
					<?php $Summa = $Summa + floatval($Coins[$keys[$x]]['Total_Value_SEK']); ?>

			<?php } elseif ($CoinSymbol == "coinmateEUR") { ?>
					<tr>			
					<td class="title"><a href="https://sv.wikipedia.org/wiki/Euro" data-rel="external">Euro</td>
					<td><?=$Coins[$keys[$x]]['CoinSymbol']?></td>
					<td><?=$Coins[$keys[$x]]['Var']?></td>
					<td><?=$Coins[$keys[$x]]['Antal']?></td>			
					<td><?php 

					$json = file_get_contents('https://api.fixer.io/latest?base=EUR');
					$currencies = json_decode($json, true);					
					$total = $Coins[$keys[$x]]['Antal'] * $currencies['rates']['SEK'];
					echo number_format($total,2,'.',' ');					
					$Summa = $Summa + floatval($total);
					?>
					 kr</td>
					 <td></td>
					 <?php
$createDate = new DateTime($Coins[$keys[$x]]['Datum']);

$strip = $createDate->format('Y-m-d');
?>
					<td><?=$strip;?></td>
					
					</tr><?php

			}

		} ?>
		<tr>
		<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td style="float:right;"><b>Totalt:</b></td>
		<td>
			<?php echo number_format($Summa,2,'.',' '); ?> kr
		</td>
		</tr>
			</tbody>

			</table>
            </div>
	 </div>

	</div>
</div>
    </div><!-- /content -->

    <div data-role="footer" data-position="fixed" >
        <h4>&copy; Dajj AB 2017-2018</h4>
    </div><!-- /footer -->
</div><!-- /page -->
<br>
<br>
</body>
</html>



