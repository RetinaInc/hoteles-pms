

<?php 

$this->load->view('header'); 

foreach ($reservation_rooms as $row)
{
	$full_check_in = $row['CHECK_IN'];
	$array_check_in = explode (' ', $full_check_in);
	$check_in = $array_check_in [0];
	$ci_array = explode ('-',$check_in);
	$year = $ci_array[0];
	$month = $ci_array[1];
	$day = $ci_array[2];
	$ci = $day.'-'.$month.'-'.$year;
	
	$full_check_out = $row['CHECK_OUT'];
	$array_check_out = explode (' ', $full_check_out);
	$check_out = $array_check_out [0];
	$co_array = explode ('-',$check_out);
	$year = $co_array[0];
	$month = $co_array[1];
	$day = $co_array[2];
	$co = $day.'-'.$month.'-'.$year;
		
	echo 'RESERVACION # ', $row['ID_RESERVATION']."<br>";
	echo 'Check-In: ', $ci."<br>";
	echo 'Check-Out: ', $co."<br><br>";
	echo 'HABITACIÓN(ES)'."<br><br>";
	echo '# '.$row['NUMBER'];
}


?>
