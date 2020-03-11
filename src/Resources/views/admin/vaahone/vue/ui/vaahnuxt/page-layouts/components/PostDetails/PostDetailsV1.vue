<template>
  <div class="form-page-v1-layout has-background-light has-padding-top-80 has-padding-bottom-80">

    <div class="container">
      <div class="top-header">
        <div class="columns">

          <div class="column is-6">
            <div class="content  is-bottom-marginless">
              <h2 class="title  is-bottom-marginless">Edit Posts</h2>
            </div>
          </div>

          <div class="column is-6">
            <div class="btn  is-pulled-right is-full-width-mobile">
              <button class="button is-full-width-mobile">+ Add New</button>
            </div>
          </div>

          <div class="column is-8">
            <div class="is-full-width">
              <b-field>
                <b-input placeholder="Add Title"></b-input>
              </b-field>
            </div>

            <div class="has-margin-top-15">
              <span><b>Permalink: </b><a href="https://demo.nuxt.vaah.dev/ui/page-layouts/layout-v1">
                https://demo.nuxt.vaah.dev/ui/page-layouts/layout-v1</a> <a href="#"><b-icon
                class="has-text-dark"
                icon="pencil"
                size="is-small">
              </b-icon>Edit</a></span>
            </div>

            <div class="field has-addons has-margin-top-15">
              <p class="control">
                <a class="button is-static">
                  https://demo.nuxt.vaah.dev/ui
                </a>
              </p>
              <p class="control is-expanded">
                <input class="input" type="text" value="/page-layouts/layout-v1">
              </p>
              <p class="control is-expanded">
                <a class="button is-info">Save</a>
              </p>
            </div>

            <div class="btn has-margin-top-10">
              <button class="button"><b-icon
                icon="camera"
                size="is-small"
                class="has-margin-right-5">
              </b-icon>Add Media</button>
            </div>

            <div class="box has-backgound-light has-margin-top-30">
              <div class="buttons">
                <button class="button">ul</button>
                <button class="button">ol</button>
                <button class="button">p</button>
                <button class="button">heading</button>
                <button class="button">link</button>
                <button class="button"><del>text</del></button>
                <button class="button">input</button>
                <button class="button">img</button>
                <button class="button">div</button>
                <button class="button">quote</button>
                <button class="button">b</button>
                <button class="button">u</button>
              </div>
            </div>

            <b-field label="">
              <b-input height="500" maxlength="200" type="textarea" placeholder="Enter Text here"></b-input>
            </b-field>

            <div class="custom-fields ">
              <div class="content">
                <h3>Custom Fields</h3>
              </div>

              <div class="custom-field has-border-1">
                <div class="has-padding-15 has-background-white is-outlined">
                  <b><a href="#" class="has-text-dark">First Name</a></b>
                  <b-tag>first_name</b-tag>&nbsp;<b-tag>input</b-tag>
                  <span class="is-pulled-right">
                    <a href="#">
                      <b-icon
                      icon="align-justify"
                      size="is-small"
                    >
                    </b-icon>
                    </a>
                    <a>
                      <b-icon
                      icon="menu-down">
                    </b-icon>
                    </a>
                  </span>
                  <hr class="has-margin-top-15 is-bottom-marginless">
                </div>
                <div class="has-padding-right-20 has-padding-left-20 has-padding-bottom-20 has-background-white">
                   <div class="content">
                    <b-field label="First Name">
                      <b-input placeholder="First Name"></b-input>
                    </b-field>
                  </div>
                </div>
              </div>

              <div class="custom-field has-border-1 has-margin-top-15">
                <div class="has-padding-15 has-background-white is-outlined">
                  <b><a href="#" class="has-text-dark">Message</a></b> &nbsp;
                  <b-tag>message</b-tag>&nbsp;<b-tag>textarea</b-tag>
                  <span class="is-pulled-right">
                    <a href="#">
                      <b-icon
                      icon="align-justify"
                      size="is-small"
                    >
                    </b-icon>
                    </a>
                    <a>
                      <b-icon
                      icon="menu-down">
                    </b-icon>
                    </a>
                  </span>
                  <hr class="has-margin-top-15 is-bottom-marginless">
                </div>
                <div class="has-padding-right-20 has-padding-left-20 has-padding-bottom-20 has-background-white">
                   <div class="content">
                    <b-field label="Message">
                      <b-input placeholder="Message" type="textarea"></b-input>
                    </b-field>
                  </div>
                </div>
              </div>

              <div class="custom-field has-border-1 has-margin-top-15">
                <div class="has-padding-15 has-background-white is-outlined">
                  <b><a href="#" class="has-text-dark">Gender</a></b> &nbsp;
                  <b-tag>gender</b-tag>&nbsp;<b-tag>radio_button</b-tag>
                  <span class="is-pulled-right">
                    <a href="#">
                      <b-icon
                      icon="align-justify"
                      size="is-small"
                    >
                    </b-icon>
                    </a>
                    <a>
                      <b-icon
                      icon="menu-down">
                    </b-icon>
                    </a>
                  </span>
                  <hr class="has-margin-top-15 is-bottom-marginless">
                </div>
                <div class="has-padding-right-20 has-padding-left-20 has-padding-bottom-20 has-background-white">
                   <div class="content">
                     <div class="block">
                       <b-radio
                                name="Male"
                                native-value="Male">
                         Male
                       </b-radio>
                       <b-radio
                                name="Female"
                                native-value="Female">
                         Female
                       </b-radio>
                     </div>
                   </div>
                </div>
              </div>

              <div class="custom-field has-border-1 has-margin-top-15">
                <div class="has-padding-15 has-background-white is-outlined">
                  <b><a href="#" class="has-text-dark">Agree to T&C</a></b> &nbsp;
                  <b-tag>t&c</b-tag>&nbsp;<b-tag>checkbox</b-tag>
                  <span class="is-pulled-right">
                    <a href="#">
                      <b-icon
                      icon="align-justify"
                      size="is-small"
                    >
                    </b-icon>
                    </a>
                    <a>
                      <b-icon
                      icon="menu-down">
                    </b-icon>
                    </a>
                  </span>
                  <hr class="has-margin-top-15 is-bottom-marginless">
                </div>
                <div class="has-padding-right-20 has-padding-left-20 has-padding-bottom-20 has-background-white">
                   <div class="content">
                     <div class="field">
                       <b-checkbox>I agree to following <a>Terms & Conditions.</a></b-checkbox>
                     </div>
                   </div>
                </div>
              </div>

              <div class="custom-field has-border-1 has-margin-top-15">
                <div class="has-padding-15 has-background-white is-outlined">
                  <b><a href="#" class="has-text-dark">Rating</a></b> &nbsp;
                  <b-tag>rating</b-tag>&nbsp;<b-tag>star_rating</b-tag>
                  <span class="is-pulled-right">
                    <a href="#">
                      <b-icon
                      icon="align-justify"
                      size="is-small"
                    >
                    </b-icon>
                    </a>
                    <a>
                      <b-icon
                      icon="menu-down">
                    </b-icon>
                    </a>
                  </span>
                  <hr class="has-margin-top-15 is-bottom-marginless">
                </div>
                <div class="has-padding-right-20 has-padding-left-20 has-padding-bottom-20 has-background-white">
                   <div class="content">
                     <b-rate custom-text="Custom Text Goes Here"></b-rate>
                   </div>
                </div>
              </div>

              <div class="custom-field has-border-1 has-margin-top-15">
                <div class="has-padding-15 has-background-white is-outlined">
                  <b><a href="#" class="has-text-dark">Price Filter</a></b> &nbsp;
                  <b-tag>price_filer</b-tag>&nbsp;<b-tag>range_slider</b-tag>
                  <span class="is-pulled-right">
                    <a href="#">
                      <b-icon
                      icon="align-justify"
                      size="is-small"
                    >
                    </b-icon>
                    </a>
                    <a>
                      <b-icon
                      icon="menu-down">
                    </b-icon>
                    </a>
                  </span>
                  <hr class="has-margin-top-15 is-bottom-marginless">
                </div>
                <div class="has-padding-right-20 has-padding-left-20 has-padding-bottom-20 has-background-white">
                   <div class="content">
                     <b-field>
                       <b-slider :min="50" :max="15000" :step="1">
                       </b-slider>
                     </b-field>
                   </div>
                </div>
              </div>

              <div class="custom-field has-border-1 has-margin-top-15">
                <div class="has-padding-15 has-background-white is-outlined">
                  <b><a href="#" class="has-text-dark">Update Image</a></b> &nbsp;
                  <b-tag>update_image</b-tag>&nbsp;<b-tag>file_upload</b-tag>
                  <span class="is-pulled-right">
                    <a href="#">
                      <b-icon
                      icon="align-justify"
                      size="is-small"
                    >
                    </b-icon>
                    </a>
                    <a>
                      <b-icon
                      icon="menu-down">
                    </b-icon>
                    </a>
                  </span>
                  <hr class="has-margin-top-15 is-bottom-marginless">
                </div>
                <div class="has-padding-right-20 has-padding-left-20 has-padding-bottom-20 has-background-white">
                   <div class="content">
                     <b-field class="file">
                       <b-upload v-model="file">
                         <a class="button is-primary">
                           <b-icon icon="upload"></b-icon>
                           <span>Click to upload</span>
                         </a>
                       </b-upload>
                       <span class="file-name" v-if="file">
                            {{ file.name }}
                       </span>
                     </b-field>
                   </div>
                </div>
              </div>

              <div class="custom-field has-border-1 has-margin-top-15">
                <div class="has-padding-15 has-background-white is-outlined">
                  <b><a href="#" class="has-text-dark">Remember Me</a></b> &nbsp;
                  <b-tag>remember_me</b-tag>&nbsp;<b-tag>switch</b-tag>
                  <span class="is-pulled-right">
                    <a href="#">
                      <b-icon
                      icon="align-justify"
                      size="is-small"
                    >
                    </b-icon>
                    </a>
                    <a>
                      <b-icon
                      icon="menu-down">
                    </b-icon>
                    </a>
                  </span>
                  <hr class="has-margin-top-15 is-bottom-marginless">
                </div>
                <div class="has-padding-right-20 has-padding-left-20 has-padding-bottom-20 has-background-white">
                   <div class="content">
                     <div class="field">
                       <b-switch>Default</b-switch>
                     </div>
                   </div>
                </div>
              </div>

              <div class="custom-field has-border-1 has-margin-top-15">
                <div class="has-padding-15 has-background-white is-outlined">
                  <b><a href="#" class="has-text-dark">Search</a></b> &nbsp;
                  <b-tag>search</b-tag>&nbsp;<b-tag>autocomplete</b-tag>
                  <span class="is-pulled-right">
                    <a href="#">
                      <b-icon
                      icon="align-justify"
                      size="is-small"
                    >
                    </b-icon>
                    </a>
                    <a>
                      <b-icon
                      icon="menu-down">
                    </b-icon>
                    </a>
                  </span>
                  <hr class="has-margin-top-15 is-bottom-marginless">
                </div>
                <div class="has-padding-right-20 has-padding-left-20 has-padding-bottom-20 has-background-white">
                   <div class="content">
                     <b-field label="Find a JS framework">
                       <b-autocomplete
                         rounded
                         v-model="name"
                         :data="filteredDataArray"
                         placeholder="e.g. jQuery"
                         icon="magnify"
                         @select="option => selected = option">
                         <template slot="empty">No results found</template>
                       </b-autocomplete>
                     </b-field>
                   </div>
                </div>
              </div>

              <div class="custom-field has-border-1 has-margin-top-15">
                <div class="has-padding-15 has-background-white is-outlined">
                  <b><a href="#" class="has-text-dark">Add Tags</a></b> &nbsp;
                  <b-tag>add_tags</b-tag>&nbsp;<b-tag>taginput</b-tag>
                  <span class="is-pulled-right">
                    <a href="#">
                      <b-icon
                      icon="align-justify"
                      size="is-small"
                    >
                    </b-icon>
                    </a>
                    <a>
                      <b-icon
                      icon="menu-down">
                    </b-icon>
                    </a>
                  </span>
                  <hr class="has-margin-top-15 is-bottom-marginless">
                </div>
                <div class="has-padding-right-20 has-padding-left-20 has-padding-bottom-20 has-background-white">
                   <div class="content">
                     <b-field label="Add some tags">
                       <b-taginput
                         v-model="tags"
                         ellipsis
                         icon="label"
                         placeholder="Add a tag">
                       </b-taginput>
                     </b-field>
                   </div>
                </div>
              </div>

              <div class="custom-field has-border-1 has-margin-top-15">
                <div class="has-padding-15 has-background-white is-outlined">
                  <b><a href="#" class="has-text-dark">Author</a></b> &nbsp;
                  <b-tag>author</b-tag>&nbsp;<b-tag>select</b-tag>
                  <span class="is-pulled-right">
                    <a href="#">
                      <b-icon
                      icon="align-justify"
                      size="is-small"
                    >
                    </b-icon>
                    </a>
                    <a>
                      <b-icon
                      icon="menu-down">
                    </b-icon>
                    </a>
                  </span>
                  <hr class="has-margin-top-15 is-bottom-marginless">
                </div>
                <div class="has-padding-right-20 has-padding-left-20 has-padding-bottom-20 has-background-white">
                   <div class="content">
                     <b-field label="Select a author">
                       <b-select placeholder="Select a author">
                         <option
                           v-for="option in data"
                           :value="option.id"
                           :key="option.id">
                           {{ option.author }}
                         </option>
                       </b-select>
                     </b-field>
                   </div>
                </div>
              </div>

              <div class="custom-field has-border-1 has-margin-top-15">
                <div class="has-padding-15 has-background-white is-outlined">
                  <b><a href="#" class="has-text-dark">Select Due Date</a></b> &nbsp;
                  <b-tag>due_date</b-tag>&nbsp;<b-tag>date_time_picker</b-tag>
                  <span class="is-pulled-right">
                    <a href="#">
                      <b-icon
                      icon="align-justify"
                      size="is-small"
                    >
                    </b-icon>
                    </a>
                    <a>
                      <b-icon
                      icon="menu-down">
                    </b-icon>
                    </a>
                  </span>
                  <hr class="has-margin-top-15 is-bottom-marginless">
                </div>
                <div class="has-padding-right-20 has-padding-left-20 has-padding-bottom-20 has-background-white">
                   <div class="content">
                     <b-field label="Select Due Date">
                       <b-datetimepicker
                         rounded
                         placeholder="Click to select..."
                         icon="calendar-today"
                         :datepicker="false"
                         :timepicker="false">
                       </b-datetimepicker>
                     </b-field>
                   </div>
                </div>
              </div>

              <div class="custom-field has-border-1 has-margin-top-15">
                <div class="has-padding-15 has-background-white is-outlined">
                  <b><a href="#" class="has-text-dark">Currency</a></b> &nbsp;
                  <b-tag>currency</b-tag>&nbsp;<b-tag>field_addons</b-tag>
                  <span class="is-pulled-right">
                    <a href="#">
                      <b-icon
                      icon="align-justify"
                      size="is-small"
                    >
                    </b-icon>
                    </a>
                    <a>
                      <b-icon
                      icon="menu-down">
                    </b-icon>
                    </a>
                  </span>
                  <hr class="has-margin-top-15 is-bottom-marginless">
                </div>
                <div class="has-padding-right-20 has-padding-left-20 has-padding-bottom-20 has-background-white">
                   <div class="content">
                     <b-field>
                       <b-select placeholder="Currency">
                         <option>$</option>
                         <option>£</option>
                         <option>€</option>
                       </b-select>
                       <b-input type="number" placeholder="0,00"></b-input>
                       <p class="control">
                         <button class="button is-success">Transfer</button>
                       </p>
                     </b-field>
                   </div>
                </div>
              </div>

            </div>

            <b-collapse
              class="card has-margin-top-15"
              v-for="(collapse, index) of collapses"
              :key="index"
              :open="isOpen == index"
              @open="isOpen = index">
              <div
                slot="trigger"
                slot-scope="props"
                class="card-header"
                role="button">
                <p class="card-header-title">
                  {{ collapse.title }}
                </p>
                <a class="card-header-icon">
                  <b-icon
                    :icon="props.open ? 'menu-down' : 'menu-up'">
                  </b-icon>
                </a>
              </div>
              <div class="card-content">
                <div class="content">
                  <p>{{ collapse.text }}</p>
                  <b-dropdown aria-role="list">
                    <button class="button" slot="trigger">
                      <span>Default</span>
                      <b-icon icon="menu-down"></b-icon>
                    </button>

                    <b-dropdown-item aria-role="listitem">Default</b-dropdown-item>
                  </b-dropdown>
                </div>
              </div>
            </b-collapse>

          </div>

          <div class="column is-4">

            <b-collapse
              class="card">
              <div
                slot="trigger"
                slot-scope="props"
                class="card-header"
                role="button">
                <p class="card-header-title">
                  Publish
                </p>
                <a class="card-header-icon">
                  <b-icon
                    :icon="props.open ? 'menu-down' : 'menu-up'">
                  </b-icon>
                </a>
              </div>
              <div class="card-content">
                <div class="content">
                  <div class="columns">
                    <div class="column is-6">
                      <b-field label="Page Name">
                        <b-input value="page-details-v2"
                                 type="text">
                        </b-input>
                      </b-field>
                    </div>
                    <div class="column is-6">
                      <div class="btn has-text-right has-margin-top-30">
                        <button class="button">Preview Changes</button>
                      </div>
                    </div>
                  </div>

                  <div class="is-left-paddingless is-left-marginless">
                    <p>
                      Status: <b>Published</b> <a href="">Edit</a>
                    </p>
                    <b-dropdown aria-role="list">
                      <button class="button" slot="trigger">
                        <span>Published</span>
                        <b-icon icon="menu-down"></b-icon>
                      </button>

                      <b-dropdown-item aria-role="listitem">Unpublished</b-dropdown-item>
                      <b-dropdown-item aria-role="listitem">Draft</b-dropdown-item>
                      <b-dropdown-item aria-role="listitem">Scheduled Publish</b-dropdown-item>
                    </b-dropdown>
                    <p class="has-margin-top-5">
                      Visibility: <b>Public</b> <a href="">Edit</a>
                    </p>
                    <b-dropdown aria-role="list">
                      <button class="button" slot="trigger">
                        <span>Public</span>
                        <b-icon icon="menu-down"></b-icon>
                      </button>

                      <b-dropdown-item aria-role="listitem">Private</b-dropdown-item>
                      <b-dropdown-item aria-role="listitem">Only Admin</b-dropdown-item>
                      <b-dropdown-item aria-role="listitem">None</b-dropdown-item>
                    </b-dropdown>
                    <p class="has-margin-top-5">
                      Revisions: <b>17</b> <a href="">Browse</a>
                    </p>
                    <b-dropdown aria-role="list">
                      <button class="button" slot="trigger">
                        <span>17</span>
                        <b-icon icon="menu-down"></b-icon>
                      </button>

                      <b-dropdown-item aria-role="listitem">11</b-dropdown-item>
                      <b-dropdown-item aria-role="listitem">15</b-dropdown-item>
                      <b-dropdown-item aria-role="listitem">14</b-dropdown-item>
                    </b-dropdown>
                    <p class="has-margin-top-5">
                      Published on: <b>Feb 15, 2020 at 06:43</b> <a href="">edit</a>
                    </p>
                    <b-field label="Select datetime">
                      <b-datetimepicker
                        rounded
                        placeholder="Click to select..."
                        icon="calendar-today"
                        :datepicker="false"
                        :timepicker="false">
                      </b-datetimepicker>
                    </b-field>
                  </div>
                  <div class="box has-margin-top-10">
                    <div class="columns">
                      <div class="column is-6">
                        <a class="has-text-danger button is-text" href="">Move to Trash</a>
                      </div>
                      <div class="column is-6">
                        <button class="button is-info has-text-right is-pulled-right">Publish</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </b-collapse>

            <b-collapse
              class="card has-margin-top-40">
              <div
                slot="trigger"
                slot-scope="props"
                class="card-header"
                role="button">
                <p class="card-header-title">
                  Page Attributes
                </p>
                <a class="card-header-icon">
                  <b-icon
                    :icon="props.open ? 'menu-down' : 'menu-up'">
                  </b-icon>
                </a>
              </div>
              <div class="card-content">
                <div class="content">
                  <p class="label">Template</p>
                  <b-dropdown aria-role="list">
                    <button class="button" slot="trigger">
                      <span>Default Template</span>
                      <b-icon icon="menu-down"></b-icon>
                    </button>

                    <b-dropdown-item aria-role="listitem">Default Template</b-dropdown-item>
                    <b-dropdown-item aria-role="listitem">Template 1</b-dropdown-item>
                    <b-dropdown-item aria-role="listitem">Template 2</b-dropdown-item>
                  </b-dropdown>
                  <b-field label="Order">
                    <b-input value="0"></b-input>
                  </b-field>
                </div>
              </div>
            </b-collapse>

            <b-collapse
              class="card has-margin-top-40">
              <div
                slot="trigger"
                slot-scope="props"
                class="card-header"
                role="button">
                <p class="card-header-title">
                  Feature Image
                </p>
                <a class="card-header-icon">
                  <b-icon
                    :icon="props.open ? 'menu-down' : 'menu-up'">
                  </b-icon>
                </a>
              </div>
              <div class="card-content">
                <div class="content">
                  <a href="">Set Feature Image</a>
                  <b-field class="file has-margin-top-20">
                    <b-upload v-model="fileUpload">
                      <a class="button is-primary">
                        <b-icon icon="upload"></b-icon>
                        <span>Click to upload</span>
                      </a>
                    </b-upload>
                    <span class="file-name" v-if="file">
                        {{ file.name }}
                    </span>
                  </b-field>
                </div>
              </div>
            </b-collapse>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script>


  export default {
    props: ['content'],
    data () {
      const data = [
        { 'id': 1, 'title': 'Lorem ipsum dolor sit amet, consectetur adipisicing.', 'author': 'Simmons', 'categories': 'XYZ, ABC', 'tag_data': 'Male', 'date': '5 April, 2020' },
        { 'id': 2, 'title': 'Lorem ipsum dolor sit amet, consectetur adipisicing.', 'author': 'Jacobs', 'categories': 'XYZ, ABC', 'tag_data': 'Male', 'date': '5 April, 2020' },
        { 'id': 3, 'title': 'Lorem ipsum dolor sit amet, consectetur adipisicing.', 'author': 'Gilbert', 'categories': 'XYZ, ABC', 'tag_data': 'Female', 'date': '5 April, 2020' },
        { 'id': 4, 'title': 'Lorem ipsum dolor sit amet, consectetur adipisicing.', 'author': 'Flores', 'categories': 'XYZ, ABC', 'tag_data': 'Male', 'date': '5 April, 2020' },
        { 'id': 5, 'title': 'Lorem ipsum dolor sit amet, consectetur adipisicing.', 'author': 'Lee', 'categories': 'XYZ, ABC', 'tag_data': 'Female', 'date': '5 April, 2020' }
      ]

      return {
        dataSearch: [
          'Angular',
          'Angular 2',
          'Aurelia',
          'Backbone',
          'Ember',
          'jQuery',
          'Meteor',
          'Node.js',
          'Polymer',
          'React',
          'RxJS',
          'Vue.js'
        ],
        name: '',
        selected: null,
        file: null,
        fileUpload: null,
        isOpen: 0,
        collapses: [
          {
            title: 'Slider Revolution Option',
            text: 'Choose Slide Template'
          }
        ],
        data,
        checkboxPosition: 'left',
        columns: [
          {
            field: 'id',
            label: 'ID',
            width: '40',
            numeric: true
          },
          {
            field: 'title',
            label: 'Title',
          },
          {
            field: 'author',
            label: 'Author',
          },
          {
            field: 'categories',
            label: 'Categories',
            centered: true
          },
          {
            field: 'tag_data',
            label: 'Tags',
          },
          {
            field: 'date',
            label: 'Date',
          }
        ],
        tags: [
          'Auckland',
          'Wellington',
          'Very long string that would overflow'
        ]
      }
    },
    computed: {
      filteredDataArray() {
        return this.dataSearch.filter((option) => {
          return option
            .toString()
            .toLowerCase()
            .indexOf(this.name.toLowerCase()) >= 0
        })
      }
    }
  }
</script>


