# php_weighted_random
A PHP7 class to generate weighted random results. This may also be called "biased random", "reservoir sampling", or "lootbox" by some folks.
Weights or bias can be:
Even - such as with a coin where the odds are 50/50
Loaded - like a cheaters dice where one side has slightly higher odds of being rolled
Mixed - like a loot box would be in a videogame

Calculations and results can be performed multiple times on the same object.
 
## Getting Started
Be running PHP 7 on your web server.

Download weightedrandom.php to the appropriate directory.

Create a $wrandom object.

Call functions as needed.


## Available Functions
$wrandom->return_single_random_item() - Returns a single weighted random item name as a string.

$wrandom->return_array_random_results($num = 50000) - Returns an array  with each item and the number of times it was selected. If a number is provided this is the number of items selected.




## Examples

```
<?
//add weightedrandom file

require_once("weightedrandom.php");

//create $wrandom object

$wrandom = new weightedrandom();



//return a single random item

echo $wrandom->return_single_random_item();




//return reults after 50,000 picks
print_r($wrandom->return_array_random_results(50000));



?>
```

The above would result in:

Single item:
```
Polearm
```

Array result:
```
Array
(
    [Axe] => 7202
    [Mace] => 4368
    [Sword] => 4147
    [Crossbow] => 3191
    [Scepter] => 4982
    [Polearm] => 5166
    [Javelin] => 6836
    [Stave] => 6327
    [Bow] => 4321
    [Wand] => 1620
    [Dagger] => 1384
    [Spear] => 456
)
```


## Acknowledgments
The method of calculating the weighted random as used in this program is from:
https://stackoverflow.com/questions/1761626/weighted-random-numbers
https://blogs.msdn.microsoft.com/spt/2008/02/05/reservoir-sampling/
https://xlinux.nist.gov/dads//HTML/reservoirSampling.html

## Misc
I did not do spell check.

## License
```
##############################LICENSE################################
#Copyright (c) 2019 Eric Wamsley.                                   #
#All rights reserved.                                               #
#                                                                   #
#Redistribution and use in source and binary forms are permitted    #
#provided that the above copyright notice and this paragraph are    #
#duplicated and viewable in all forms and that any documentation,   #
#advertising materials, and other materials related to such         #
#distribution and use acknowledge that the software was developed   #
#by ERIC WAMSLEY. THIS SOFTWARE IS PROVIDED "AS IS" AND WITHOUT     #
#ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, WITHOUT LIMITATION,  #
#THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A        #
#PARTICULAR PURPOSE.                                                #
##############################LICENSE################################
```
