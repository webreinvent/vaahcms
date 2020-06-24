<template>
  <div class="login-form-layout has-background-light">
    <div class="container is-fullhd has-padding-left-20 has-padding-right-20">
      <div class="columns">
        <div class="column is-4">
          <div class="box">
            <div class="heading content is-capitalized">
              <h2 class="title">Basket</h2>
            </div>
            <b-table
              :data="data"
              :mobile-cards="true">

              <template slot-scope="props">

                <b-table-column field="product_name" label="Product">
                  <div class="content">
                    <h6 class="title is-bottom-marginless"><b>{{ props.row.product_name }}</b></h6>
                    <span class="has-text-grey">{{ props.row.price }}</span>
                  </div>
                </b-table-column>

                <b-table-column label="QNTY" centered>
                  <div class="field has-addons has-width-100">
                    <p class="control">
                    <a class="button">+
                    </a>
                    </p>
                    <p class="control">
                      <input class="input" type="number" placeholder="0">
                    </p>
                    <p class="control">
                      <a class="button">-
                    </a>
                    </p>
                  </div>
                </b-table-column>

                <b-table-column label="Amount">
                  <span>
                      {{ props.row.amount }}
                    <span class="tag is-rounded is-delete"></span>
                  </span>
                </b-table-column>
              </template>
            </b-table>
          </div>
          <div class="box has-margin-top-20">
            <b-field class="has-background-light">
              <b-input placeholder="Search by Name" class="has-background-light"></b-input>
            </b-field>
            <div class="content">
              <p class="has-text-centered">
                Or
              </p>
            </div>
            <div class="field has-addons">
              <div class="control is-full-width">
                <input class="input" type="text" placeholder="Enter Customers Name">
              </div>
              <div class="control">
                <a class="button is-info">
                  +
                </a>
              </div>
            </div>
            <article class="media">
              <figure class="media-left">
                <p class="image is-64x64">
                  <img src="https://bulma.io/images/placeholders/128x128.png">
                </p>
              </figure>
              <div class="media-content">
                <div class="content">
                  <p>
                    <strong>Customer's Name</strong>
                    <br>
                    Last Order: 15 Sept, 2019
                  </p>
                </div>
              </div>
              <div class="media-right">
                <button class="delete"></button>
              </div>
            </article>
          </div>
          <div class="box">
            <div class="heading content is-capitalized">
              <h2 class="title">Payment</h2>
            </div>
            <div class="text">
              <div class="columns is-flex-mobile">
                <div class="column is-6-desktop is-6-mobile">
                  <p>Total Products</p>
                </div>
                <div class="column is-6-desktop is-6-mobile has-text-right">
                  <p class="has-text-right">10</p>
                </div>
                <div class="column is-6-desktop is-6-mobile">
                  <p>Total Amount</p>
                </div>
                <div class="column is-6-desktop is-6-mobile has-text-right">
                  <p class="has-text-right">$2,275.00</p>
                </div>
                <div class="column is-12-desktop is-12-mobile">
                  <div class="field">
                    <b-radio
                             native-value="default">
                      Credit Card
                    </b-radio>
                  </div>
                  <div class="field">
                    <b-radio
                             native-value="default">
                      Cash Payment
                    </b-radio>
                  </div>
                  <button class="button is-info">Make Payment</button>
                </div>

                <div class="column is-6-desktop is-6-mobile">
                  <p><b>Payable Amount</b></p>
                </div>
                <div class="column is-6-desktop is-6-mobile has-text-right">
                  <p class="has-text-right"><b>$2,275.00</b></p>
                </div>
                <div class="column is-6-desktop is-6-mobile">
                  <p>Collected Amount</p>
                </div>
                <div class="column is-6-desktop is-6-mobile has-text-right">
                  <b-field label="">
                    <b-input placeholder="$2,254.00"></b-input>
                  </b-field>
                </div>
                <div class="column is-6-desktop is-6-mobile">
                  <p>Returning Amount</p>
                </div>
                <div class="column is-6-desktop is-6-mobile has-text-right">
                  <p class="has-text-right"><b>$275.00</b></p>
                </div>
                <div class="column is-12-desktop is-12-mobile">
                  <button class="button is-success is-full-width">Mark this order as complete</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="column is-8">
          <div class="box has-background-light">
            <b-tabs>
              <b-tab-item label="Customer 1">

                <div class="sorting">
                  <div class="columns is-flex-mobile">
                    <div class="column is-7">
                      <b-field>
                        <b-input placeholder="Search..."
                                 type="search"
                                 icon="magnify">
                        </b-input>
                      </b-field>
                    </div>
                    <div class="column is-5">
                      <b-dropdown aria-role="list" class="is-pulled-right">
                        <button class="button is-full-width" slot="trigger">
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
                </div>

                <div class="items">
                  <div class="columns wrap">
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="columns">
                    <div class="column">
                      <b-pagination
                        total="200"
                        range-before="3"
                        range-after="1"
                        order="default"
                        size="default"
                        per-page="10"
                        aria-next-label="Next page"
                        aria-previous-label="Previous page"
                        aria-page-label="Page"
                        aria-current-label="Current page">
                      </b-pagination>
                    </div>
                  </div>
                </div>

              </b-tab-item>

              <b-tab-item label="Customer 2">

                <div class="sorting">
                  <div class="columns is-flex-mobile">
                    <div class="column is-7">
                      <b-field>
                        <b-input placeholder="Search..."
                                 type="search"
                                 icon="magnify">
                        </b-input>
                      </b-field>
                    </div>
                    <div class="column is-5">
                      <b-dropdown aria-role="list" class="is-pulled-right">
                        <button class="button is-full-width" slot="trigger">
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
                </div>

                <div class="items">
                  <div class="columns wrap">
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="columns">
                    <div class="column">
                      <b-pagination
                        total="200"
                        range-before="3"
                        range-after="1"
                        order="default"
                        size="default"
                        per-page="10"
                        aria-next-label="Next page"
                        aria-previous-label="Previous page"
                        aria-page-label="Page"
                        aria-current-label="Current page">
                      </b-pagination>
                    </div>
                  </div>
                </div>

              </b-tab-item>

              <b-tab-item label="Customer 3">

                <div class="sorting">
                  <div class="columns is-flex-mobile">
                    <div class="column is-7">
                      <b-field>
                        <b-input placeholder="Search..."
                                 type="search"
                                 icon="magnify">
                        </b-input>
                      </b-field>
                    </div>
                    <div class="column is-5">
                      <b-dropdown aria-role="list" class="is-pulled-right">
                        <button class="button is-full-width" slot="trigger">
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
                </div>

                <div class="items">
                  <div class="columns wrap">
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="columns">
                    <div class="column">
                      <b-pagination
                        total="200"
                        range-before="3"
                        range-after="1"
                        order="default"
                        size="default"
                        per-page="10"
                        aria-next-label="Next page"
                        aria-previous-label="Previous page"
                        aria-page-label="Page"
                        aria-current-label="Current page">
                      </b-pagination>
                    </div>
                  </div>
                </div>

              </b-tab-item>

              <b-tab-item label="Customer 4">

                <div class="sorting">
                  <div class="columns is-flex-mobile">
                    <div class="column is-7">
                      <b-field>
                        <b-input placeholder="Search..."
                                 type="search"
                                 icon="magnify">
                        </b-input>
                      </b-field>
                    </div>
                    <div class="column is-5">
                      <b-dropdown aria-role="list" class="is-pulled-right">
                        <button class="button is-full-width" slot="trigger">
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
                </div>

                <div class="items">
                  <div class="columns wrap">
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column is-3">
                      <div class="box item">
                        <img src="https://via.placeholder.com/175x100">
                        <div class="text has-text-centered has-margin-top-5">
                          <div class="content">
                            <p class="is-bottom-marginless">Lorem ipsum dolor.</p>
                            <a href="#">$445/Kg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="columns">
                    <div class="column">
                      <b-pagination
                        total="200"
                        range-before="3"
                        range-after="1"
                        order="default"
                        size="default"
                        per-page="10"
                        aria-next-label="Next page"
                        aria-previous-label="Previous page"
                        aria-page-label="Page"
                        aria-current-label="Current page">
                      </b-pagination>
                    </div>
                  </div>
                </div>

              </b-tab-item>
            </b-tabs>
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
        data : [
          { 'product_name': 'Lorem ipsum dolor.', 'price' : '$450/Kg', 'amount': '$520.00' },
          { 'product_name': 'Lorem ipsum dolor.', 'price' : '$450/Kg', 'amount': '$520.00' },
          { 'product_name': 'Lorem ipsum dolor.', 'price' : '$450/Kg', 'amount': '$520.00' },
          { 'product_name': 'Lorem ipsum dolor.', 'price' : '$450/Kg', 'amount': '$520.00' },
          { 'product_name': 'Lorem ipsum dolor.', 'price' : '$450/Kg', 'amount': '$520.00' }
        ]
      }
    }
  }
</script>


