<template>
  <div class="form-page-v1-layout has-background-light has-padding-top-80 has-padding-bottom-80">

    <div class="container is-fluid">
      <div class="columns">
        <div class="column is-6">
          <div class="box">
            <div class="columns">
              <div class="column is-6">
                <div class="content">
                  <h2>Registrations</h2>
                </div>
              </div>
              <div class="column is-6">
                <div class="field has-addons is-pulled-right">
                  <p class="control">
                    <a class="button has-background-light">
                      + Add New
                    </a>
                  </p>
                  <p class="control">
                    <a class="button has-background-light">
                      <b-icon
                        icon="dots-horizontal"
                        size="is-small">
                      </b-icon>
                    </a>
                  </p>
                  <p class="control">
                    <a class="button has-background-light">
                      <b-icon
                        icon="reload"
                        size="is-small">
                      </b-icon>
                    </a>
                  </p>
                </div>
              </div>
              <div class="column is-12">
                <ul class="is-pulled-right">
                  <li class="is-inline-block">
                    <b-dropdown aria-role="list">
                      <button class="button" slot="trigger">
                        <span>All Dates</span>
                        <b-icon icon="menu-down"></b-icon>
                      </button>

                      <b-dropdown-item aria-role="listitem">Edit</b-dropdown-item>
                      <b-dropdown-item aria-role="listitem">Move to Trash</b-dropdown-item>
                    </b-dropdown>
                  </li>
                  <li class="is-inline-block">
                    <b-dropdown aria-role="list">
                      <button class="button" slot="trigger">
                        <span>All Categories</span>
                        <b-icon icon="menu-down"></b-icon>
                      </button>

                      <b-dropdown-item aria-role="listitem">Edit</b-dropdown-item>
                      <b-dropdown-item aria-role="listitem">Move to Trash</b-dropdown-item>
                    </b-dropdown>
                  </li>
                  <li class="is-inline-block">
                    <b-dropdown aria-role="list">
                      <button class="button" slot="trigger">
                        <span>All Formats</span>
                        <b-icon icon="menu-down"></b-icon>
                      </button>

                      <b-dropdown-item aria-role="listitem">Edit</b-dropdown-item>
                      <b-dropdown-item aria-role="listitem">Move to Trash</b-dropdown-item>
                    </b-dropdown>
                  </li>
                  <li class="is-inline-block">
                    <a class="button is-info">
                      Filter
                    </a>
                  </li>
                </ul>
              </div>
              <div class="column is-6">
                <div class="field has-addons">
                  <p class="control">
                    <b-dropdown aria-role="list">
                      <button class="button" slot="trigger">
                        <span>Bulk Actions</span>
                        <b-icon icon="menu-down"></b-icon>
                      </button>

                      <b-dropdown-item aria-role="listitem">Edit</b-dropdown-item>
                      <b-dropdown-item aria-role="listitem">Update</b-dropdown-item>
                      <b-dropdown-item aria-role="listitem">Delete</b-dropdown-item>
                    </b-dropdown>
                  </p>
                  <p class="control">
                    <a class="button has-background-light">
                      Apply
                    </a>
                  </p>
                </div>
              </div>
              <div class="column is-6">
                <b-field class="control">
                  <b-input placeholder="Search..."
                           type="search"
                           icon="magnify">
                  </b-input>
                </b-field>
              </div>
              <div class="column is-12">
                <b-table
                  :data="data"
                  :columns="columns"
                  class="control"
                  checkable
                  :checkbox-position="checkboxPosition">
                </b-table>
              </div>
            </div>
          </div>
        </div>
        <div class="column is-6">
          <div class="box">
            <div class="columns">
              <div class="column is-6">
                <div class="content">
                  <h2>ID: 1</h2>
                </div>
              </div>
              <div class="column is-6">
                <div class="field has-addons is-pulled-right">
                  <p class="control">
                    <a class="button has-background-light">
                      <b-icon
                        icon="check"
                         class="has-margin-right-10"
                        size="is-small">
                      </b-icon>
                     Save
                    </a>
                  </p>
                  <p class="control">
                    <a class="button has-background-light">
                      <b-icon
                        icon="pencil"
                        size="is-small">
                      </b-icon>
                    </a>
                  </p>
                  <p class="control">
                    <a class="button has-background-light">
                      <b-icon
                        icon="dots-vertical"
                        size="is-small">
                      </b-icon>
                    </a>
                  </p>
                </div>
              </div>
              <div class="column is-12">
                <b-table
                  class="is-full-width"
                  :striped="true"
                  :data="dataForm"
                  :mobile-cards="true">

                  <template slot-scope="props">

                    <b-table-column field="type" label="">
                      {{props.row.product_name}}
                    </b-table-column>

                    <b-table-column field="description" label="">
                      {{props.row.description}}
                    </b-table-column>
                  </template>
                </b-table>
                <b-table
                  class="is-full-width"
                  :striped="true"
                  :data="dataForm"
                  :mobile-cards="true">

                  <template slot-scope="props">

                    <b-table-column field="type" label="">
                      {{props.row.product_name}}
                    </b-table-column>

                    <b-table-column field="description" label="">
                      <b-field>
                        <b-input :value="props.row.description"></b-input>
                      </b-field>
                    </b-table-column>
                  </template>
                </b-table>
              </div>
            </div>
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
        { 'id': 1, 'title': 'Lorem ipsum dolor sit amet, consectetur adipisicing.', 'author': 'Simmons'},
        { 'id': 2, 'title': 'Lorem ipsum dolor sit amet, consectetur adipisicing.', 'author': 'Jacobs'},
        { 'id': 3, 'title': 'Lorem ipsum dolor sit amet, consectetur adipisicing.', 'author': 'Gilbert'},
        { 'id': 4, 'title': 'Lorem ipsum dolor sit amet, consectetur adipisicing.', 'author': 'Flores'},
        { 'id': 5, 'title': 'Lorem ipsum dolor sit amet, consectetur adipisicing.', 'author': 'Lee'}
      ]

      return {
         dataForm : [
          { 'product_name': 'Id', 'description':'1'},
          { 'product_name': 'Title', 'description':'Lorem ipsum dolor sit amet, consectetur adipisicing.'},
          { 'product_name': 'Author', 'description':'Simmons'},
          { 'product_name': 'Categories', 'description':'XYZ, ABC'},
          { 'product_name': 'Gender', 'description':'Male'},
          { 'product_name': 'Date', 'description':'5 April, 2019'},
        ],
        data,
        checkboxPosition: 'left',
        columns: [
          {
            field: 'id',
            label: 'ID',
            numeric: true,
            width: '80',
          },
          {
            field: 'title',
            label: 'Title',
          },
          {
            field: 'author',
            label: 'Author',
          },
        ]
      }
    }
  }
</script>


