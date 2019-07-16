<?php
/**
*=============================================================
* <flights_example.php>
* Problem: Using unset() and shuffle() give notices as 
* 'Indirect modification of overloaded property has no effect'
*
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

class Container
{
	protected $data = array();

	function __set($k, $v)
	{
		$this->data[$k] = $v; 
	}

	function __get($k) 
	{ 
		if (!isset($this->data[$k]))
    		{
      			throw new Exception(sprintf('Key "%s" does not exists.', $k));
    		}
		return is_callable($this->data[$k])? $this->data[$k]($this) : $this->data[$k];
	}
}

$c = new Container();

$c->flights = ['Flight_A', 'Flight_B', 'Flight_C', 'Flight_D', 'Flight_E'];
$c->terminals = ['Terminal_1', 'Terminal_2', 'Terminal_3'];

if(isset($c->flights[1]))
{
	unset($c->flights[1]);
}

if(isset($c->flights[4]))
{
	unset($c->flights[4]);
}

shuffle($c->flights);
shuffle($c->terminals);

for ($indx = 0; $indx < count($c->terminals); $indx++)
{
	$c->terminal = function($c) use($indx){return new $c->terminals[$indx];};
	$c->flight = $c->terminal->callFlight($c->flights[$indx]);
	$c->flight->passengerInfo($c->terminals[$indx]);
}

?>
