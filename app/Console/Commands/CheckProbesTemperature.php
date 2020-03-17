<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Probe;
use App\ProbesLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendHighAlarmEmail;
use App\AlarmLog;
use App\Contact;
use App\Mail\SendHighWarningEmail;
use App\Mail\SendLowAlarmEmail;
use App\Mail\SendLowWarningEmail;

class CheckProbesTemperature extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'checkProbesTemperature';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'This command is responsible for creating an alarm/warning for probes that have reached their set temperature limits.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$probes = Probe::with('location')->select('id', 'name', 'serial_number', 'cooling_device', 'temperature_alert_high', 'temperature_warning_high', 'temperature_warning_low', 'temperature_alert_low', 'temperature_unit', 'alarm_time_value', 'alarm_time_unit', 'location_id')->where('status', 'Active')->where('is_configured', 'Yes')->get();

		foreach ($probes as $key => $value) {
			$probe = $value;

			//check if already sent an email or sms for the past 4 hours
			$check_high_alarm = AlarmLog::where('probe_id', $probe->id)
				->where('type', 'High Alarm')
				->where('created_at', '>', Carbon::now()->subSeconds(14400))
				->where('created_at', '<', Carbon::now())
				->get();

			$check_high_warning = AlarmLog::where('probe_id', $probe->id)
				->where('type', 'High Warning')
				->where('created_at', '>', Carbon::now()->subSeconds(14400))
				->where('created_at', '<', Carbon::now())
				->get();

			$check_low_warning = AlarmLog::where('probe_id', $probe->id)
				->where('type', 'Low Warning')
				->where('created_at', '>', Carbon::now()->subSeconds(14400))
				->where('created_at', '<', Carbon::now())
				->get();

			$check_low_alarm = AlarmLog::where('probe_id', $probe->id)
				->where('type', 'Low Alarm')
				->where('created_at', '>', Carbon::now()->subSeconds(14400))
				->where('created_at', '<', Carbon::now())
				->get();

			$check_high_alarm_count = count($check_high_alarm);
			$check_high_warning_count = count($check_high_warning);
			$check_low_warning_count = count($check_low_warning);
			$check_low_alarm_count = count($check_low_alarm);

			\Log::info('Probe: ' . json_encode($probe, JSON_PRETTY_PRINT));
			// \Log::info('Location: ' . json_encode($probe->location->name, JSON_PRETTY_PRINT));
			$alarm_time_value = $probe->alarm_time_value;
			$alarm_time_unit = $probe->alarm_time_unit;
			$temperature_alert_high = $probe->temperature_alert_high;
			$temperature_warning_high = $probe->temperature_warning_high;
			$temperature_warning_low = $probe->temperature_warning_low;
			$temperature_alert_low = $probe->temperature_alert_low;
			$location_id = $probe->location->id;
			$probe_name = $probe->name;
			$temperature_unit = $probe->temperature_unit;

			//convert alarm time to seconds if its in hours or minutes
			if ($alarm_time_unit == 'Hours') {
				$alarm_time = $alarm_time_value * 60 * 60;
			} else if ($alarm_time_unit == 'Minutes') {
				$alarm_time = $alarm_time_value * 60;
			} else {
				$alarm_time = $alarm_time_value;
			}

			// \Log::info('Time Now: ' . Carbon::now());
			// \Log::info('Alarm Time: ' . json_encode($alarm_time, JSON_PRETTY_PRINT));

			$logs = ProbesLog::select('id', 'actual_temperature', 'created_at')
				->where('probe_id', $probe->id)
				->where('created_at', '>', Carbon::now()->subSeconds($alarm_time))
				->where('created_at', '<', Carbon::now())
				->get();
			// \Log::info(json_encode($logs, JSON_PRETTY_PRINT));
			//Check logs if it's over the limit
			//Basis is that ALL logs results should be over the limit to consider it alarm or warning
			$total_logs = count($logs);
			// \Log::info("Count: " . count($logs));
			$last_log_index = $total_logs - 1;
			// \Log::info("Last log index: " . $last_log_index);

			if ($total_logs > 0) {
				$latest_log = $logs[$last_log_index];
				// \Log::info("Latest Log: " . json_encode($latest_log, JSON_PRETTY_PRINT));
				$total_high_alarm = 0;
				$total_high_warning = 0;
				$total_low_warning = 0;
				$total_low_alarm = 0;

				foreach ($logs as $key => $value) {
					$actual_temperature = $value->actual_temperature;

					//High Alarm
					if ($actual_temperature >= $temperature_alert_high) {
						// \Log::info('High Alarm');
						$total_high_alarm = $total_high_alarm + 1;
					}
					//High Warning
					if ($actual_temperature < $temperature_alert_high && $actual_temperature >= $temperature_warning_high) {
						// \Log::info('High Warning');
						$total_high_warning = $total_high_warning + 1;
					}
					//Low Warning
					if ($actual_temperature <= $temperature_warning_low && $actual_temperature > $temperature_alert_low) {
						// \Log::info('Low Warning');
						$total_low_warning = $total_low_warning + 1;
					}
					//Low Alarm
					if ($actual_temperature <= $temperature_alert_low) {
						// \Log::info('Low Alarm');
						$total_low_alarm = $total_low_alarm + 1;
					}
				}

				//fetch emails for mailing and phone #'s for sms
				$contacts = Contact::select('value', 'type')->where('location_id', $location_id)->get();
				$contacts_count = count($contacts);
				// \Log::info("Contacts: " . json_encode($contacts, JSON_PRETTY_PRINT));

				if ($contacts_count > 0) {
					//check if totals are the same with total logs - meaning all logs are consistent
					if ($total_logs == $total_high_alarm && $total_high_alarm != 0 && $check_high_alarm_count == 0) {
						\Log::info("Send High Alarm");
						//send mail and text

						foreach ($contacts as $key => $value) {
							$type = $value->type;
							$contact_value = $value->value;

							if ($type == 'Email') {
								//send mail
								Mail::to($contact_value)->send(new SendHighAlarmEmail($probe, $latest_log));

								if (count(Mail::failures()) > 0) {
									//email failed. insert to AlarmLogs as failed
									foreach (Mail::failures() as $email_address) {
										$alarm_log = new AlarmLog;
										$alarm_log->probe_id = $probe->id;
										$alarm_log->type = 'High Alarm';
										$alarm_log->action = 'Email';
										$alarm_log->status = 'Failed';
										$alarm_log->response = 'Failed to send email to ' . $contact_value;
										$alarm_log->save();
									}
								} else {
									//email success. insert to AlarmLogs as success
									$alarm_log = new AlarmLog;
									$alarm_log->probe_id = $probe->id;
									$alarm_log->type = 'High Alarm';
									$alarm_log->action = 'Email';
									$alarm_log->status = 'Success';
									$alarm_log->response = 'Email sent to ' . $contact_value;
									$alarm_log->save();
								}
							} else {
								//send sms
								$current_temp = $latest_log->actual_temperature;
								$date = $latest_log->created_at;
								$text = 'SMART PROBE ALERT : High Reading (' . $current_temp . "˚ " . $temperature_unit . ') detected on "' . $probe_name . '" at ' . $date . '. Check your device soon.';

								$send_sms = $this->sendSMS($contact_value, $text);
								// \Log::info("send_sms response: " . json_encode($send_sms));

								if ($send_sms == 'Sent') {
									//sms success. insert to AlarmLogs as success
									$alarm_log = new AlarmLog;
									$alarm_log->probe_id = $probe->id;
									$alarm_log->type = 'High Alarm';
									$alarm_log->action = 'SMS';
									$alarm_log->status = 'Success';
									$alarm_log->response = 'SMS sent to ' . $contact_value;
									$alarm_log->save();
								} else {
									//email failed. insert to AlarmLogs as failed
									$alarm_log = new AlarmLog;
									$alarm_log->probe_id = $probe->id;
									$alarm_log->type = 'High Alarm';
									$alarm_log->action = 'SMS';
									$alarm_log->status = 'Failed';
									$alarm_log->response = 'Failed to send SMS to ' . $contact_value . '. Error: ' . $send_sms[2];
									$alarm_log->save();
								}
							}
						}
					}

					if ($total_logs == $total_high_warning && $total_high_warning != 0 && $check_high_warning_count == 0) {
						\Log::info("Send High Warning");
						//send mail only

						foreach ($contacts as $key => $value) {
							$type = $value->type;
							$contact_value = $value->value;

							if ($type == 'Email') {
								//send mail
								Mail::to($contact_value)->send(new SendHighWarningEmail($probe, $latest_log));

								if (count(Mail::failures()) > 0) {
									//email failed. insert to AlarmLogs as failed
									foreach (Mail::failures() as $email_address) {
										$alarm_log = new AlarmLog;
										$alarm_log->probe_id = $probe->id;
										$alarm_log->type = 'High Warning';
										$alarm_log->action = 'Email';
										$alarm_log->status = 'Failed';
										$alarm_log->response = 'Failed to send email to ' . $contact_value;
										$alarm_log->save();
									}
								} else {
									//email success. insert to AlarmLogs as success
									$alarm_log = new AlarmLog;
									$alarm_log->probe_id = $probe->id;
									$alarm_log->type = 'High Warning';
									$alarm_log->action = 'Email';
									$alarm_log->status = 'Success';
									$alarm_log->response = 'Email sent to ' . $contact_value;
									$alarm_log->save();
								}
							}
						}
					}

					if ($total_logs == $total_low_warning && $total_low_warning != 0 && $check_low_warning_count == 0) {
						\Log::info("Send Low Warning");
						//send mail only

						foreach ($contacts as $key => $value) {
							$type = $value->type;
							$contact_value = $value->value;

							if ($type == 'Email') {
								//send mail
								Mail::to($contact_value)->send(new SendLowWarningEmail($probe, $latest_log));

								if (count(Mail::failures()) > 0) {
									//email failed. insert to AlarmLogs as failed
									foreach (Mail::failures() as $email_address) {
										$alarm_log = new AlarmLog;
										$alarm_log->probe_id = $probe->id;
										$alarm_log->type = 'Low Warning';
										$alarm_log->action = 'Email';
										$alarm_log->status = 'Failed';
										$alarm_log->response = 'Failed to send email to ' . $contact_value;
										$alarm_log->save();
									}
								} else {
									//email success. insert to AlarmLogs as success
									$alarm_log = new AlarmLog;
									$alarm_log->probe_id = $probe->id;
									$alarm_log->type = 'Low Warning';
									$alarm_log->action = 'Email';
									$alarm_log->status = 'Success';
									$alarm_log->response = 'Email sent to ' . $contact_value;
									$alarm_log->save();
								}
							}
						}
					}

					if ($total_logs == $total_low_alarm && $total_low_alarm != 0 && $check_low_alarm_count == 0) {
						\Log::info("Send Low Alarm");
						//send mail and text

						foreach ($contacts as $key => $value) {
							$type = $value->type;
							$contact_value = $value->value;

							if ($type == 'Email') {
								//send mail
								Mail::to($contact_value)->send(new SendLowAlarmEmail($probe, $latest_log));

								if (count(Mail::failures()) > 0) {
									//email failed. insert to AlarmLogs as failed
									foreach (Mail::failures() as $email_address) {
										$alarm_log = new AlarmLog;
										$alarm_log->probe_id = $probe->id;
										$alarm_log->type = 'Low Alarm';
										$alarm_log->action = 'Email';
										$alarm_log->status = 'Failed';
										$alarm_log->response = 'Failed to send email to ' . $contact_value;
										$alarm_log->save();
									}
								} else {
									//email success. insert to AlarmLogs as success
									$alarm_log = new AlarmLog;
									$alarm_log->probe_id = $probe->id;
									$alarm_log->type = 'Low Alarm';
									$alarm_log->action = 'Email';
									$alarm_log->status = 'Success';
									$alarm_log->response = 'Email sent to ' . $contact_value;
									$alarm_log->save();
								}
							} else {
								//send sms
								$current_temp = $latest_log->actual_temperature;
								$date = $latest_log->created_at;
								$text = 'SMART PROBE ALERT : Low Reading (' . $current_temp . "˚ " . $temperature_unit . ') detected on "' . $probe_name . '" at ' . $date . '. Check your device soon.';

								$send_sms = $this->sendSMS($contact_value, $text);
								// \Log::info("send_sms response: " . json_encode($send_sms));

								if ($send_sms == 'Sent') {
									//sms success. insert to AlarmLogs as success
									$alarm_log = new AlarmLog;
									$alarm_log->probe_id = $probe->id;
									$alarm_log->type = 'Low Alarm';
									$alarm_log->action = 'SMS';
									$alarm_log->status = 'Success';
									$alarm_log->response = 'SMS sent to ' . $contact_value;
									$alarm_log->save();
								} else {
									//email failed. insert to AlarmLogs as failed
									$alarm_log = new AlarmLog;
									$alarm_log->probe_id = $probe->id;
									$alarm_log->type = 'Low Alarm';
									$alarm_log->action = 'SMS';
									$alarm_log->status = 'Failed';
									$alarm_log->response = 'Failed to send SMS to ' . $contact_value . '. Error: ' . $send_sms[2];
									$alarm_log->save();
								}
							}
						}
					}
				}
			}
		}
	}

	/**
	 * Send SMS By using smsbroadcast API
	 *
	 * @return boolean
	 */
	private function sendSMS($contacts, $text)
	{
		$username       = 'ageconsulting';
		$password       = '6XUIXH5M6dnH';
		$destination    = $contacts; //Multiple numbers can be entered, separated by a comma
		$source         = 'SmartProbe';
		$text           = $text;
		$ref            = 'Alerts';

		$content =  'username=' . rawurlencode($username) .
			'&password=' . rawurlencode($password) .
			'&to=' . rawurlencode($destination) .
			'&from=' . rawurlencode($source) .
			'&message=' . rawurlencode($text) .
			'&ref=' . rawurlencode($ref);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://www.smsbroadcast.com.au/api-adv.php");
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = curl_exec($ch);
		curl_close($ch);


		$message_data = explode(':', $output);
		\Log::info("return data: " . json_encode($message_data, JSON_PRETTY_PRINT));

		if ($message_data[0] == "OK") {
			return 'Sent';
		} else {
			return $message_data;
		}
	}
}
