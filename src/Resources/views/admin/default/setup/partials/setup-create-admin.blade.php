
<form v-if="active_step == 'create_admin_account'" >


    <div class="form-group row">
        <label class="col-sm-3 col-form-label">First Name</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" v-model="admin_info.first_name" placeholder="">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Last Name</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" v-model="admin_info.last_name" placeholder="">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Email</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" v-model="admin_info.email" placeholder="">
        </div>
    </div>


    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Phone</label>
        <div class="col-sm-4">
            <select class="form-control" v-model="admin_info.country_calling_code">

                {!! vh_get_country_list_select_options('calling_code') !!}

            </select>

        </div>
        <div class="col-sm-5">
            <input type="text" class="form-control" v-model="admin_info.phone" placeholder="">
        </div>
    </div>


    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Username</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" v-model="admin_info.username" placeholder="">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Password</label>
        <div class="col-sm-9">
            <input type="password" class="form-control" v-model="admin_info.password" placeholder="">
        </div>
    </div>

    <div class="form-group row mg-b-0">

        <label class="col-sm-3 col-form-label"></label>
        <div class="col-sm-9">
            <button type="submit" class="btn btn-primary" v-on:click="storeAdminUser($event)">Submit</button>
        </div>

    </div>
</form>