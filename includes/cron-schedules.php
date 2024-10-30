<?php
	add_filter( 'cron_schedules', 'clinical_add_monthly_schedule' ); 
	function clinical_add_monthly_schedule( $schedules ) {
		
		$schedules['weekly'] = array(
			'interval' => 7 * 24 * 60 * 60, //7 days * 24 hours * 60 minutes * 60 seconds
			'display' => __( 'Every 7 Days (Weekly)', 'clinical-login-security' )
		);
		$schedules['monthly'] = array(
			'interval' => 30 * 24 * 60 * 60, //30 days * 24 hours * 60 minutes * 60 seconds
			'display' => __( 'Every 30 Days (Monthly)', 'clinical-login-security' )
		);
		$schedules['quarterly'] = array(
			'interval' => 90 * 24 * 60 * 60, //90 days * 24 hours * 60 minutes * 60 seconds
			'display' => __( 'Every 90 Days (Quarterly)', 'clinical-login-security' )
		);
		return $schedules;
	}
?>