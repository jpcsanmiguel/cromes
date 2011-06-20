<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class ArrayClass
{
    public function __construct( $array = array() )
    {
        foreach( $array as $key => $value )
        {
            if( TRUE === is_array($value) )
                $this->$key = new arrayClass( $value );
            else
                $this->$key = $value;
        }
    }
}