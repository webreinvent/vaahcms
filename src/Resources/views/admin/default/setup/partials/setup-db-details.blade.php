
<form v-if="active_step == 'database'">

    <div class="form-group row">
        <label for="name" class="col-sm-3 col-form-label">App/Web Name</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" v-model="app_info.app_name" id="name" placeholder="">
            <ul class="parsley-errors-list filled" id="parsley-id-5">
                <li class="parsley-required">Only alpha numeric characters are allowed</li>
            </ul>
        </div>
    </div>

    <div class="form-group row">
        <label for="dbhost" class="col-sm-3 col-form-label">DB Host</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" v-model="app_info.db_host" id="dbhost" placeholder="Database Host Name">
        </div>
    </div>
    <div class="form-group row">
        <label for="dbport" class="col-sm-3 col-form-label">DB Port</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" v-model="app_info.db_port" id="dbport" placeholder="Database Port">
        </div>
    </div>


    <div class="form-group row">
        <label for="dbname" class="col-sm-3 col-form-label">DB Name</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" v-model="app_info.db_database" id="dbname" placeholder="Database Name">
        </div>
    </div>

    <div class="form-group row">
        <label for="dbusername" class="col-sm-3 col-form-label">DB Username</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" v-model="app_info.db_username" id="dbusername" placeholder="Database Username">
        </div>
    </div>

    <div class="form-group row">
        <label for="dbpassword" class="col-sm-3 col-form-label">DB Password</label>
        <div class="col-sm-9">
            <input type="password" class="form-control" v-model="app_info.db_password" id="dbpassword" placeholder="Password">
        </div>
    </div>

    <div class="form-group row mg-b-0">

        <label class="col-sm-3 col-form-label"></label>
        <div class="col-sm-9">
            <button type="submit" class="btn btn-primary" v-on:click="storeAppInfo($event)">Submit</button>
        </div>

    </div>
</form>