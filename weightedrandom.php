<?php
/*
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
#PARTICULAR PURPOSE.						                        #
##############################LICENSE################################
*/

/**
 * weightedrandom()
 * @abstract A class to generate random results, with a focus on allowing "weights" for items in the bucket.
 * @abstract Weights can be even - such as with a coin, can be loaded - like a cheaters dice, or a mix - like a loot box would be in a videogame.
 * @abstract Calculations and results can be performed multiple times on the same object.
 * @example To create a weighted random class object: $wrandom = new weightedrandom();
 * @example To create a weighted random class object using preloaded items: $wrandom = new weightedrandom("colors");
 * @example To create a weighted random class object using custom items and weights: $wrandom = new weightedrandom(array("Whiskey" => 20,"Beer" => 10,"Gin" => 5,"Vodka" => 8));
 * @example To return a single random item from the $wrandom object: $wrandom->return_single_random_item();
 * @example To return an array with 250 randomly selected weighted results from the $wrandom object: $wrandom->return_array_random_results(250);
 * @example To calculate (with no return) 5000 randomly selected weighted results from the $wrandom object: $wrandom->calculate_multiple_results(5000);
 * @example to print a chart with pertinant information, first calculate results then: $wrandom->print_results_table();
 */ 
class weightedrandom
{
    /**
     * VARIABLE DEFINITIONS
     */ 
    private $totalweight = 0; //weight of all items
    private $totalitems = 0; //count of all items
    private $itemarray = null; //array with items and weight
    private $resultarray = null; //array with results
    private $numberofresults = 0; //number of results to generate
    

    /**
     * weightedrandom::__construct()
     * @var $items - null, associative arry, or string. 
     *      Pass null to use defaults. 
     *      Pass an array of arrays, where the inside arrays are array("Object" => *Weight*, "Object" => *Weight*) etc and *weight* is any positive integer. Duplicates are ignored.
     *      Pass the string options of: "color", "coin", "dice", "lootbox" for preloaded items with lootbox being the default.
     * @return null
     */
    function __construct($items = null)
    {
        //see if the $item passed is an array, a default, or null
        if(!is_null($items) AND is_array($items))
        {
            $this->set_itemarray($items);
        }//end else
        elseif(!is_null($items) AND !is_array($items))
        {
            $this->set_default_item_array($items);
        }//end elseif
        else
        {
           $this->set_default_item_array(); 
        }//end else

        //calculate weight
        $this->calculate_total_weight();
    }//end function construct
    
    
    /**
     * weightedrandom::__destruct()
     * @var none
     * @return null
     */
    function __destruct()
    {
        
    }//end function destruct
    
    
    /**
     * SET FUNCTIONS
     */
    private function set_totalweight($value){ $this->totalweight = $value; }
    private function set_totalitems($value){ $this->totalitems = $value; }
    public function set_itemarray($value){ $this->itemarray = $value; }
    private function set_resultarray($value){ $this->resultarray = $value; }
    public function set_numberofresults($value){ $this->numberofresults = $value; }
    
    
    /**
     * GET FUNCTIONS
     */
    private function get_totalweight(){ return $this->totalweight; }
    private function get_totalitems(){ return $this->totalitems; }
    private function get_itemarray(){ return $this->itemarray; }
    private function get_resultarray(){ return $this->resultarray; }
    private function get_numberofresults(){ return $this->numberofresults; }
    
    
    /**
     * weightedrandom::set_default_item_array()
     * @abstract Sets the items for use in the bag.
     * @var $data - String. Pass the string options of: "color", "coin", "dice", "lootbox" for preloaded items with lootbox being the default.
     *      "color" - Five colors with different weights.
     *      "coin" - Double sided coin with correct weights - 50/50 - useful for doing heads vs tails.
     *      "dice" - Six-sided "cheaters dice" with the Five having a slightly higher chance of winning.
     *      "lootbox" - Default - 12 different items with varying weights.
     * @return null
     */
    private function set_default_item_array($data = "lootbox")
    {
        $items = null;
        if($data == "color")
        {
            //color array with 5 items
            $items = array("Red" => 20,
                            "Blue" => 10,
                            "Pink" => 15,
                            "Purple" => 1,
                            "Black" => 54);
        }//end if
        elseif($data == "coin")
        {
            //coin array with 2 items, to test correct randomness
            $items = array("Heads" => 1,
                        "Tails" => 1);
        }//end elseif
        elseif($data == "dice")
        {
            //6 sided dice
            $items = array("One" => 2,
                            "Two" => 2,
                            "Three" => 2,
                            "Four" => 2,
                            "Five" => 3,
                            "Six" => 2);
        }//end elseif
        else
        {
            //loot box
            $items = array("Bow" => 57,
                            "Axe" => 94,
                            "Crossbow" => 41,
                            "Dagger" => 18,
                            "Javelin" => 91,
                            "Polearm" => 67,
                            "Scepter" => 64,
                            "Spear" => 6,
                            "Stave" => 84,
                            "Sword" => 53,
                            "Wand" => 22,
                            "Mace" => 56);
        }//end else
        
        //set the items array
        $this->set_itemarray($items);
    }//end function set_default_item_array
    
    
    /**
     * weightedrandom::calculate_total_weight()
     * @abstract Calculates the weight of all items in the bag and stores in the object.
     * @var none
     * @return null
     */    
    private function calculate_total_weight()
    {
        //cycle through item array
        foreach($this->get_itemarray() as $key => $value)
        {
            //add weights from item array to totalweight
            $this->set_totalweight($this->get_totalweight() + $value);
            
            //set total items
            $this->set_totalitems($this->get_totalitems() + 1);
        }//end foreach
    }//end function calculate_weight
    
    
    /**
     * weightedrandom::return_random_number()
     * @abstract Calculates the weight of all items in the bag and stores in the object.
     * @var $max - Integer. Maximum number to return (this should be equal to the bag weight).
     * @return integer
     */ 
    private function return_random_number($max = 2)
    {
        return rand(1, $max);
    }//end function return_random_number
    

