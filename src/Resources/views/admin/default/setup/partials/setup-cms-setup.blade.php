
<form v-if="active_step == 'cms_setup'">


    <div class="alert alert-danger" role="alert">

        This is step will download and install required modules and themes!

    </div>


    <div class="form-group row mg-b-0">

        <div class="col-sm-12">
            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input"
                           v-model="cms_setup.cms.install" disabled="disabled" id="cmsInstall">
                    <label class="custom-control-label" for="cmsInstall">CMS Module: Download & Install </label>
                </div>
            </div>

            <div class="form-grou mg-l-10">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input"
                           v-model="cms_setup.cms.sample_data"  id="cmsSampleData">
                    <label class="custom-control-label" for="cmsSampleData">CMS Module: Import Sample Data</label>
                </div>
            </div>

            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input"
                           v-model="cms_setup.theme.install" disabled="disabled" id="themeInstall">
                    <label class="custom-control-label" for="themeInstall">Default Theme: Download & Install </label>
                </div>
            </div>

            <div class="form-grou mg-l-10">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input"
                           v-model="cms_setup.theme.sample_data" id="themeSampleData">
                    <label class="custom-control-label" for="themeSampleData">Default Theme: Import Sample Data</label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" v-on:click="runMigrations($event)">Run Migrations</button>
        </div>

    </div>
</form>