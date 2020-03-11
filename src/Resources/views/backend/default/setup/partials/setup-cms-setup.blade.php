
<form v-if="active_step == 'cms_setup'">


    <div class="alert alert-danger" role="alert">

        This is step will download and install required modules and themes!<br/>
        <b>This may take some time.</b>

    </div>


    <div class="form-group row mg-b-0">

        <div class="col-sm-12">
            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input"
                           v-model="cms_setup.cms.install" disabled="disabled" id="cmsInstall">
                    <label class="custom-control-label" for="cmsInstall"><b>CMS Module</b>: Download & Install </label>
                </div>

                <div class="custom-control custom-checkbox mg-t-10 mg-l-10">
                    <input type="checkbox" class="custom-control-input"
                           v-model="cms_setup.cms.sample_data"  id="cmsSampleData">
                    <label class="custom-control-label" for="cmsSampleData">Import Sample Data</label>
                </div>

            </div>



            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input"
                           v-model="cms_setup.theme.install" disabled="disabled" id="themeInstall">
                    <label class="custom-control-label" for="themeInstall"><b>Default Theme</b>: Download & Install </label>
                </div>

                <div class="custom-control custom-checkbox mg-t-10 mg-l-10">
                    <input type="checkbox" class="custom-control-input"
                           v-model="cms_setup.theme.sample_data" id="themeSampleData">
                    <label class="custom-control-label" for="themeSampleData">Import Sample Data</label>
                </div>

            </div>



            <button type="submit" class="btn btn-primary" v-on:click="setupCMS($event)">Download & Install</button>
        </div>

    </div>
</form>