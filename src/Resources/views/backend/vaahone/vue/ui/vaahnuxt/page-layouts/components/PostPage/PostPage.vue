<template>
  <div class="form-page-v1-layout has-background-light has-padding-top-80 has-padding-bottom-80">

    <div class="container">
      <div class="top-header">
        <div class="columns">
          <div class="column is-6">
            <div class="content  is-bottom-marginless">
              <h2 class="title  is-bottom-marginless">Posts</h2>
            </div>
            <div class="content">
              <ul class="is-left-paddingless is-left-marginless is-top-marginless">
                <li class="is-inline-block"><a href="#">All (8)</a> |</li>
                <li class="is-inline-block"><a href="#">Published (8)</a> |</li>
                <li class="is-inline-block"><a href="#">Trashed (8)</a></li>
              </ul>
            </div>
            <div class="field has-addons">
              <div class="control">
                <b-dropdown aria-role="list">
                  <button class="button" slot="trigger">
                    <span>Bulk Actions</span>
                    <b-icon icon="menu-down"></b-icon>
                  </button>

                  <b-dropdown-item aria-role="listitem">Edit</b-dropdown-item>
                  <b-dropdown-item aria-role="listitem">Move to Trash</b-dropdown-item>
                </b-dropdown>
              </div>
              <div class="control">
                <a class="button is-info">
                  Apply
                </a>
              </div>
            </div>
          </div>
          <div class="column is-6">
            <div class="btn  is-pulled-right is-full-width-mobile">
              <button class="button is-full-width-mobile">+ Add New</button>
            </div>
            <div class="field-class has-margin-top-10 is-pulled-right control">
              <b-field class="control">
                <b-input placeholder="Search..."
                         type="search"
                         icon="magnify">
                </b-input>
              </b-field>
            </div>
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
          <div class="column is-12">
            <b-table
              :data="data"
              :columns="columns"
              class="control"
              checkable
              :checkbox-position="checkboxPosition">

            </b-table>
          </div>
          <div class="column is-4">
            <div class="field has-addons">
              <div class="control">
                <b-dropdown aria-role="list">
                  <button class="button" slot="trigger">
                    <span>Bulk Actions</span>
                    <b-icon icon="menu-down"></b-icon>
                  </button>

                  <b-dropdown-item aria-role="listitem">Edit</b-dropdown-item>
                  <b-dropdown-item aria-role="listitem">Move to Trash</b-dropdown-item>
                </b-dropdown>
              </div>
              <div class="control">
                <a class="button is-info">
                  Apply
                </a>
              </div>
            </div>
          </div>
          <div class="column is-6">
            <b-pagination
              total="200"
              range-before="3"
              range-after="1"
              order="default"
              size="default"
              per-page="10"
              aria-page-label="Page"
              aria-current-label="Current page">
            </b-pagination>
          </div>
          <div class="column is-2 has-text-right">
            <span>8 items</span>
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
        ]
      }
    }
  }
</script>


