<?php namespace WebReinvent\VaahCms\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model {

    use SoftDeletes;
    //-------------------------------------------------
    protected $table = 'vh_permissions';
    //-------------------------------------------------
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    //-------------------------------------------------
    protected $dateFormat = 'Y-m-d H:i:s';
    //-------------------------------------------------
    protected $fillable = [
        'uid',
        'slug',
        'module',
        'section',
        'name',
        'label',
        'details',
        'count_users',
        'count_roles',
        'is_active',
        'synced_at',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    //-------------------------------------------------
    public function setUidAttribute( $value ) {
        $this->attributes['uid'] = strtolower( $value );
    }
    //-------------------------------------------------
    public function setSlugAttribute( $value ) {
        $this->attributes['slug'] = str_slug( $value );
    }
    //-------------------------------------------------
    public function scopeActive( $query ) {
        return $query->where( 'is_active', 1 );
    }

    //-------------------------------------------------
    public function scopeInactive( $query ) {
        return $query->where( 'is_active', 0 );
    }

    //-------------------------------------------------
    public function scopeCreatedBy( $query, $user_id ) {
        return $query->where( 'created_by', $user_id );
    }

    //-------------------------------------------------
    public function scopeUpdatedBy( $query, $user_id ) {
        return $query->where( 'updated_by', $user_id );
    }

    //-------------------------------------------------
    public function scopeDeletedBy( $query, $user_id ) {
        return $query->where( 'deleted_by', $user_id );
    }

    //-------------------------------------------------
    public function scopeCreatedBetween( $query, $from, $to ) {
        return $query->whereBetween( 'created_at', array( $from, $to ) );
    }

    //-------------------------------------------------
    public function scopeUpdatedBetween( $query, $from, $to ) {
        return $query->whereBetween( 'updated_at', array( $from, $to ) );
    }

    //-------------------------------------------------
    public function scopeDeletedBetween( $query, $from, $to ) {
        return $query->whereBetween( 'deleted_at', array( $from, $to ) );
    }

    //-------------------------------------------------
    public function createdBy() {
        return $this->belongsTo( 'WebReinvent\VaahCms\Entities\User',
            'created_by', 'id'
        );
    }
    //-------------------------------------------------
    public function updatedBy() {
        return $this->belongsTo( 'WebReinvent\VaahCms\Entities\User',
            'updated_by', 'id'
        );
    }
    //-------------------------------------------------
    public function deletedBy() {
        return $this->belongsTo( 'WebReinvent\VaahCms\Entities\User',
            'deleted_by', 'id'
        );
    }
    //-------------------------------------------------
    public function roles() {
        return $this->belongsToMany( 'WebReinvent\VaahCms\Entities\Role',
            'vh_role_permissions', 'vh_permission_id', 'vh_role_id'
        );
    }
    //-------------------------------------------------
    //-------------------------------------------------
    //-------------------------------------------------
}
