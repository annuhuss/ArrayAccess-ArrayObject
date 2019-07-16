<?php
/**
*=============================================================
* <ArrayObject.php>
* Object Oriented Programming: ArrayObject built-in class in PHP
* All the previous problems are solved through the example
* @Author Muhammad Anwar Hussain<anwar_hussain.01@yahoo.com>
* Created on: 10th July 2019
* ============================================================
*/

trait FlightInfo
{	
	public function callFlight($flightName)
	{
		return new $flightName;
	}
}

trait PassengerInfo
{
	public function passengerInfo($terminalName)
	{
		echo "[$terminalName]: Passenger information for ".strtoupper(__CLASS__ ). "<br>";
	}
}

class Terminal_1
{
	use FlightInfo;
}

class Terminal_2
{
	use FlightInfo;
}

class Terminal_3
{
	use FlightInfo;	
}

class Flight_A
{
	use PassengerInfo;
}

class Flight_B
{
	use PassengerInfo;
}

class Flight_C
{
	use PassengerInfo;
}

class Flight_D
{
	use PassengerInfo;
}

class Flight_E
{
	use PassengerInfo;
}

class Container extends \ArrayObject
{
	protected $data=array();

	public function offsetExists ($offset)
    {	
		return isset($this->data[$offset]);
    }

	function offsetSet($offset, $value)
	{
		if (is_null($offset))
		{
            $this->data[] = $value;
        } 
		else 
		{
            $this->data[$offset] = $value;
        } 
	}

	function &offsetGet($offset) 
	{ 
		if (!isset($this->data[$offset]))
		{
			throw new Exception(sprintf('Key "%s" is not defined.', $offset));
		}
		$this->data[$offset] = is_callable($this->data[$offset]) ? $this->data[$offset]($this) : $this->data[$offset];
		return 	$this->data[$offset];
	}

	public function offsetUnset($offset)
  	{ 	
	    unset($this->data[$offset]);
   	}  
}

$c = new Container();

$c['flight.names'] = ['Flight_A', 'Flight_B', 'Flight_C', 'Flight_D', 'Flight_E'];
$c['terminal.names'] = ['Terminal_1', 'Terminal_2', 'Terminal_3'];

if(isset($c['flight.names'][1]))
{
	unset($c['flight.names'][1]);
}

if(isset($c['flight.names'][2]))
{
	unset($c['flight.names'][2]);
}

shuffle($c['terminal.names']);
shuffle($c['flight.names']);

$length = count($c['terminal.names']);

for ($c['indx'] = 0; $c['indx'] < $length; $c['indx']++)
{
	$c['terminal'] = function($c){return new $c['terminal.names'][$c['indx']];};
	$c->flight = $c['terminal']->callFlight($c['flight.names'][$c['indx']]);
	$c->flight->passengerInfo($c['terminal.names'][$c['indx']]);
}

echo '<br>';

for ($c['indx'] = $length -1; $c['indx'] >= 0;  $c['indx']--)
{
	$c['terminal'] = function($c){return new $c['terminal.names'][$c['indx']];};
	$c->flight = $c['terminal']->callFlight($c['flight.names'][$c['indx']]);
	$c->flight->passengerInfo($c['terminal.names'][$c['indx']]);
}

?>
