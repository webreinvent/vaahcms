<template>
  <div class="crm-page-layout has-background-light">

    <div class="container is-fullhd has-padding-right-20">
      <div class="top-header has-padding-left-20">
        <div class="columns is-flex-mobile">
          <div class="column is-6-mobile">
            <div class="content">
              <h2 class="title">Pipeline</h2>
            </div>
          </div>
          <div class="column is-6-mobile">
            <b-field>
              <b-input placeholder="Search..."
                       type="search"
                       icon="magnify"
                       icon-clickable
                       @icon-click="searchIconClick">
              </b-input>
            </b-field>
          </div>
        </div>
      </div>
      <div class="sort-menu">
        <div class="columns">
          <div class="column is-5">
            <ul>
              <li class="is-inline-block has-margin-right-10">
                <a class="has-text-grey" href="#">
                  <b-icon class="has-text-grey"
                          icon="view-dashboard"
                          size="is-medium">
                  </b-icon>
                </a>
              </li>
              <li class="is-inline-block has-margin-right-10">
                <a class="has-text-grey" href="#">
                  <b-icon class="has-text-grey"
                    icon="table-of-contents"
                    size="is-medium">
                  </b-icon>
                </a>
              </li>
              <li class="is-inline-block has-margin-right-10">
                <a class="has-text-grey" href="#">
                  <b-icon class="has-text-grey"
                    icon="chart-areaspline"
                    size="is-medium">
                  </b-icon>
                </a>
              </li>
              <li class="is-inline-block has-margin-right-10">
                <a class="has-text-grey" href="#">
                  <b-icon class="has-text-grey"
                    icon="calendar-range"
                    size="is-medium">
                  </b-icon>
                </a>
              </li>
              <li class="is-inline-block">
                <a class="has-text-grey" href="#">
                  <b-icon class="has-text-grey"
                    icon="table-large"
                    size="is-medium">
                  </b-icon>
                </a>
              </li>
            </ul>
          </div>
          <div class="column is-7 is-flex-mobile">
            <ul class="has-padding-left-0 is-pulled-right">
              <li class="is-inline-block has-margin-right-10">
                <b-dropdown aria-role="list">
                  <button class="button" slot="trigger">
                    <b-icon class="has-text-grey"
                            icon="filter-variant"
                            size="is-small">
                    </b-icon>
                    <span>Filters</span>
                    <b-icon icon="menu-down"></b-icon>
                  </button>

                  <b-dropdown-item aria-role="listitem">Action</b-dropdown-item>
                  <b-dropdown-item aria-role="listitem">Another action</b-dropdown-item>
                  <b-dropdown-item aria-role="listitem">Something else</b-dropdown-item>
                </b-dropdown>
              </li>
              <li class="is-inline-block has-margin-right-10">
                <b-dropdown aria-role="list">
                  <button class="button" slot="trigger">
                    <b-icon class="has-text-grey"
                            icon="reorder-horizontal"
                            size="is-small">
                    </b-icon>
                    <span>Group By</span>
                    <b-icon icon="menu-down"></b-icon>
                  </button>

                  <b-dropdown-item aria-role="listitem">Action</b-dropdown-item>
                  <b-dropdown-item aria-role="listitem">Another action</b-dropdown-item>
                  <b-dropdown-item aria-role="listitem">Something else</b-dropdown-item>
                </b-dropdown>
              </li>
              <li class="is-inline-block has-margin-right-30">
                <a class="button">
                  <b-icon class="has-text-grey"
                          icon="star"
                          size="is-small">
                  </b-icon>
                  &nbsp;  Favourites
                </a>
              </li>
              <li class="is-inline-block has-margin-right-10">
                <a class="button has-background-light">
                  Create
                </a>
              </li>
              <li class="is-inline-block">
                <a class="button has-background-light">
                  Import
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div>
        <div class="box-area is-flex-desktop justify-flex-start align-items-flex-start has-margin-top-10">
          <div class="box has-padding-15 has-margin-left-20 has-width-550">
            <div class="columns is-flex-mobile">
              <div class="column is-6-mobile">
                <ul class="is-left-paddingless">
                  <li class="is-inline-block">New</li>
                  <li class="is-inline-block"><b-tag rounded class="has-width-40">6</b-tag></li>
                </ul>
              </div>
              <div class="column is-6-mobile is-flex justify-flex-end">
                <div class="content has-text-right has-padding-right-10 has-margin-top-auto has-margin-bottom-auto">
                  <h6 class="subtitle has-text-grey has-margin-top-auto has-margin-bottom-auto">$87,432</h6>
                </div>
              </div>
            </div>
            <div class="columns">
              <div class="column is-12">
                <b-dropdown aria-role="list" class="is-full-width">
                  <button class="button has-background-light is-full-width" slot="trigger">
                    <b-icon class="has-text-grey"
                            icon="filter-variant"
                            size="is-small">
                    </b-icon>
                    <span>Sort by Name A-Z</span>
                    <b-icon icon="menu-down"></b-icon>
                  </button>

                  <b-dropdown-item aria-role="listitem">Action</b-dropdown-item>
                  <b-dropdown-item aria-role="listitem">Another action</b-dropdown-item>
                  <b-dropdown-item aria-role="listitem">Something else</b-dropdown-item>
                </b-dropdown>
              </div>
            </div>
            <div class="data-box box has-margin-top-10">
              <div class="columns is-flex-mobile">
                <div class="column is-9">
                  <div class="content">
                    <h6>Intrest in your graphic design project</h6>
                  </div>
                </div>
                <div class="column is-3">
                  <b-dropdown aria-role="list" class="is-full-width is-pulled-right">
                    <button class="button has-background-light is-full-width" slot="trigger">
                      <span>#22</span>
                      <b-icon icon="dots-vertical"></b-icon>
                    </button>

                    <b-dropdown-item aria-role="listitem">Action</b-dropdown-item>
                    <b-dropdown-item aria-role="listitem">Another action</b-dropdown-item>
                    <b-dropdown-item aria-role="listitem">Something else</b-dropdown-item>
                  </b-dropdown>
                </div>
              </div>
              <div class="columns is-flex-mobile">
                <div class="column is-3">
                  <img src="https://via.placeholder.com/65x65" class="is-rounded">
                </div>
                <div class="column is-9">
                  <div class="content">
                    <span class="has-text-grey is-small">$83,459, Some Company</span>
                    <b-rate icon-pack="mdi"></b-rate><span class="has-text-danger is-pulled-right ">Software</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="data-box box has-margin-top-10">
              <div class="columns is-flex-mobile">
                <div class="column is-9">
                  <div class="content">
                    <h6>Intrest in your graphic design project</h6>
                  </div>
                </div>
                <div class="column is-3">
                  <b-dropdown aria-role="list" class="is-full-width is-pulled-right">
                    <button class="button has-background-light is-full-width" slot="trigger">
                      <span>#22</span>
                      <b-icon icon="dots-vertical"></b-icon>
                    </button>

                    <b-dropdown-item aria-role="listitem">Action</b-dropdown-item>
                    <b-dropdown-item aria-role="listitem">Another action</b-dropdown-item>
                    <b-dropdown-item aria-role="listitem">Something else</b-dropdown-item>
                  </b-dropdown>
                </div>
              </div>
              <div class="columns is-flex-mobile">
                <div class="column is-3">
                  <img src="https://via.placeholder.com/65x65" class="is-rounded">
                </div>
                <div class="column is-9">
                  <div class="content">
                    <span class="has-text-grey is-small">$83,459, Some Company</span>
                    <b-rate icon-pack="mdi"></b-rate><span class="has-text-danger is-pulled-right ">Software</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="data-box box has-margin-top-10">
              <div class="columns is-flex-mobile">
                <div class="column is-9">
                  <div class="content">
                    <h6>Intrest in your graphic design project</h6>
                  </div>
                </div>
                <div class="column is-3">
                  <b-dropdown aria-role="list" class="is-full-width is-pulled-right">
                    <button class="button has-background-light is-full-width" slot="trigger">
                      <span>#22</span>
                      <b-icon icon="dots-vertical"></b-icon>
                    </button>

                    <b-dropdown-item aria-role="listitem">Action</b-dropdown-item>
                    <b-dropdown-item aria-role="listitem">Another action</b-dropdown-item>
                    <b-dropdown-item aria-role="listitem">Something else</b-dropdown-item>
                  </b-dropdown>
                </div>
              </div>
              <div class="columns is-flex-mobile">
                <div class="column is-3">
                  <img src="https://via.placeholder.com/65x65" class="is-rounded">
                </div>
                <div class="column is-9">
                  <div class="content">
                    <span class="has-text-grey is-small">$83,459, Some Company</span>
                    <b-rate icon-pack="mdi"></b-rate><span class="has-text-danger is-pulled-right ">Software</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="data-box box has-margin-top-10">
              <div class="columns is-flex-mobile">
                <div class="column is-9">
                  <div class="content">
                    <h6>Intrest in your graphic design project</h6>
                  </div>
                </div>
                <div class="column is-3">
                  <b-dropdown aria-role="list" class="is-full-width is-pulled-right">
                    <button class="button has-background-light is-full-width" slot="trigger">
                      <span>#22</span>
                      <b-icon icon="dots-vertical"></b-icon>
                    </button>

                    <b-dropdown-item aria-role="listitem">Action</b-dropdown-item>
                    <b-dropdown-item aria-role="listitem">Another action</b-dropdown-item>
                    <b-dropdown-item aria-role="listitem">Something else</b-dropdown-item>
                  </b-dropdown>
                </div>
              </div>
              <div class="columns is-flex-mobile">
                <div class="column is-3">
                  <img src="https://via.placeholder.com/65x65" class="is-rounded">
                </div>
                <div class="column is-9">
                  <div class="content">
                    <span class="has-text-grey is-small">$83,459, Some Company</span>
                    <b-rate icon-pack="mdi"></b-rate><span class="has-text-danger is-pulled-right ">Software</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="data-box box has-margin-top-10">
              <div class="columns is-flex-mobile">
                <div class="column is-9">
                  <div class="content">
                    <h6>Intrest in your graphic design project</h6>
                  </div>
                </div>
                <div class="column is-3">
                  <b-dropdown aria-role="list" class="is-full-width is-pulled-right">
                    <button class="button has-background-light is-full-width" slot="trigger">
                      <span>#22</span>
                      <b-icon icon="dots-vertical"></b-icon>
                    </button>

                    <b-dropdown-item aria-role="listitem">Action</b-dropdown-item>
                    <b-dropdown-item aria-role="listitem">Another action</b-dropdown-item>
                    <b-dropdown-item aria-role="listitem">Something else</b-dropdown-item>
                  </b-dropdown>
                </div>
              </div>
              <div class="columns is-flex-mobile">
                <div class="column is-3">
                  <img src="https://via.placeholder.com/65x65" class="is-rounded">
                </div>
                <div class="column is-9">
                  <div class="content">
                    <span class="has-text-grey is-small">$83,459, Some Company</span>
                    <b-rate icon-pack="mdi"></b-rate><span class="has-text-danger is-pulled-right ">Software</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="data-box box has-margin-top-10">
              <div class="columns is-flex-mobile">
                <div class="column is-9">
                  <div class="content">
                    <h6>Intrest in your graphic design project</h6>
                  </div>
                </div>
                <div class="column is-3">
                  <b-dropdown aria-role="list" class="is-full-width is-pulled-right">
                    <button class="button has-background-light is-full-width" slot="trigger">
                      <span>#22</span>
                      <b-icon icon="dots-vertical"></b-icon>
                    </button>

                    <b-dropdown-item aria-role="listitem">Action</b-dropdown-item>
                    <b-dropdown-item aria-role="listitem">Another action</b-dropdown-item>
                    <b-dropdown-item aria-role="listitem">Something else</b-dropdown-item>
                  </b-dropdown>
                </div>
              </div>
              <div class="columns is-flex-mobile">
                <div class="column is-3">
                  <img src="https://via.placeholder.com/65x65" class="is-rounded">
                </div>
                <div class="column is-9">
                  <div class="content">
                    <span class="has-text-grey is-small">$83,459, Some Company</span>
                    <b-rate icon-pack="mdi"></b-rate><span class="has-text-danger is-pulled-right ">Software</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="box has-padding-15 has-margin-left-20 has-width-550">
            <div class="columns is-flex-mobile">
              <div class="column is-6-mobile">
                <ul class="is-left-paddingless">
                  <li class="is-inline-block">Qualified</li>
                  <li class="is-inline-block"><b-tag rounded class="has-width-40">6</b-tag></li>
                </ul>
              </div>
              <div class="column is-6-mobile is-flex justify-flex-end">
                <div class="content has-text-right has-padding-right-10 has-margin-top-auto has-margin-bottom-auto">
                  <h6 class="subtitle has-text-grey has-margin-top-auto has-margin-bottom-auto">$87,432</h6>
                </div>
              </div>
            </div>
            <div class="columns">
              <div class="column is-12">
                <b-dropdown aria-role="list" class="is-full-width">
                  <button class="button has-background-light is-full-width" slot="trigger">
                    <b-icon class="has-text-grey"
                            icon="filter-variant"
                            size="is-small">
                    </b-icon>
                    <span>Sort by Name A-Z</span>
                    <b-icon icon="menu-down"></b-icon>
                  </button>

                  <b-dropdown-item aria-role="listitem">Action</b-dropdown-item>
                  <b-dropdown-item aria-role="listitem">Another action</b-dropdown-item>
                  <b-dropdown-item aria-role="listitem">Something else</b-dropdown-item>
                </b-dropdown>
              </div>
            </div>
            <div class="data-box box has-margin-top-10">
              <div class="columns is-flex-mobile">
                <div class="column is-9">
                  <div class="content">
                    <h6>Intrest in your graphic design project</h6>
                  </div>
                </div>
                <div class="column is-3">
                  <b-dropdown aria-role="list" class="is-full-width is-pulled-right">
                    <button class="button has-background-light is-full-width" slot="trigger">
                      <span>#22</span>
                      <b-icon icon="dots-vertical"></b-icon>
                    </button>

                    <b-dropdown-item aria-role="listitem">Action</b-dropdown-item>
                    <b-dropdown-item aria-role="listitem">Another action</b-dropdown-item>
                    <b-dropdown-item aria-role="listitem">Something else</b-dropdown-item>
                  </b-dropdown>
                </div>
              </div>
              <div class="columns is-flex-mobile">
                <div class="column is-3">
                  <img src="https://via.placeholder.com/65x65" class="is-rounded">
                </div>
                <div class="column is-9">
                  <div class="content">
                    <span class="has-text-grey is-small">$83,459, Some Company</span>
                    <b-rate icon-pack="mdi"></b-rate><span class="has-text-danger is-pulled-right ">Software</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="data-box box has-margin-top-10">
              <div class="columns is-flex-mobile">
                <div class="column is-9">
                  <div class="content">
                    <h6>Intrest in your graphic design project</h6>
                  </div>
                </div>
                <div class="column is-3">
                  <b-dropdown aria-role="list" class="is-full-width is-pulled-right">
                    <button class="button has-background-light is-full-width" slot="trigger">
                      <span>#22</span>
                      <b-icon icon="dots-vertical"></b-icon>
                    </button>

                    <b-dropdown-item aria-role="listitem">Action</b-dropdown-item>
                    <b-dropdown-item aria-role="listitem">Another action</b-dropdown-item>
                    <b-dropdown-item aria-role="listitem">Something else</b-dropdown-item>
                  </b-dropdown>
                </div>
              </div>
              <div class="columns is-flex-mobile">
                <div class="column is-3">
                  <img src="https://via.placeholder.com/65x65" class="is-rounded">
                </div>
                <div class="column is-9">
                  <div class="content">
                    <span class="has-text-grey is-small">$83,459, Some Company</span>
                    <b-rate icon-pack="mdi"></b-rate><span class="has-text-danger is-pulled-right ">Software</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="data-box box has-margin-top-10">
              <div class="columns is-flex-mobile">
                <div class="column is-9">
                  <div class="content">
                    <h6>Intrest in your graphic design project</h6>
                  </div>
                </div>
                <div class="column is-3">
                  <b-dropdown aria-role="list" class="is-full-width is-pulled-right">
                    <button class="button has-background-light is-full-width" slot="trigger">
                      <span>#22</span>
                      <b-icon icon="dots-vertical"></b-icon>
                    </button>

                    <b-dropdown-item aria-role="listitem">Action</b-dropdown-item>
                    <b-dropdown-item aria-role="listitem">Another action</b-dropdown-item>
                    <b-dropdown-item aria-role="listitem">Something else</b-dropdown-item>
                  </b-dropdown>
                </div>
              </div>
              <div class="columns is-flex-mobile">
                <div class="column is-3">
                  <img src="https://via.placeholder.com/65x65" class="is-rounded">
                </div>
                <div class="column is-9">
                  <div class="content">
                    <span class="has-text-grey is-small">$83,459, Some Company</span>
                    <b-rate icon-pack="mdi"></b-rate><span class="has-text-danger is-pulled-right ">Software</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="data-box box has-margin-top-10">
              <div class="columns is-flex-mobile">
                <div class="column is-9">
                  <div class="content">
                    <h6>Intrest in your graphic design project</h6>
                  </div>
                </div>
                <div class="column is-3">
                  <b-dropdown aria-role="list" class="is-full-width is-pulled-right">
                    <button class="button has-background-light is-full-width" slot="trigger">
                      <span>#22</span>
                      <b-icon icon="dots-vertical"></b-icon>
                    </button>

                    <b-dropdown-item aria-role="listitem">Action</b-dropdown-item>
                    <b-dropdown-item aria-role="listitem">Another action</b-dropdown-item>
                    <b-dropdown-item aria-role="listitem">Something else</b-dropdown-item>
                  </b-dropdown>
                </div>
              </div>
              <div class="columns is-flex-mobile">
                <div class="column is-3">
                  <img src="https://via.placeholder.com/65x65" class="is-rounded">
                </div>
                <div class="column is-9">
                  <div class="content">
                    <span class="has-text-grey is-small">$83,459, Some Company</span>
                    <b-rate icon-pack="mdi"></b-rate><span class="has-text-danger is-pulled-right ">Software</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="data-box box has-margin-top-10">
              <div class="columns is-flex-mobile">
                <div class="column is-9">
                  <div class="content">
                    <h6>Intrest in your graphic design project</h6>
                  </div>
                </div>
                <div class="column is-3">
                  <b-dropdown aria-role="list" class="is-full-width is-pulled-right">
                    <button class="button has-background-light is-full-width" slot="trigger">
                      <span>#22</span>
                      <b-icon icon="dots-vertical"></b-icon>
                    </button>

                    <b-dropdown-item aria-role="listitem">Action</b-dropdown-item>
                    <b-dropdown-item aria-role="listitem">Another action</b-dropdown-item>
                    <b-dropdown-item aria-role="listitem">Something else</b-dropdown-item>
                  </b-dropdown>
                </div>
              </div>
              <div class="columns is-flex-mobile">
                <div class="column is-3">
                  <img src="https://via.placeholder.com/65x65" class="is-rounded">
                </div>
                <div class="column is-9">
                  <div class="content">
                    <span class="has-text-grey is-small">$83,459, Some Company</span>
                    <b-rate icon-pack="mdi"></b-rate><span class="has-text-danger is-pulled-right ">Software</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="data-box box has-margin-top-10">
              <div class="columns is-flex-mobile">
                <div class="column is-9">
                  <div class="content">
                    <h6>Intrest in your graphic design project</h6>
                  </div>
                </div>
                <div class="column is-3">
                  <b-dropdown aria-role="list" class="is-full-width is-pulled-right">
                    <button class="button has-background-light is-full-width" slot="trigger">
                      <span>#22</span>
                      <b-icon icon="dots-vertical"></b-icon>
                    </button>

                    <b-dropdown-item aria-role="listitem">Action</b-dropdown-item>
                    <b-dropdown-item aria-role="listitem">Another action</b-dropdown-item>
                    <b-dropdown-item aria-role="listitem">Something else</b-dropdown-item>
                  </b-dropdown>
                </div>
              </div>
              <div class="columns is-flex-mobile">
                <div class="column is-3">
                  <img src="https://via.placeholder.com/65x65" class="is-rounded">
                </div>
                <div class="column is-9">
                  <div class="content">
                    <span class="has-text-grey is-small">$83,459, Some Company</span>
                    <b-rate icon-pack="mdi"></b-rate><span class="has-text-danger is-pulled-right ">Software</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="box has-padding-15 has-margin-left-20 has-width-550">
            <div class="columns is-flex-mobile">
              <div class="column is-6-mobile">
                <ul class="is-left-paddingless">
                  <li class="is-inline-block">Negotiation</li>
                  <li class="is-inline-block"><b-tag rounded class="has-width-40">6</b-tag></li>
                </ul>
              </div>
              <div class="column is-6-mobile is-flex justify-flex-end">
                <div class="content has-text-right has-padding-right-10 has-margin-top-auto has-margin-bottom-auto">
                  <h6 class="subtitle has-text-grey has-margin-top-auto has-margin-bottom-auto">$87,432</h6>
                </div>
              </div>
            </div>
            <div class="columns">
              <div class="column is-12">
                <b-dropdown aria-role="list" class="is-full-width">
                  <button class="button has-background-light is-full-width" slot="trigger">
                    <b-icon class="has-text-grey"
                            icon="filter-variant"
                            size="is-small">
                    </b-icon>
                    <span>Sort by Name A-Z</span>
                    <b-icon icon="menu-down"></b-icon>
                  </button>

                  <b-dropdown-item aria-role="listitem">Action</b-dropdown-item>
                  <b-dropdown-item aria-role="listitem">Another action</b-dropdown-item>
                  <b-dropdown-item aria-role="listitem">Something else</b-dropdown-item>
                </b-dropdown>
              </div>
            </div>
            <div class="data-box box has-margin-top-10">
              <div class="columns is-flex-mobile">
                <div class="column is-9">
                  <div class="content">
                    <h6>Intrest in your graphic design project</h6>
                  </div>
                </div>
                <div class="column is-3">
                  <b-dropdown aria-role="list" class="is-full-width is-pulled-right">
                    <button class="button has-background-light is-full-width" slot="trigger">
                      <span>#22</span>
                      <b-icon icon="dots-vertical"></b-icon>
                    </button>

                    <b-dropdown-item aria-role="listitem">Action</b-dropdown-item>
                    <b-dropdown-item aria-role="listitem">Another action</b-dropdown-item>
                    <b-dropdown-item aria-role="listitem">Something else</b-dropdown-item>
                  </b-dropdown>
                </div>
              </div>
              <div class="columns is-flex-mobile">
                <div class="column is-3">
                  <img src="https://via.placeholder.com/65x65" class="is-rounded">
                </div>
                <div class="column is-9">
                  <div class="content">
                    <span class="has-text-grey is-small">$83,459, Some Company</span>
                    <b-rate icon-pack="mdi"></b-rate><span class="has-text-danger is-pulled-right ">Software</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="data-box box has-margin-top-10">
              <div class="columns is-flex-mobile">
                <div class="column is-9">
                  <div class="content">
                    <h6>Intrest in your graphic design project</h6>
                  </div>
                </div>
                <div class="column is-3">
                  <b-dropdown aria-role="list" class="is-full-width is-pulled-right">
                    <button class="button has-background-light is-full-width" slot="trigger">
                      <span>#22</span>
                      <b-icon icon="dots-vertical"></b-icon>
                    </button>

                    <b-dropdown-item aria-role="listitem">Action</b-dropdown-item>
                    <b-dropdown-item aria-role="listitem">Another action</b-dropdown-item>
                    <b-dropdown-item aria-role="listitem">Something else</b-dropdown-item>
                  </b-dropdown>
                </div>
              </div>
              <div class="columns is-flex-mobile">
                <div class="column is-3">
                  <img src="https://via.placeholder.com/65x65" class="is-rounded">
                </div>
                <div class="column is-9">
                  <div class="content">
                    <span class="has-text-grey is-small">$83,459, Some Company</span>
                    <b-rate icon-pack="mdi"></b-rate><span class="has-text-danger is-pulled-right ">Software</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="data-box box has-margin-top-10">
              <div class="columns is-flex-mobile">
                <div class="column is-9">
                  <div class="content">
                    <h6>Intrest in your graphic design project</h6>
                  </div>
                </div>
                <div class="column is-3">
                  <b-dropdown aria-role="list" class="is-full-width is-pulled-right">
                    <button class="button has-background-light is-full-width" slot="trigger">
                      <span>#22</span>
                      <b-icon icon="dots-vertical"></b-icon>
                    </button>

                    <b-dropdown-item aria-role="listitem">Action</b-dropdown-item>
                    <b-dropdown-item aria-role="listitem">Another action</b-dropdown-item>
                    <b-dropdown-item aria-role="listitem">Something else</b-dropdown-item>
                  </b-dropdown>
                </div>
              </div>
              <div class="columns is-flex-mobile">
                <div class="column is-3">
                  <img src="https://via.placeholder.com/65x65" class="is-rounded">
                </div>
                <div class="column is-9">
                  <div class="content">
                    <span class="has-text-grey is-small">$83,459, Some Company</span>
                    <b-rate icon-pack="mdi"></b-rate><span class="has-text-danger is-pulled-right ">Software</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="data-box box has-margin-top-10">
              <div class="columns is-flex-mobile">
                <div class="column is-9">
                  <div class="content">
                    <h6>Intrest in your graphic design project</h6>
                  </div>
                </div>
                <div class="column is-3">
                  <b-dropdown aria-role="list" class="is-full-width is-pulled-right">
                    <button class="button has-background-light is-full-width" slot="trigger">
                      <span>#22</span>
                      <b-icon icon="dots-vertical"></b-icon>
                    </button>

                    <b-dropdown-item aria-role="listitem">Action</b-dropdown-item>
                    <b-dropdown-item aria-role="listitem">Another action</b-dropdown-item>
                    <b-dropdown-item aria-role="listitem">Something else</b-dropdown-item>
                  </b-dropdown>
                </div>
              </div>
              <div class="columns is-flex-mobile">
                <div class="column is-3">
                  <img src="https://via.placeholder.com/65x65" class="is-rounded">
                </div>
                <div class="column is-9">
                  <div class="content">
                    <span class="has-text-grey is-small">$83,459, Some Company</span>
                    <b-rate icon-pack="mdi"></b-rate><span class="has-text-danger is-pulled-right ">Software</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="data-box box has-margin-top-10">
              <div class="columns is-flex-mobile">
                <div class="column is-9">
                  <div class="content">
                    <h6>Intrest in your graphic design project</h6>
                  </div>
                </div>
                <div class="column is-3">
                  <b-dropdown aria-role="list" class="is-full-width is-pulled-right">
                    <button class="button has-background-light is-full-width" slot="trigger">
                      <span>#22</span>
                      <b-icon icon="dots-vertical"></b-icon>
                    </button>

                    <b-dropdown-item aria-role="listitem">Action</b-dropdown-item>
                    <b-dropdown-item aria-role="listitem">Another action</b-dropdown-item>
                    <b-dropdown-item aria-role="listitem">Something else</b-dropdown-item>
                  </b-dropdown>
                </div>
              </div>
              <div class="columns is-flex-mobile">
                <div class="column is-3">
                  <img src="https://via.placeholder.com/65x65" class="is-rounded">
                </div>
                <div class="column is-9">
                  <div class="content">
                    <span class="has-text-grey is-small">$83,459, Some Company</span>
                    <b-rate icon-pack="mdi"></b-rate><span class="has-text-danger is-pulled-right ">Software</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="data-box box has-margin-top-10">
              <div class="columns is-flex-mobile">
                <div class="column is-9">
                  <div class="content">
                    <h6>Intrest in your graphic design project</h6>
                  </div>
                </div>
                <div class="column is-3">
                  <b-dropdown aria-role="list" class="is-full-width is-pulled-right">
                    <button class="button has-background-light is-full-width" slot="trigger">
                      <span>#22</span>
                      <b-icon icon="dots-vertical"></b-icon>
                    </button>

                    <b-dropdown-item aria-role="listitem">Action</b-dropdown-item>
                    <b-dropdown-item aria-role="listitem">Another action</b-dropdown-item>
                    <b-dropdown-item aria-role="listitem">Something else</b-dropdown-item>
                  </b-dropdown>
                </div>
              </div>
              <div class="columns is-flex-mobile">
                <div class="column is-3">
                  <img src="https://via.placeholder.com/65x65" class="is-rounded">
                </div>
                <div class="column is-9">
                  <div class="content">
                    <span class="has-text-grey is-small">$83,459, Some Company</span>
                    <b-rate icon-pack="mdi"></b-rate><span class="has-text-danger is-pulled-right ">Software</span>
                  </div>
                </div>
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
    props: ['content']
  }
</script>


