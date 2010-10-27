
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery_autocomplete/jquery.autocomplete.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery_autocomplete/lib/jquery.bgiframe.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery_autocomplete/lib/jquery.ajaxQueue.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery_autocomplete/lib/thickbox-compressed.js"></script>
<script type='text/javascript' src="<?php echo base_url(); ?>assets/js/jquery_autocomplete/demo/localdata.js"></script>
<script language='javascript' src="<?php echo base_url(); ?>assets/calendario/popcalendar.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/jquery_autocomplete/jquery.autocomplete.css"/>

<script type="text/javascript">
$(document).ready(function(){
			var search_names = new Array(); 
			<?php
			for ($i=0; $i<=count($names)-1; $i++)
			{
			echo "search_names[".$i."] = '".$names[$i]."';";
			}
			?>

			$('#search').autocomplete(search_names, {
			matchContains: true,
			minChars: 3,
			autoFill: true
			});
});
</script>

<SCRIPT TYPE="text/javascript">
<!--
// copyright 1999 Idocs, Inc. http://www.idocs.com
// Distribute this script freely but keep this notice in place
function numbersonly(myfield, e, dec)
{
var key;
var keychar;

if (window.event)
   key = window.event.keyCode;
else if (e)
   key = e.which;
else
   return true;
keychar = String.fromCharCode(key);

// control keys
if ((key==null) || (key==0) || (key==8) || 
    (key==9) || (key==13) || (key==27) )
   return true;

// numbers
else if ((("0123456789").indexOf(keychar) > -1))
   return true;

// decimal point jump
else if (dec && (keychar == "."))
   {
   myfield.form.elements[dec].focus();
   return false;
   }
else
   return false;
}
//-->
</SCRIPT>

<SCRIPT TYPE="text/javascript">
<!--
// copyright 1999 Idocs, Inc. http://www.idocs.com
// Distribute this script freely but keep this notice in place
function pricenumbers(myfield, e, dec)
{
var key;
var keychar;

if (window.event)
   key = window.event.keyCode;
else if (e)
   key = e.which;
else
   return true;
keychar = String.fromCharCode(key);

// control keys
if ((key==null) || (key==0) || (key==8) || 
    (key==9) || (key==13) || (key==27) )
   return true;

// numbers
else if ((("0123456789,").indexOf(keychar) > -1))
   return true;

// decimal point jump
else if (dec && (keychar == "."))
   {
   myfield.form.elements[dec].focus();
   return false;
   }
else
   return false;
}
//-->
</SCRIPT>

<SCRIPT TYPE="text/javascript">
<!--
// copyright 1999 Idocs, Inc. http://www.idocs.com
// Distribute this script freely but keep this notice in place
function rifnumbers(myfield, e, dec)
{
var key;
var keychar;

if (window.event)
   key = window.event.keyCode;
else if (e)
   key = e.which;
else
   return true;
keychar = String.fromCharCode(key);

// control keys
if ((key==null) || (key==0) || (key==8) || 
    (key==9) || (key==13) || (key==27) )
   return true;

// numbers
else if ((("0123456789-").indexOf(keychar) > -1))
   return true;

// decimal point jump
else if (dec && (keychar == "."))
   {
   myfield.form.elements[dec].focus();
   return false;
   }
else
   return false;
}
//-->
</SCRIPT>

<style type="text/css">
.Estilo1 {color: #FF0000; font-size:13px}
.Estilo2 {font-size:12px}
.Estilo3 {color: #FF0000}
</style>

<?php
$sessionUserId = $this->session->userdata('userid');
$hotel         = $this->session->userdata('hotelid');
$hotelInfo     = getInfo(null, 'HOTEL', 'id_hotel', $hotel,  null, null, null, 1);

foreach ($hotelInfo as $row) {

	echo 'Hotel: ', $row['id_hotel'].' '.$row['name'].' | ';
}

$datestring = "%Y-%m-%d";
$time       = time();
$today      = mdate($datestring, $time);

echo anchor('hotels/infoHotel/','Cuenta Hotel').' | ';
echo anchor('users/infoUser/'.$sessionUserId,'Cuenta Usuario').' | ';
echo anchor('users/viewUsers/','Usuarios').' | ';
echo anchor('users/userSignOut/', 'Salir', array('onClick' => "return confirm('Seguro que desea salir?')"));  
echo "<br>";

echo anchor('users/main/','Inicio').' | ';
echo anchor('rooms/viewRooms/','Habitaciones').' | ';
echo anchor('rooms/viewRoomTypes/','Tipos de Habitaciones').' | ';
echo anchor('reservations/viewPendingReservations/','Reservaciones').' | ';
echo anchor('reservations/viewCheckedIn/','Estadias').' | ';
echo anchor('reservations/viewCheckIns/'.$today,'Check-Ins').' | ';
echo anchor('reservations/viewCheckOuts/'.$today,'Check-Outs').' | ';
echo anchor('guests/viewGuests/','Clientes').' | ';
echo anchor('seasons/viewSeasons/','Temporadas').' | ';
echo anchor('rates/viewRates/','Tarifas').' | ';
echo anchor('plans/viewPlans/','Planes').' | ';
echo anchor('prices/selectSeasonPrices/','Precios');

echo "<br><br>";
?>

