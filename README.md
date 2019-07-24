<h1>
PHPs predefined ArrayAccess interface and ArrayObject class: Make an object that acts as arrays, really!
</h1>

<p>
<em>PHP</em> ships with a number of predefined classes and interfaces, two of the common out of them are <i><strong>ArrayAccess</strong></i> interface and <i><strong>ArrayObject</strong></i> class. Specially, these two can be very handy whenever objects requires the features of arrays. <i>According to PHP documentation, if a class implements <i>ArrayAccess</i> then objects of that class can be accessed as we access arrays. On the other hand, a class that extends <i>ArrayObject</i>, objects of that class work as arrays</i>.	
</p>

<p>
The <i>ArrayAccess</i> interface has four abstract methods, which are <i><strong>ArrayAccess::offsetExists</strong></i>, <i><strong>ArrayAccess::offsetSet</strong></i>, <i><strong>ArrayAccess::offsetGet</strong></i>, and <i><strong>ArrayAccess::offsetUnset</strong></i>. Now, somebody may ask the question: <i><strong>what is an abstract method</strong>? A method that does not obtain any implementation, more specifically, a method that does not hold a body, is known as abstract method </i>. Thus each of these abstract methods further needs an implementation.
</p>

<p>
By default, <i>ArrayObject</i> class implements <i><strong>IteratorAggregate</strong></i>, <i><strong>ArrayAccess</strong></i>, <i><strong>Serializable</strong></i> and <i><strong>Countable</strong></i> interfaces. As a result, all abstract methods of these interfaces are already implemented by built-in <i>ArrayObject</i> class. Therefore, when we extend <i>ArrayObject</i> class by other classes, we may only need to override some of the methods from <i>ArrayObject</i> class. We will see the fact by the last example.
</p>

<p>
OK, let's now talk about how to introduce the above features through our examples sequentially. Although it is not always be appropriate to use a Dependency Injection Container, but I am so obsessed about using DI Container through my last few articles that, all the examples I am going to introduce today are also based on DI Container. The article on DI container can be reached by this <i><a href="https://medium.com/@annuhuss/dependency-injection-container-a-simple-introduction-for-managing-objects-from-their-creation-to-cebbcb772694">Link</a></i>
</p>

<p>
Firstly, we will take an example whereby we intentionally produce some errors or notices for using PHPs <i><strong>unset()</i></strong> and <i><strong>shuffle()</strong></i> functions. Secondly, we will show how to mitigate the problems by implementing <i>ArrayAccess</i> interface by the Container class. In the final example, by extending <i>ArrayObject</i> class by the Container class, we will create objects that perform like arrays.
</p>

<p>
The examples below are mainly focused on the operations for implementing <i>ArrayAccess</i> and extending <i>ArrayObject</i> by the Container class:
</p>

<p>
<ul>
<li><strong>flights_example.php</strong></li>
<li><strong>ArrayAccess.php</strong></li>
<li><strong>ArrayObject.php</strong></li>
</ul>
</p>

<p>
At first I have constructed the Container class with the support of two PHP magic methods <i><strong>__set()</strong></i> and <i><strong>__get()</strong></i> which initially handle setting and getting properties for the Container object. One can find more details about these two methods by this <i><a href="https://php.net/manual/en/language.oop5.magic.php/">Link</a></i>. The motive of this example is that, I want to execute some regular flights via a number of terminals in a busy airport for performing all the specific tasks which are exclusively handled by the Container object. For that reason, I want to use <i>unset()</i> and <i>shuffle()</i> PHPs built-in functions to control the most recent flights from a flights schedules by the limited terminals in some random fashion. But the problem here is that, by the support of these <i>__set()</i> and <i>__get()</i> methods, the Container object is unable to perform the tasks unlike arrays which can be seen by the following snippet of code:
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
In this case, when using <i>unset()</i> and <i>shuffle()</i> functions by the Container object, the program produces four notices as: <i>"Indirect modification of overloaded property has no effect …"</i>. Through the 2nd example we will try to solve these problems. It is mention able that if somebody eager to get more information about how these magic methods <i>__set()</i> and <i>__get()</i> work with the anonymous function shown here then please, visit the article by this <i><a href="https://medium.com/@annuhuss/use-of-lambda-anonymous-functions-closures-and-shared-instances-in-conjunction-with-container-58b95b86c1b8">Link</a></i>.
</p>

<p>
By the example <i>ArrayAccess.php</i> we now have solved the problems which we have faced in <i>flights_example.php</i> and by <i>ArrayObject.php</i>, an object now have greater access to the functionalities that any ordinary array offers.
</p>

<p></p>

<p><i>Stars from the audience would be always appreciated.</i></p>

<p></p>

<p><i>
A detail illustration of this topic and some of my other articles on different topics can be reached by 
<a href="https://medium.com/@annuhuss/">the medium blog site</a>.
</i></p>