    /**
     * weightedrandom::return_single_random_item()
     * @abstract Provides a single weighted random result from the bag.
     * @var none
     * @return string - the name of a random weighted single item from the bag
     */ 
    public function return_single_random_item()
    {
        //get a random number
        $randnum = $this->return_random_number($this->get_totalweight());

        //cycle through the array
        foreach($this->get_itemarray() as $key => $value)
        {
            //take the weight of the item from the random number
            $randnum -= $value;
            
            //see if the random number is now 0 or less
            if($randnum <= 0)
            {
                //if yes - return the item name
                return $key;
                break 1;
            }//end if
        
        }//end foreach
    }//end function return_single_random_item
    
    
    /**
     * weightedrandom::return_array_random_results()
     * @abstract Provides weighted random results from the bag as an array.
     * @var $numresults - Integer. Number of results to calculate and return in the array.
     * @return associative array - an array with each item and the number of times it was selected. Format is array(array("Object1" => *Count*, "Object2" => *Count*)) where *Count* is an integer.
     */ 
    public function return_array_random_results($numresults = 50000)
    {
        $this->set_numberofresults($numresults);
        $this->calculate_multiple_results($this->get_numberofresults());
        return $this->get_resultarray();
    }//end function return_array_random_results
    
    
    /**
     * weightedrandom::calculate_multiple_results()
     * @abstract Populates the results array with weighted random results.
     * @var $numresults - Integer. Number of results to calculate..
     * @return null
     */ 
    public function calculate_multiple_results($numresults = 50000)
    {
        //set number of results
        $this->set_numberofresults($numresults);
        $counter = $this->get_numberofresults();
        
        $results;
        //create them results
        while($counter > 0)
        {
            $results[$this->return_single_random_item()]++;
            $counter--;
        }//end while
        
        //set object array
        $this->set_resultarray($results);

    }//end function calculate_multiple_results
    
    
    /**
     * weightedrandom::print_results_table()
     * @abstract Prints a table with information about the inputs and results of the last ran weighted random calculation. Must call calculate_multiple_results() first.
     * @var none
     * @return null
     */ 
    public function print_results_table()
    {
        echo "Total items: ".$this->get_totalitems()."<br />";
        echo "Total weight: ".$this->get_totalweight()."<br />";
        echo "Total rolls: ".$this->get_numberofresults()."<br />";
        echo "<br /><table border=1><tr><td>Item</td><td>Weight</td><td>% Weight</td><td>Result Count</td><td>Result %</td><td>Difference</td></tr>";
        foreach($this->get_itemarray() as $key => $value)
        {
            $percentweight = round(($value/$this->get_totalweight())*100,3);
            $resultcount = $this->get_resultarray()[$key];
            $percentresult = round(($resultcount/$this->get_numberofresults())*100,3);
            $percentoff = round(($percentweight-$percentresult)*-1,3);
            echo "<tr><td>$key</td><td>$value</td><td>$percentweight</td><td>$resultcount</td><td>$percentresult</td><td>$percentoff</td></tr>";        
        }//end foreach
        echo "</table><br /><br /><br />";
    }//end function print_results_table
    
}//end class weightedrandom
?>
