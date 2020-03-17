<div>
	Hi,
	<br /><br />
	One of your connected Probes' temperature is in <font style="color: orange;">Low Warning</font> level. Please check the device.
	<br />
	<h4>Probe Details</h4>
	Location: <b>{{$probe->location->name}}</b> <br />
	Probe Name: <b>{{$probe->name}}</b> <br />
	Serial Number: <b>{{$probe->serial_number}}</b> <br />
	Cooling Device: <b>{{$probe->cooling_device}}</b> <br />
	High Alert Level: <b>{{$probe->temperature_alert_high}}&#176; {{$probe->temperature_unit}}</b> <br />
	High Warning Level: <b>{{$probe->temperature_warning_high}}&#176; {{$probe->temperature_unit}}</b> <br />
	Low Warning Level: <b>{{$probe->temperature_warning_low}}&#176; {{$probe->temperature_unit}}</b> <br />
	Low Alert Level: <b>{{$probe->temperature_alert_low}}&#176; {{$probe->temperature_unit}}</b> <br />
	<br />
	<h4>Temperature Log from the Probe</h4>
	Date & Time: <b>{{$latest_log->created_at}}</b><br />
	Reading From Sensor: <b style="color: orange;">{{$latest_log->actual_temperature}}&#176; {{$probe->temperature_unit}}</b><br />
</div>