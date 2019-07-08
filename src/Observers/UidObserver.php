<?php

namespace WebReinvent\VaahCms\Observers;

class UidObserver
{
	//-----------------------------------------------------------

    //-----------------------------------------------------------
    public function __construct( ) {

    }

    //-----------------------------------------------------------
    public function creating( $model ) {
        if ( ! isset( $model->uid ) ) {
            $model->uid = uniqid();
        }
        return $model;
    }
	//-----------------------------------------------------------
}
