<?php
/**
*=============================================================
* <ArrayAccess.php>
* Object Oriented Programming: ArrayAccess built-in interface in PHP
* Problem: Objects implementing ArrayAccess do not support the increment/decrement 
* operators ++ and --, unlike array() and ArrayObject()
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

class Container implements \ArrayAccess
{
	protected $data = array();

	public function offsetExists ($offset)
    {	
		return isset($this->data[$offset]);
    }
	
	public function offsetSet ($offset, $value)
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

    public function &offsetGet ($offset)
    {
		if (!isset($this->data[$offset]))
		{
			throw new Exception(sprintf('Key "%s" is not defined.', $offset));
		}
		$this->data[$offset] = is_callable($this->data[$offset])? $this->data[$offset]($this): $this->data[$offset];   		
		return $this->data[$offset]; 
    }

    public function offsetUnset ($offset)
    {
		unset($this->data[$offset]);
    }
}

$c = new Container();

$c['terminals'] = ['Terminal_1', 'Terminal_2', 'Terminal_3'];
$c['flights'] = ['Flight_A', 'Flight_D', 'Flight_B', 'Flight_C', 'Flight_E'];

if(isset($c['flights'][1]))
{
	unset($c['flights'][1]);
}

if(isset($c['flights'][2]))
{
	unset($c['flights'][2]);
}

shuffle($c['terminals']);
shuffle($c['flights']);

for ($c['indx'] = 0; $c['indx'] < count($c['terminals']); $c['indx'] = $c['indx'] + 1)
{
	$c['terminal'] = function($c){return new $c['terminals'][$c['indx']];};
	$c['flight'] = $c['terminal']->callFlight($c['flights'][$c['indx']]);
	$c['flight']->passengerInfo($c['terminals'][$c['indx']]);
}

echo '<br>';

for ($indx = 0; $indx < count($c['terminals']); $indx++)
{
	$c['terminal'] = function($c) use ($indx){return new $c['terminals'][$indx];};
	$c['flight'] = $c['terminal']->callFlight($c['flights'][$indx]);
	$c['flight']->passengerInfo($c['terminals'][$indx]);
}

?>