<h1>
Utilizing the features of PHPs predefined ArrayAccess interface and ArrayObject class by a container
</h1>

<p>
<em>PHP</em> ships with a number of predefined classes and interfaces and, two of the common out of them are <i>ArrayAccess</i> interface and <i>ArrayObject</i> class. Specially, these two can be very handy whenever we want to function them by an object so that the object acts like an array. Briefly, if we want to construct an object that needs to play the role as like an array, we can achieve that by the aid of built-in <i>ArrayAccess</i> interface and <i>ArrayObject</i> class. As a result, we may have access to the features of an array either by implementing or extending these built in interface and class respectively depending on what kinds of features the object needed to perform in our application.
</p>

<p>
The <i>ArrayAccess</i> interface has four abstract methods which are <i>ArrayAccess::offsetExists</i>, <i>ArrayAccess::offsetSet</i>, <i>ArrayAccess::offsetGet</i>, and <i>ArrayAccess::offsetUnset</i>. Additionally, these methods must be defined by the implementing object. On the other hand, by default, <i>ArrayObject</i> class itself implements <i>IteratorAggregate</i>, <i>ArrayAccess</i>, <i>Serializable</i> and <i>Countable</i> interfaces. Consequently, the object which extends <i>ArrayObject</i> class now have almost all the functionalities that any array obtains. But if the object does not obtain some of the features in this way then, we need to do some tricks to get those such as, access to array’s library functions by the object needed some extra effort.
</p>

<p>
OK, let’s now talk about the intention of this article as its title demands. Although it is not always suggested but I am so obsessed about using container through my last few articles that, all the examples I am going to introduce today are also based on containers. Firstly, I will take an example which intentionally produces some errors or notices for using PHP <i><strong>unset()</i></strong> and <i><strong>shuffle()</i></strong> functions by the container object. Secondly I will show, how to mitigate the problems we have faced into the first example by implementing <i>ArrayAccess</i> interface with aid of the container object. In the final example I will convey, how to make the Container object more stable by extending the <i>ArrayObject</i> class so that it can perform on maximum number of features that an array offers.
</p>

<p>
The examples below are mainly focused on to the operation for implementing <i>ArrayAccess</i> and extending <i>ArrayObject</i> by the Container class:
</p>

<p>
<ul>
<li><strong>flights_example.php</strong></li>
<li><strong>ArrayAccess.php</strong></li>
<li><strong>ArrayObject.php</strong></li>
</ul>
</p>

<p>
At first I have constructed the Container class with the support of two PHP magic methods <i><strong>__set()</strong></i> and <i><strong>__get()</strong></i> which initially handle setting and getting properties for the Container object. One can find more details about these two methods by this <i><a href="https://php.net/manual/en/language.oop5.magic.php/">Link</a></i>. The motive of this example is that, I want to execute some regular flights via a number of terminals in a busy airport for performing all the specific tasks which are exclusively handled by the Container object. For that reason, I want to use <i>unset()</i> and <i>shuffle()</i> PHP built-in functions to control the most recent flights from a flights schedules by the limited terminals in some random fashion. But the problem here is that, by the support of these <i>__set()</i> and <i>__get()</i> methods, the Container object is unable to perform the tasks unlike an array which can be seen by the following snippet of code:
</p>

```php
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
```
<p>
In this case, when using <i>unset()</i> and <i>shuffle()</i> functions by the Container object, the program produces four notices like: <i>"Indirect modification of overloaded property has no effect …"</i>. Through the 2nd example we will try to solve these problems. It is mention able that if somebody eager to get more information about how these magic methods <i>__set()</i> and <i>__get()</i> work with the anonymous function shown here then please, visit the article by this <i><a href="https://medium.com/@annuhuss/use-of-lambda-anonymous-functions-closures-and-shared-instances-in-conjunction-with-container-58b95b86c1b8">Link</a></i>.
</p>

<p>
By the example <i>ArrayAccess.php</i> we now have solved the problems which we have faced in <i>flights_example.php</i> and by <i>ArrayObject.php</i>, an object now have greater access to the functionalities that any ordinary array offers.
</p>

<p>
<i>
A detail illustration on this topic and some of my other Object-Oriented-Programming articles can be found in 
<a href="https://medium.com/@annuhuss/">the medium blog site</a>.
</i>
</p>
