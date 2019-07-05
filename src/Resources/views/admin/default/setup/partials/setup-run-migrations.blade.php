
<form v-if="active_step == 'cms_setup'">


    <div class="alert alert-danger" role="alert">

        This is step will download required modules and themes.

    </div>


    <div class="form-group row mg-b-0">

        <div class="col-sm-12">

            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="customCheck1">
                    <label class="custom-control-label" for="customCheck1">Custom checkbox</label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" v-on:click="runMigrations($event)">Run Migrations</button>
        </div>

    </div>
</form>