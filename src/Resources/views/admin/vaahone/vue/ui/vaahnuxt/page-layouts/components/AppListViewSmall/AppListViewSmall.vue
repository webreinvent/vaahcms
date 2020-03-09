<template>
  <div class="app-list-view-small has-background-light has-padding-top-30 has-padding-bottom-30">
    <div class="container is-fluid">
      <div class="columns">
        <div class="column is-4 has-background-white">
          <aside class="has-background-white has-margin-top-5 has-margin-bottom-5">
            <div class="columns has-padding-15">
              <div class="column is-6">
                <div class="content">
                  <h2 class="is-bottom-marginless">Orders</h2>
                </div>
              </div>
              <div class="column is-6">
                <div class="field has-addons is-pulled-right">
                  <p class="control">
                    <a class="button has-background-grey-lighter">
                      + Add Items
                    </a>
                  </p>
                  <p class="control">
                    <b-dropdown aria-role="list" class="is-full-width is-pulled-right">
                      <button class="button has-background-grey-lighter is-full-width" slot="trigger">
                        <b-icon icon="dots-vertical"></b-icon>
                      </button>

                      <b-dropdown-item aria-role="listitem">Action</b-dropdown-item>
                      <b-dropdown-item aria-role="listitem">Another action</b-dropdown-item>
                      <b-dropdown-item aria-role="listitem">Something else</b-dropdown-item>
                    </b-dropdown>
                  </p>
                </div>
              </div>
              <div class="column is-12">
                <b-field label="">
                  <b-input placeholder="Search by Name, Id, email"></b-input>
                </b-field>
              </div>
            </div>
            <div class="has-background-grey-lighter has-padding-15">
              <div class="columns">
                <div class="column is-6">
                  <div class="content">
                    <h2 class="is-bottom-marginless">Filter By</h2>
                  </div>
                </div>
                <div class="column is-6">
                  <button class="button has-background-light is-pulled-right">
                    Apply Filter
                  </button>
                </div>
                <div class="column is-10">
                  <div class="content">
                    <h3 class="is-bottom-marginless">Status</h3>
                  </div>
                </div>
                <div class="column is-2 has-text-right">
                  <b-tag class="is-pulled-right" rounded>6</b-tag>
                </div>
                <div class="column is-12">
                  <div class="field">
                    <b-checkbox>Pending</b-checkbox>
                  </div>
                  <div class="field">
                    <b-checkbox>Paid</b-checkbox>
                  </div>
                  <div class="field">
                    <b-checkbox>In-progress</b-checkbox>
                  </div>
                  <div class="field">
                    <b-checkbox>Completed</b-checkbox>
                  </div>
                  <div class="field">
                    <b-checkbox>Cancelled</b-checkbox>
                  </div>
                  <div class="field">
                    <b-checkbox>Waiting</b-checkbox>
                  </div>
                </div>
                <div class="column is-10">
                  <div class="content">
                    <h3 class="is-bottom-marginless">Created By</h3>
                  </div>
                </div>
                <div class="column is-2 has-text-right">
                  <b-tag class="is-pulled-right" rounded>6</b-tag>
                </div>
                <div class="column is-12">
                  <div class="field">
                    <b-checkbox>Pending</b-checkbox>
                  </div>
                  <div class="field">
                    <b-checkbox>Paid</b-checkbox>
                  </div>
                  <div class="field">
                    <b-checkbox>In-progress</b-checkbox>
                  </div>
                  <div class="field">
                    <b-checkbox>Completed</b-checkbox>
                  </div>
                  <div class="field">
                    <b-checkbox>Cancelled</b-checkbox>
                  </div>
                  <div class="field">
                    <b-checkbox>Waiting</b-checkbox>
                  </div>
                </div>
              </div>
            </div>
            <div class="box is-bottom-marginless">
              <div class="columns">
                <div class="column is-7">
                  <div class="field">
                    <b-checkbox>#0035</b-checkbox>
                  </div>
                </div>
                <div class="column is-5">
                  <div class="content">
                    <p class="has-text-grey has-text-right">$1,245,214</p>
                  </div>
                </div>
                <div class="column is-7">
                  <div class="content">
                    <p class="has-text-grey"><span class="has-text-info">S-0032</span> |  16 sept, 2019</p>
                  </div>
                </div>
                <div class="column is-5">
                  <div class="content">
                    <p class="has-text-success has-text-right">Paid</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="box is-bottom-marginless">
              <div class="columns">
                <div class="column is-7">
                  <div class="field">
                    <b-checkbox>#0035</b-checkbox>
                  </div>
                </div>
                <div class="column is-5">
                  <div class="content">
                    <p class="has-text-grey has-text-right">$1,245,214</p>
                  </div>
                </div>
                <div class="column is-7">
                  <div class="content">
                    <p class="has-text-grey"><span class="has-text-info">S-0032</span> |  16 sept, 2019</p>
                  </div>
                </div>
                <div class="column is-5">
                  <div class="content">
                    <p class="has-text-success has-text-right">Paid</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="box is-bottom-marginless">
              <div class="columns">
                <div class="column is-7">
                  <div class="field">
                    <b-checkbox>#0035</b-checkbox>
                  </div>
                </div>
                <div class="column is-5">
                  <div class="content">
                    <p class="has-text-grey has-text-right">$1,245,214</p>
                  </div>
                </div>
                <div class="column is-7">
                  <div class="content">
                    <p class="has-text-grey"><span class="has-text-info">S-0032</span> |  16 sept, 2019</p>
                  </div>
                </div>
                <div class="column is-5">
                  <div class="content">
                    <p class="has-text-success has-text-right">Paid</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="box is-bottom-marginless">
              <div class="columns">
                <div class="column is-7">
                  <div class="field">
                    <b-checkbox>#0035</b-checkbox>
                  </div>
                </div>
                <div class="column is-5">
                  <div class="content">
                    <p class="has-text-grey has-text-right">$1,245,214</p>
                  </div>
                </div>
                <div class="column is-7">
                  <div class="content">
                    <p class="has-text-grey"><span class="has-text-info">S-0032</span> |  16 sept, 2019</p>
                  </div>
                </div>
                <div class="column is-5">
                  <div class="content">
                    <p class="has-text-success has-text-right">Paid</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="box is-bottom-marginless">
              <div class="columns">
                <div class="column is-7">
                  <div class="field">
                    <b-checkbox>#0035</b-checkbox>
                  </div>
                </div>
                <div class="column is-5">
                  <div class="content">
                    <p class="has-text-grey has-text-right">$1,245,214</p>
                  </div>
                </div>
                <div class="column is-7">
                  <div class="content">
                    <p class="has-text-grey"><span class="has-text-info">S-0032</span> |  16 sept, 2019</p>
                  </div>
                </div>
                <div class="column is-5">
                  <div class="content">
                    <p class="has-text-success has-text-right">Paid</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="sidebar-pagination has-margin-top-40">
              <div class="columns">
                <div class="column is-2">
                  <b-dropdown aria-role="list">
                    <button class="button" slot="trigger">
                      <span>10</span>
                      <b-icon icon="menu-down"></b-icon>
                    </button>

                    <b-dropdown-item aria-role="listitem">Action</b-dropdown-item>
                    <b-dropdown-item aria-role="listitem">Another action</b-dropdown-item>
                    <b-dropdown-item aria-role="listitem">Something else</b-dropdown-item>
                  </b-dropdown>
                </div>
                <div class="column is-10">
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
              </div>
            </div>
          </aside>
        </div>
        <div class="column is-8 has-background-white">
          <div class="columns has-padding-15">
            <div class="column is-6">
              <div class="content">
                <h2 class="is-bottom-marginless">Create Order</h2>
              </div>
            </div>
            <div class="column is-6">
              <div class="field has-addons is-pulled-right">
                <p class="control">
                  <a class="button has-background-grey-lighter">
                    <b-icon icon="help"></b-icon>
                  </a>
                </p>
                <p class="control">
                  <a class="button has-background-grey-lighter">
                    Save
                  </a>
                </p>
                <p class="control">
                  <a class="button has-background-grey-lighter">
                    <b-icon icon="close"></b-icon>
                  </a>
                </p>
              </div>
            </div>
            <div class="column is-12">
              <b-tabs>
                <b-tab-item label="Form Elements">
                  <div class="columns">
                    <div class="column is-6">
                      <b-field label="Address #1">
                        <b-input placeholder="Address #1" disabled></b-input>
                      </b-field>
                      <b-field label="Address 1">
                        <b-input placeholder="Enter Address 1"></b-input>
                      </b-field>
                      <b-field label="Address 2">
                        <b-input placeholder="Enter Address 2"></b-input>
                      </b-field>
                      <b-field label="Country" class="is-full-width">
                        <b-dropdown aria-role="list" class="is-full-width">
                          <button class="button is-full-width" slot="trigger">
                            <span class="has-margin-right-10">Select a Country</span>
                            <b-icon icon="menu-down" class="has-background-light has-text-white"></b-icon>
                          </button>

                          <b-dropdown-item aria-role="listitem">Action</b-dropdown-item>
                          <b-dropdown-item aria-role="listitem">Another action</b-dropdown-item>
                          <b-dropdown-item aria-role="listitem">Something else</b-dropdown-item>
                        </b-dropdown>
                      </b-field>
                      <b-field label="State">
                        <b-input placeholder="Enter State"></b-input>
                      </b-field>
                      <div class="columns">
                        <div class="column is-6">
                          <b-field label="City">
                            <b-input placeholder="Enter City"></b-input>
                          </b-field>
                        </div>
                        <div class="column is-6">
                          <b-field label="Zip Code">
                            <b-input placeholder="Enter Zip Code"></b-input>
                          </b-field>
                        </div>
                      </div>
                      <div class="field">
                        <b-checkbox> I agree to all the terms and conditions</b-checkbox>
                      </div>
                      <div class="buttons">
                        <b-button type="is-primary">Save</b-button>

                        <b-button type="is-light">Reset Fields</b-button>
                      </div>
                    </div>
                    <div class="column is-6">
                      <b-field label="Personal Details">
                        <b-input placeholder="Personal Details" disabled></b-input>
                      </b-field>
                      <b-field label="First Name">
                        <b-input placeholder="Enter First Name"></b-input>
                      </b-field>
                      <b-field label="Email Address">
                        <b-input placeholder="Enter Email Address"></b-input>
                      </b-field>
                      <b-field label="Gender">
                        <div class="block">
                          <b-radio name="name"
                                   native-value="Male">
                            Male
                          </b-radio>
                          <b-radio name="name"
                                   native-value="Female">
                            Female
                          </b-radio>
                        </div>
                      </b-field>
                      <b-field label="Photo"></b-field>
                      <b-field class="file" >
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
                      <b-field label="Something that describes you">
                        <b-input maxlength="200" type="textarea"></b-input>
                      </b-field>
                    </div>

                    <div class="column is-12">
                      <div class="form-table box has-margin-top-50">
                        <div class="content">
                          <h2 class="title is-bottom-marginless">Form Table Form</h2>
                          <p class="has-text-grey">A basic form control with disabled and readonly mode.</p>
                        </div>

                        <b-table
                          class="is-full-width"
                          :data="data"
                          :mobile-cards="true">

                          <template slot-scope="props">

                            <b-table-column field="product_name" class="has-width-250" label="Product Detail">
                              <b-field>
                                <b-input :value=props.row.product_name></b-input>
                              </b-field>
                            </b-table-column>

                            <b-table-column label="Quantity" class="has-width-100" centered>
                              <b-field>
                                <b-input placeholder="QTY"
                                         type="number"
                                         min="0">
                                </b-input>
                              </b-field>
                            </b-table-column>

                            <b-table-column label="Rate" class="has-width-100" centered>
                              <b-field>
                                <b-input placeholder="Rate"
                                         type="number"
                                         min="0">
                                </b-input>
                              </b-field>
                            </b-table-column>

                            <b-table-column label="Active" centered>
                              <div class="field">
                                <b-switch :value="true"
                                          type="is-success">
                                </b-switch>
                              </div>
                            </b-table-column>

                            <b-table-column label="Amount" class="has-width-100" centered>
                              <b-field>
                                <b-input placeholder="QTY"
                                         type="number"
                                         min="0">
                                </b-input>
                              </b-field>
                            </b-table-column>

                            <b-table-column label="Amount">
                              <span class="tag is-rounded">
                                <b-icon
                                  icon="plus"
                                  size="is-small">
                                </b-icon>
                              </span>
                              <span class="tag is-rounded">
                                <b-icon
                                  icon="close"
                                  size="is-small">
                                </b-icon>
                              </span>
                            </b-table-column>
                          </template>
                        </b-table>

                        <div class="content has-text-info has-margin-top-10">
                          <a class="has-text-info"><b-icon
                            icon="plus"
                            size="is-small">
                          </b-icon>Add another line</a>
                        </div>

                        <div class="columns">
                          <div class="column is-6">
                            <div class="content">
                              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi deleniti expedita facere labore praesentium rerum sint suscipit tempore! Corporis deleniti facere iste</p>
                            </div>
                          </div>
                          <div class="column is-6">
                            <div class="columns">
                              <div class="column is-6">
                                <div class="content">
                                  <p class="is-bottom-marginless">Sub-Total</p>
                                </div>
                              </div>
                              <div class="column is-6">
                                <div class="content has-text-right">
                                  <p class="is-bottom-marginless">$5,750.00</p>
                                </div>
                              </div>
                              <div class="column is-6">
                                <div class="content">
                                  <p class="is-bottom-marginless">GST(5%)</p>
                                </div>
                              </div>
                              <div class="column is-6">
                                <div class="content has-text-right">
                                  <p class="is-bottom-marginless">$287.00</p>
                                </div>
                              </div>
                              <div class="column is-6">
                                <div class="content">
                                  <p class="is-bottom-marginless">Discount</p>
                                </div>
                              </div>
                              <div class="column is-6">
                                <div class="content has-text-right">
                                  <p class="is-bottom-marginless">-$50.00</p>
                                </div>
                              </div>
                              <div class="column is-6">
                                <div class="content">
                                  <p class="is-bottom-marginless"><b>Total Due</b></p>
                                </div>
                              </div>
                              <div class="column is-6">
                                <div class="content has-text-right">
                                  <p class="is-bottom-marginless">-$5,987.50</p>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="column is-12">
                      <div class="paid-faster box has-margin-top-50 is-full-width">
                        <div class="content">
                          <h2 class="title is-bottom-marginless">Get Paid Faster</h2>
                          <p class="has-text-grey">Get paid online with a array of payment gateways.</p>
                        </div>
                        <div class="columns">
                          <div class="column is-3">
                            <div class="box">
                              <img src="https://via.placeholder.com/225x200">
                              <button class="button is-info is-full-width">Setup Now</button>
                            </div>
                          </div>
                          <div class="column is-3">
                            <div class="box">
                              <img src="https://via.placeholder.com/225x200">
                              <button class="button is-info is-full-width">Setup Now</button>
                            </div>
                          </div>
                          <div class="column is-3">
                            <div class="box">
                              <img src="https://via.placeholder.com/225x200">
                              <button class="button is-info is-full-width">Setup Now</button>
                            </div>
                          </div>
                          <div class="column is-3">
                            <div class="box">
                              <img src="https://via.placeholder.com/225x200">
                              <button class="button is-info is-full-width">Setup Now</button>
                            </div>
                          </div>
                          <div class="column is-3">
                            <div class="box">
                              <img src="https://via.placeholder.com/225x200">
                              <button class="button is-info is-full-width">Setup Now</button>
                            </div>
                          </div>
                          <div class="column is-3">
                            <div class="box">
                              <img src="https://via.placeholder.com/225x200">
                              <button class="button is-info is-full-width">Setup Now</button>
                            </div>
                          </div>
                          <div class="column is-3">
                            <div class="box">
                              <img src="https://via.placeholder.com/225x200">
                              <button class="button is-info is-full-width">Setup Now</button>
                            </div>
                          </div>
                          <div class="column is-3">
                            <div class="box">
                              <img src="https://via.placeholder.com/225x200">
                              <button class="button is-info is-full-width">Setup Now</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="column is-12">
                      <div class="paid-faster box has-margin-top-50 is-full-width">
                        <div class="content">
                          <h2 class="title is-bottom-marginless">Get Paid Faster</h2>
                          <p class="has-text-grey">Get paid online with a array of payment gateways.</p>
                        </div>
                        <div class="columns">
                          <div class="column is-3">
                            <div class="box">
                              <img src="https://via.placeholder.com/225x200">
                              <button class="button is-info is-full-width">Setup Now</button>
                            </div>
                          </div>
                          <div class="column is-3">
                            <div class="box">
                              <img src="https://via.placeholder.com/225x200">
                              <button class="button is-info is-full-width">Setup Now</button>
                            </div>
                          </div>
                          <div class="column is-3">
                            <div class="box">
                              <img src="https://via.placeholder.com/225x200">
                              <button class="button is-info is-full-width">Setup Now</button>
                            </div>
                          </div>
                          <div class="column is-3">
                            <div class="box">
                              <img src="https://via.placeholder.com/225x200">
                              <button class="button is-info is-full-width">Setup Now</button>
                            </div>
                          </div>
                          <div class="column is-3">
                            <div class="box">
                              <img src="https://via.placeholder.com/225x200">
                              <button class="button is-info is-full-width">Setup Now</button>
                            </div>
                          </div>
                          <div class="column is-3">
                            <div class="box">
                              <img src="https://via.placeholder.com/225x200">
                              <button class="button is-info is-full-width">Setup Now</button>
                            </div>
                          </div>
                          <div class="column is-3">
                            <div class="box">
                              <img src="https://via.placeholder.com/225x200">
                              <button class="button is-info is-full-width">Setup Now</button>
                            </div>
                          </div>
                          <div class="column is-3">
                            <div class="box">
                              <img src="https://via.placeholder.com/225x200">
                              <button class="button is-info is-full-width">Setup Now</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="column is-12">
                      <div class="paid-faster box has-margin-top-50 is-full-width">
                        <div class="content">
                          <h2 class="title is-bottom-marginless">Sales Order</h2>
                          <p class="has-text-grey">Sales order #132423</p>
                          <b-tag rounded class="has-background-warning has-text-white">CONFIRMED</b-tag>
                          <p class="has-margin-top-20"><b>Order Date</b> 20 Sept 2019</p>
                          <p class="has-margin-top-1 0"><b>GST Number</b> 111 21651 1564846584 5465</p>
                        </div>
                        <div class="columns">
                          <div class="column is-6">
                            <div class="content">
                              <h6>BILLING DETAILS</h6>
                              <h4>WebReinvent Tech. Pvt. Ltd.</h4>
                              <p class="is-bottom-marginless">201 Something St, Something Town, NY 6546</p>
                              <p class="is-bottom-marginless">Tel No: 324 445-4544</p>
                              <p class="is-bottom-marginless">Email: youremail@companyname.com</p>
                            </div>
                          </div>
                          <div class="column is-6">
                            <div class="content">
                              <h6>SHIPPING DETAILS</h6>
                              <h4>Juan Della Cruz</h4>
                              <p class="is-bottom-marginless">403 Patterson Road, Staten Island, NY 10301</p>
                              <p class="is-bottom-marginless">Tel No: 324 445-4544</p>
                              <p class="is-bottom-marginless">Email: youremail@companyname.com</p>
                            </div>
                          </div>
                        </div>

                        <b-table
                          class="is-full-width"
                          :data="dataStatus"
                          :mobile-cards="true">

                          <template slot-scope="props">

                            <b-table-column field="type" label="Type">
                              {{props.row.product_name}}
                            </b-table-column>

                            <b-table-column field="description" label="Description">
                              {{props.row.description}}
                            </b-table-column>

                            <b-table-column label="Qnty">
                              {{props.row.qnty}}
                            </b-table-column>

                            <b-table-column label="Unit Price">
                              {{props.row.unit_price}}
                            </b-table-column>

                            <b-table-column label="Amount" class="has-width-100">
                              {{props.row.amount}}
                            </b-table-column>
                          </template>
                        </b-table>

                      </div>
                    </div>

                    <div class="column is-8">
                      <div class="content">
                        <h6>Notes</h6>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium architecto commodi cum dolore, est facere laborum laudantium magnam maxime non nostrum provident quam quas rerum sed tempora tenetur vero voluptatem?</p>
                      </div>
                    </div>
                    <div class="column is-4">
                      <div class="text-bill">
                        <ul class="is-left-paddingless">
                          <li class="is-inline-block">
                            <div class="content">
                              <p>Sub-Total</p>
                            </div>
                          </li>
                          <li class="is-inline-block is-pulled-right">
                            <div class="content has-text-right">
                              <p>$5,750.00</p>
                            </div>
                          </li>
                        </ul>
                      </div>
                      <div class="text-bill">
                        <ul class="is-left-paddingless">
                          <li class="is-inline-block">
                            <div class="content">
                              <p>Tax(5%)</p>
                            </div>
                          </li>
                          <li class="is-inline-block is-pulled-right">
                            <div class="content has-text-right">
                              <p>$287.50</p>
                            </div>
                          </li>
                        </ul>
                      </div>
                      <div class="text-bill">
                        <ul class="is-left-paddingless">
                          <li class="is-inline-block">
                            <div class="content">
                              <p>Discount</p>
                            </div>
                          </li>
                          <li class="is-inline-block is-pulled-right">
                            <div class="content has-text-right">
                              <p>-$50.00</p>
                            </div>
                          </li>
                        </ul>
                      </div>
                      <div class="text-bill">
                        <ul class="is-left-paddingless">
                          <li class="is-inline-block">
                            <div class="content">
                              <p>Total</p>
                            </div>
                          </li>
                          <li class="is-inline-block is-pulled-right">
                            <div class="content has-text-right">
                              <p>$5,987.50</p>
                            </div>
                          </li>
                        </ul>
                      </div>
                      <div class="text-bill">
                        <ul class="is-left-paddingless">
                          <li class="is-inline-block">
                            <div class="content">
                              <p>Paid</p>
                            </div>
                          </li>
                          <li class="is-inline-block is-pulled-right">
                            <div class="content has-text-right">
                              <p>$2000.00</p>
                            </div>
                          </li>
                        </ul>
                      </div>
                      <div class="text-bill">
                        <ul class="is-left-paddingless">
                          <li class="is-inline-block">
                            <div class="content">
                              <p><b>Due Payment</b></p>
                            </div>
                          </li>
                          <li class="is-inline-block is-pulled-right">
                            <div class="content has-text-right">
                              <p><b>$3,987.00</b></p>
                            </div>
                          </li>
                        </ul>
                      </div>
                      <div class="text-bill">
                        <div class="columns">
                          <div class="column">

                          </div>
                        </div>
                        <div class="columns">
                          <div class="column is-6">
                            <div class="field">
                              <b-radio selected
                                       native-value="default">
                                Monthly Payment
                              </b-radio>
                            </div>
                          </div>
                          <div class="column is-6">
                            <b-field>
                              <b-input value="$1,000.00"></b-input>
                            </b-field>
                          </div>
                        </div>
                      </div>
                      <div class="text-bill">
                        <div class="columns">
                          <div class="column is-6">
                            <div class="field">
                              <b-radio
                                       native-value="default">
                                Full Payment
                              </b-radio>
                            </div>
                          </div>
                          <div class="column is-6">
                            <b-field>
                              <b-input value="$3,987.00" disabled></b-input>
                            </b-field>
                          </div>
                        </div>
                      </div>
                      <div class="text-bill">
                        <ul class="is-left-paddingless">
                          <li class="is-inline-block">
                            <div class="content">
                              <p><b>Payment Balance</b></p>
                            </div>
                          </li>
                          <li class="is-inline-block is-pulled-right">
                            <div class="content has-text-right">
                              <p><b>$2,987.00</b></p>
                            </div>
                          </li>
                        </ul>
                      </div>
                      <div class="field">
                        <b-radio native-value="default">
                          Credit Card
                        </b-radio>
                      </div>
                      <b-field label="Credit Card Number">
                        <b-input placeholder="Credit Card Number"></b-input>
                      </b-field>
                      <b-field label="Name on Card">
                        <b-input placeholder="Name on Card"></b-input>
                      </b-field>
                      <b-field label="Expiration Date">
                      </b-field>
                      <div class="columns">
                        <div class="column is-6">
                          <b-field>
                            <b-input placeholder="Month"></b-input>
                          </b-field>
                        </div>
                        <div class="column is-6">
                          <b-field>
                            <b-input placeholder="Year"></b-input>
                          </b-field>
                        </div>
                      </div>
                      <div class="columns">
                        <div class="column is-6">
                          <b-field label="Security Code">
                            <b-input placeholder="CVV"></b-input>
                          </b-field>
                        </div>
                        <div class="column is-6">
                          <b-field label="Contact">
                            <b-input placeholder="+91"></b-input>
                          </b-field>
                        </div>
                      </div>
                      <div class="field">
                        <b-radio native-value="default">
                          PayPal
                        </b-radio>
                      </div>
                      <b-button type="is-info">Pay Now</b-button>
                    </div>

                    <div class="column is-12">
                      <div class="box">
                        <div class="content">
                        <h6>Payment History</h6>
                      </div>
                      <b-table
                        class="is-full-width"
                        :data="dataPaymentHistory"
                        :mobile-cards="true">

                        <template slot-scope="props">

                          <b-table-column field="transaction_id" label="Transaction Id">
                            {{props.row.transaction_id}}
                          </b-table-column>

                          <b-table-column field="date" label="Date" class="has-width-100">
                            {{props.row.date}}
                          </b-table-column>

                          <b-table-column label="Payment Type">
                            {{props.row.payment_type}}
                          </b-table-column>

                          <b-table-column label="Payment Method">
                            {{props.row.payment_method}}
                          </b-table-column>

                          <b-table-column label="Amount" class="has-width-100">
                            {{props.row.amount}}
                          </b-table-column>

                          <b-table-column label="Balance" class="has-width-100">
                            {{props.row.balance}}
                          </b-table-column>

                          <b-table-column label="Status" class="has-width-100 has-text-danger">
                            {{props.row.status}}
                          </b-table-column>
                        </template>
                      </b-table>
                      </div>
                    </div>

                    <div class="column is-12">
                      <div class="box">
                        <div class="columns">
                          <div class="column is-6">
                            <div class="content">
                              <h3 class="is-bottom-marginless">Invoice #DAS2654DS64ASD4</h3>
                              <p>Due on April 21, 2020</p>
                            </div>
                          </div>
                          <div class="column is-6">
                            <div class="field has-addons is-pulled-right">
                              <p class="control">
                                <a class="button has-background-grey-lighter">
                                  <b-icon icon="download"></b-icon>
                                </a>
                              </p>
                              <p class="control has-width-100">
                                <a class="button has-background-grey-lighter">
                                  <b-icon icon="printer" class="has-margin-right-5"></b-icon> Print
                                </a>
                              </p>
                            </div>
                          </div>
                          <div class="column is-6">
                            <div class="content">
                              <h6>BILLED FROM</h6>
                              <h6>WebReinvent Technologies Pvt. Ltd.</h6>
                              <p class="is-bottom-marginless">201 Something State, Something Town, YT 242, Country 6546</p>
                              <p class="is-bottom-marginless">Tel No: 324 445-4544</p>
                              <p class="is-bottom-marginless">Email: youremail@companyname.com</p>
                            </div>
                            <div class="content has-margin-top-60">
                              <h6>BILLED TO</h6>
                              <h6>Juan Dela Cruz</h6>
                              <p class="is-bottom-marginless">201 Something State, Something Town, YT 242, Country 6546</p>
                              <p class="is-bottom-marginless">Tel No: 324 445-4544</p>
                              <p class="is-bottom-marginless">Email: youremail@companyname.com</p>
                            </div>
                          </div>
                          <div class="column is-6">
                            <div class="content has-text-right">
                              <h6 class="is-bottom-marginless">INVOICE NUMBER</h6>
                              <h1>#DAS2654DS64ASD4</h1>
                            </div>
                            <div class="content has-margin-top-100">
                              <h6 class="has-text-right">INVOICE INFORMATION</h6>
                              <div class="text">
                                <ul class="is-left-paddingless is-top-marginless is-left-marginless is-bottom-marginless">
                                  <li class="is-inline-block is-bottom-marginless"><b>Invoice Number</b></li>
                                  <li class="is-inline-block is-bottom-marginless has-text-right is-pulled-right">DAS2654DS64ASD4</li>
                                </ul>
                                <ul class="is-left-paddingless is-top-marginless is-left-marginless is-bottom-marginless">
                                  <li class="is-inline-block is-bottom-marginless"><b>Product</b></li>
                                  <li class="is-inline-block is-bottom-marginless has-text-right is-pulled-right">S64ASD4</li>
                                </ul>
                                <ul class="is-left-paddingless is-top-marginless is-left-marginless is-bottom-marginless">
                                  <li class="is-inline-block is-bottom-marginless"><b>Issue Date</b></li>
                                  <li class="is-inline-block is-bottom-marginless has-text-right is-pulled-right">16 Sept, 2019</li>
                                </ul>
                                <ul class="is-left-paddingless is-top-marginless is-left-marginless is-bottom-marginless">
                                  <li class="is-inline-block is-bottom-marginless"><b>Due Date</b></li>
                                  <li class="is-inline-block is-bottom-marginless has-text-right is-pulled-right">1 April, 2020</li>
                                </ul>
                                <ul class="is-left-paddingless is-top-marginless is-left-marginless is-bottom-marginless">
                                  <li class="is-inline-block is-bottom-marginless"><b>GST</b></li>
                                  <li class="is-inline-block is-bottom-marginless has-text-right is-pulled-right">#DAS2654DS64ASD4</li>
                                </ul>
                              </div>
                            </div>
                          </div>
                        </div>
                        <b-table
                          class="is-full-width"
                          :data="dataStatus"
                          :mobile-cards="true">

                          <template slot-scope="props">

                            <b-table-column field="type" label="Type">
                              {{props.row.product_name}}
                            </b-table-column>

                            <b-table-column field="description" label="Description">
                              {{props.row.description}}
                            </b-table-column>

                            <b-table-column label="Qnty">
                              {{props.row.qnty}}
                            </b-table-column>

                            <b-table-column label="Unit Price">
                              {{props.row.unit_price}}
                            </b-table-column>

                            <b-table-column label="Amount" class="has-width-100">
                              {{props.row.amount}}
                            </b-table-column>
                          </template>
                        </b-table>
                        <div class="columns">
                          <div class="column is-8">
                            <div class="content">
                              <h6>Notes</h6>
                              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium architecto commodi cum dolore, est facere laborum laudantium magnam maxime non nostrum provident quam quas rerum sed tempora tenetur vero voluptatem?</p>
                              <h6>T&C</h6>
                              <ul>
                                <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem, voluptatum.</li>
                                <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem, voluptatum.</li>
                                <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem, voluptatum.</li>
                                <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem, voluptatum.</li>
                                <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem, voluptatum.</li>
                              </ul>
                            </div>
                          </div>
                          <div class="column is-4">
                            <div class="text-bill">
                              <ul class="is-left-paddingless">
                                <li class="is-inline-block">
                                  <div class="content">
                                    <p>Sub-Total</p>
                                  </div>
                                </li>
                                <li class="is-inline-block is-pulled-right">
                                  <div class="content has-text-right">
                                    <p>$5,750.00</p>
                                  </div>
                                </li>
                              </ul>
                            </div>
                            <div class="text-bill">
                              <ul class="is-left-paddingless">
                                <li class="is-inline-block">
                                  <div class="content">
                                    <p>Tax(5%)</p>
                                  </div>
                                </li>
                                <li class="is-inline-block is-pulled-right">
                                  <div class="content has-text-right">
                                    <p>$287.50</p>
                                  </div>
                                </li>
                              </ul>
                            </div>
                            <div class="text-bill">
                              <ul class="is-left-paddingless">
                                <li class="is-inline-block">
                                  <div class="content">
                                    <p>Discount</p>
                                  </div>
                                </li>
                                <li class="is-inline-block is-pulled-right">
                                  <div class="content has-text-right">
                                    <p>-$50.00</p>
                                  </div>
                                </li>
                              </ul>
                            </div>
                            <div class="text-bill">
                              <ul class="is-left-paddingless">
                                <li class="is-inline-block">
                                  <div class="content">
                                    <p>Total</p>
                                  </div>
                                </li>
                                <li class="is-inline-block is-pulled-right">
                                  <div class="content has-text-right">
                                    <p>$5,987.50</p>
                                  </div>
                                </li>
                              </ul>
                            </div>
                            <div class="text-bill">
                              <ul class="is-left-paddingless">
                                <li class="is-inline-block">
                                  <div class="content">
                                    <p><b>Due Payment</b></p>
                                  </div>
                                </li>
                                <li class="is-inline-block is-pulled-right">
                                  <div class="content has-text-right">
                                    <p><b>$5,987.00</b></p>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="column is-12">
                      <div class="box">
                        <div class="columns">
                          <div class="column is-6">
                            <div class="content has-margin-top-60">
                              <h6>SHIPPING ADRESS</h6>
                              <h6>Juan Dela Cruz</h6>
                              <p class="is-bottom-marginless">201 Something State, Something Town, YT 242, Country 6546</p>
                              <p class="is-bottom-marginless">Tel No: 324 445-4544</p>
                              <p class="is-bottom-marginless">Email: youremail@companyname.com</p>
                            </div>
                          </div>
                          <div class="column is-6">
                            <div class="content has-text-right">
                              <div class="box has-background-light has-text-left">
                                <ul class="is-left-paddingless is-top-marginless is-left-marginless is-bottom-marginless">
                                  <li class="is-inline-block is-bottom-marginless"><b>Sales Order#</b></li>
                                  <li class="is-inline-block is-bottom-marginless has-text-right is-pulled-right">SO-126125</li>
                                </ul>
                                <ul class="is-left-paddingless is-top-marginless is-left-marginless is-bottom-marginless">
                                  <li class="is-inline-block is-bottom-marginless"><b>Order Date</b></li>
                                  <li class="is-inline-block is-bottom-marginless has-text-right is-pulled-right">16 Sept 2019</li>
                                </ul>
                              </div>
                              <div class="columns">
                                <div class="column is-6">
                                  <b>TRACKING #: 21232</b>
                                </div>
                                <div class="column is-6">
                                  <img src="/images/qrcode.png">
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <b-table
                          class="is-full-width"
                          :data="dataStatus"
                          :mobile-cards="true">

                          <template slot-scope="props">

                            <b-table-column field="type" label="Type">
                              {{props.row.product_name}}
                            </b-table-column>

                            <b-table-column label="Qnty">
                              {{props.row.qnty}}
                            </b-table-column>

                            <b-table-column label="Unit Price">
                              {{props.row.unit_price}}
                            </b-table-column>

                            <b-table-column label="Amount" class="has-width-100">
                              {{props.row.amount}}
                            </b-table-column>
                          </template>
                        </b-table>
                        <div class="columns">
                          <div class="column is-6">
                            <div class="content">
                              <div class="content has-margin-top-60">
                                <h6>SOLD BY</h6>
                                <h6>Juan Dela Cruz</h6>
                                <p class="is-bottom-marginless">201 Something State, Something Town, YT 242, Country 6546</p>
                                <p class="is-bottom-marginless">Tel No: 324 445-4544</p>
                                <p class="is-bottom-marginless">Email: youremail@companyname.com</p>
                              </div>
                            </div>
                          </div>
                          <div class="column is-6">
                            <div class="content has-text-right has-margin-top-60">
                              <h6>TRACKING #:651461876531614</h6>
                              <img src="/images/barcode.png">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </b-tab-item>
                <b-tab-item label="Tab #2">
                </b-tab-item>
                <b-tab-item label="Tab #3">
                </b-tab-item>
                <b-tab-item label="Tab #4">
                </b-tab-item>
              </b-tabs>
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
    data() {
      return {
        file: null,
        data : [
          { 'product_name': 'Lorem ipsum dolor.', 'price' : '$450/Kg', 'amount': '$520.00' },
          { 'product_name': 'Lorem ipsum dolor.', 'price' : '$450/Kg', 'amount': '$520.00' },
          { 'product_name': 'Lorem ipsum dolor.', 'price' : '$450/Kg', 'amount': '$520.00' },
          { 'product_name': 'Lorem ipsum dolor.', 'price' : '$450/Kg', 'amount': '$520.00' },
          { 'product_name': 'Lorem ipsum dolor.', 'price' : '$450/Kg', 'amount': '$520.00' },
          { 'product_name': 'Lorem ipsum dolor.', 'price' : '$450/Kg', 'amount': '$520.00' },
          { 'product_name': 'Lorem ipsum dolor.', 'price' : '$450/Kg', 'amount': '$520.00' },
          { 'product_name': 'Lorem ipsum dolor.', 'price' : '$450/Kg', 'amount': '$520.00' },
          { 'product_name': 'Lorem ipsum dolor.', 'price' : '$450/Kg', 'amount': '$520.00' },
          { 'product_name': 'Lorem ipsum dolor.', 'price' : '$450/Kg', 'amount': '$520.00' },
          { 'product_name': 'Lorem ipsum dolor.', 'price' : '$450/Kg', 'amount': '$520.00' },
          { 'product_name': 'Lorem ipsum dolor.', 'price' : '$450/Kg', 'amount': '$520.00' },
          { 'product_name': 'Lorem ipsum dolor.', 'price' : '$450/Kg', 'amount': '$520.00' }
        ],
        dataStatus : [
          { 'product_name': 'Website Design', 'description':'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex, officia?' ,'qnty' :'2' ,'unit_price' : '$520.00', 'amount': '$520.00' },
          { 'product_name': 'Website Design', 'description':'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex, officia?' ,'qnty' :'2' ,'unit_price' : '$520.00', 'amount': '$520.00' },
          { 'product_name': 'Website Design', 'description':'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex, officia?' ,'qnty' :'2' ,'unit_price' : '$520.00', 'amount': '$520.00' },
          { 'product_name': 'Website Design', 'description':'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex, officia?' ,'qnty' :'2' ,'unit_price' : '$520.00', 'amount': '$520.00' },
          { 'product_name': 'Website Design', 'description':'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex, officia?' ,'qnty' :'2' ,'unit_price' : '$520.00', 'amount': '$520.00' },
          { 'product_name': 'Website Design', 'description':'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex, officia?' ,'qnty' :'2' ,'unit_price' : '$520.00', 'amount': '$520.00' },
        ],
        dataPaymentHistory : [
          { 'transaction_id': '#16545249625426', 'date' :'16 sept, 2019', 'payment_type':'partial' ,'payment_method' :'Credit Card' ,'amount' : '$520.00', 'balance': '$520.00', 'status' :'Failed' },
          { 'transaction_id': '#16545249625426', 'date' :'16 sept, 2019', 'payment_type':'partial' ,'payment_method' :'Credit Card' ,'amount' : '$520.00', 'balance': '$520.00', 'status' :'Failed' },
          { 'transaction_id': '#16545249625426', 'date' :'16 sept, 2019', 'payment_type':'partial' ,'payment_method' :'Credit Card' ,'amount' : '$520.00', 'balance': '$520.00', 'status' :'Failed' },
          { 'transaction_id': '#16545249625426', 'date' :'16 sept, 2019', 'payment_type':'partial' ,'payment_method' :'Credit Card' ,'amount' : '$520.00', 'balance': '$520.00', 'status' :'Failed' },
          { 'transaction_id': '#16545249625426', 'date' :'16 sept, 2019', 'payment_type':'partial' ,'payment_method' :'Credit Card' ,'amount' : '$520.00', 'balance': '$520.00', 'status' :'Failed' },
          { 'transaction_id': '#16545249625426', 'date' :'16 sept, 2019', 'payment_type':'partial' ,'payment_method' :'Credit Card' ,'amount' : '$520.00', 'balance': '$520.00', 'status' :'Failed' },
        ]
      }
    }
  }
</script>


