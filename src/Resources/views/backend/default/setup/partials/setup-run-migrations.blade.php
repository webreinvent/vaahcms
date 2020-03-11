
<form v-if="active_step == 'run_migrations'">


    <div class="alert alert-danger" role="alert">

        This is step will download required modules and themes.

    </div>


    <div class="form-group row mg-b-0">

        <div class="col-sm-12">
            <button type="submit" class="btn btn-primary" v-on:click="runMigrations($event)">Run Migrations</button>
        </div>

    </div>
</form>