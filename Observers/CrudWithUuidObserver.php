<?php

namespace WebReinvent\VaahCms\Observers;

use Illuminate\Support\Str;

class CrudWithUuidObserver
{
	//-----------------------------------------------------------
    protected $user_id;

    //-----------------------------------------------------------
    public function __construct( $user_id = null ) {
        if ( $user_id == null ) {
            if ( \Auth::check() ) {
                $this->user_id = \Auth::user()->id;
            }
        } else {
            $this->user_id = $user_id;
        }

    }
    //-----------------------------------------------------------
    public function creating( $model ) {
        if ( ! isset( $model->created_by ) ) {
            $model->created_by = $this->user_id;
        }
        if ( ! isset( $model->uuid ) ) {
            $model->uuid = Str::uuid()->toString();
        }

        if ( ! isset( $model->created_at ) ) {
            $model->created_at = \Carbon::now();
        }

        $model->updated_by = $this->user_id;
        $model->updated_at = \Carbon::now();

        return $model;
    }

    //-----------------------------------------------------------
    public function created( $model ) {
        //
    }

    //-----------------------------------------------------------
    public function saving( $model ) {

        $model->updated_by = $this->user_id;
        $model->updated_at = \Carbon::now();

        return $model;
    }

    //-----------------------------------------------------------
    public function saved( $model ) {
        //
    }

    //-----------------------------------------------------------
    public function updating( $model ) {
        $model->updated_by = $this->user_id;
        $model->updated_at = \Carbon::now();

        return $model;
    }

    //-----------------------------------------------------------
    public function updated( $model ) {

    }

    //-----------------------------------------------------------
    public function deleting( $model ) {
        $model->updated_by = $this->user_id;
        $model->updated_at = \Carbon::now();

        $model->deleted_by = $this->user_id;

        return $model;
    }

    //-----------------------------------------------------------
    public function deleted( $model )
    {
    }

    //-----------------------------------------------------------
    public function restoring( $model ) {
        $model->updated_by = $this->user_id;
        $model->updated_at = \Carbon::now();
    }

    //-----------------------------------------------------------
    public function restored( $model ) {
        return $model;
    }
	//-----------------------------------------------------------


    //-----------------------------------------------------------
    public function forceDeleting( $model ) {

        if($model->pivot_relations){
            foreach ($model->pivot_relations as $relation_item){
                $model->{$relation_item}()
                    ->detach();
            }
        }

        if($model->has_morph_relations){
            foreach ($model->has_morph_relations as $relation_item){
                $model->{$relation_item}()
                    ->delete();
            }
        }

    }
	//-----------------------------------------------------------
	//-----------------------------------------------------------
	//-----------------------------------------------------------
	//-----------------------------------------------------------
	//-----------------------------------------------------------
}
