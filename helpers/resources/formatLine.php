<?php

namespace Helpers\Resources;

class FormatLine{

    public $mode;
    public $value;

    function __construct($mode, $value){
        $this->mode = $mode;
        $this->value = $value;
    }

    function getFormat(){
        return array(
            'mode' => $this->mode,
            'value' => $this->value
        );
    }
}

?>