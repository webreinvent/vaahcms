# How to set timezone and daylight timesavings

[[toc]]

## Description
In many project it is required to depict time in the local timezone or in a predefined timezone that can vary from user
to user. This requirement becomes complex if the time also has to account for Daylight Savings Time
that are observed in many countries.

### Using Javascript with moment.js
In case of JS we recommend using [moment.js timezone library](https://momentjs.com/timezone/)


```js
import moment from "moment";

const timestamp =  moment.utc().valueOf();
const timezone = 'Europe/London';

let dst_aware_moment = moment.tz(timestamp, timezone); // create a dst aware moment instance

console.log(dst_aware_moment.format('hh:mm:ss'));
```

### Using PHP/Laravel with Carbon
Using carbon you can directly pass timezone and the result will be dst aware in it self

```php
$time = Carbon::now();
$dst_aware_time =  $time->timezone($time_zone['slug']);

echo $dst_aware_time->format('Y-M-D HH:mm:ss');
```
