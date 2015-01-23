# Mothership Control Panel

### Main menu building

### Group markup

This is the markup required for groups of content, repeatable groups and dual column groups.

```
<!-- Normal group -->
<section class="group">
	<h2 class="title">Group title</h2>
	<div class="content">
		...
	</div>
</section>

<!-- Group grid layout -->
<section class="group-grid">
	<div class="row">
		<div class="group">
			<h2 class="title">Group title</h2>
			<div class="content">
				...
			</div>
		</div>
		<div class="group">
			<h2 class="title">Group title</h2>
			<div class="content">
				...
			</div>
		</div>
		<div class="group">
			<h2 class="title">Group title</h2>
			<div class="content">
				...
			</div>
		</div>
	</div>
</section>

<!-- Repeatable group -->
<section class="repeatable-group">
	<div class="group">
		<h2 class="title">Group title</h2>
		<div class="content">
			...
		</div>
	</div>
	<div class="group">
		<h2 class="title">Group title</h2>
		<div class="content">
			...
		</div>
	</div>
	<div class="group">
		<h2 class="title">Group title</h2>
		<div class="content">
			...
		</div>
	</div>
	<div class="group">
		<h2 class="title">Group title</h2>
		<div class="content">
			...
		</div>
	</div>
</section>

<!-- Dual column  -->
<section class="dual-column">
	<h2 class="title">Test title</h2>
	<div class="content">
		<div class="column">
			...
		</div>
		<div class="column">
			...
		</div>
	</div>
</section>
```


## Dashboards and Statistics

### Datasets

**Register new dataset**

```php
$services->extend('statistics', function($statistics, $c) {
    // Simple value counter
	$statistics->add(new MyDataset($c['db.query'], $c['statistics.counter'], $c['statistics.range.date']));

	// Key based counter
	$statistics->add(new MyKeyDataset($c['db.query'], $c['statistics.counter.key'], $c['statistics.range.date']));
});
```

```php
class MyDataset extends AbstractDataset
{
    public function getName()
    {
        return 'my.dataset';
    }

    public function getPeriodLength()
    {
        return static::DAILY;
    }

    public function rebuild()
    {
        // add rebuilding sql to transaction and commit if not overridden
    }
}
```

**Get a dataset**

```php
$dataset = $this->get('statistics')->get('my.dataset');
```

**Push a value**

```php
$dataset->counter->push($value);
```

**Set a value by key**

```php
$dataset->counter->set($key, $value);
```

**Get the current counter**

```php
$dataset->counter->get();
$dataset->counter->get($key);
```

**Increment / decrement**

```php
$dataset->counter->increment();
$dataset->counter->decrement($step);

$dataset->counter->decrement($key);
$dataset->counter->increment($key, $step);
```

**Get a range of values**

```php
// From the beginning of time
$values = $dataset->range->getValues(0);

// From a week ago
$values = $dataset->range->getValues(
    $dataset->range->getWeekAgo()
);

// Previous month
$values = $dataset->range->getValues(
    $dataset->range->getMonthAgo(1),
    $dataset->range->getMonthAgo()
);
```

**Get a range of values with keys**

```php
$data = $dataset->range->getKeyValues(0);
```

**Get average of values**

```php
$monthAverage = $dataset->range->getAverage(
    $dataset->range->getMonthAgo()
);
```

**Get total of values**

```php
$yearToDate = $dataset->range->getTotal(
    $dataset->range->getYearAgo()
);
```

## License

Mothership E-Commerce
Copyright (C) 2015 Jamie Freeman

This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see <http://www.gnu.org/licenses/>.
