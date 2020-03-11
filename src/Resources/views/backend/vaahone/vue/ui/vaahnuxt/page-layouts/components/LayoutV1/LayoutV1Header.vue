<template>
  <div class="LayoutV1">

  <!--    HEADER STARTS-->
    <div class="header">
      <div class="container is-fullhd">
        <div class="columns">
          <div class="column is-12">
            <nav class="navbar" role="navigation" aria-label="main navigation">
              <div class="navbar-brand">
                <a class="navbar-item" href="https://bulma.io">
                  <img src="https://bulma.io/images/bulma-logo.png" width="112" height="28">
                </a>

                <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
                  <span aria-hidden="true"></span>
                  <span aria-hidden="true"></span>
                  <span aria-hidden="true"></span>
                </a>
              </div>

              <div id="navbarBasicExample" class="navbar-menu">
                <div class="navbar-start is-small">

                  <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link">
                      Projects
                    </a>

                    <div class="navbar-dropdown">
                      <a class="navbar-item">
                        Dropdown Item 1
                      </a>
                      <a class="navbar-item">
                        Dropdown Item 2
                      </a>
                      <a class="navbar-item">
                        Dropdown Item 3
                      </a>
                      <hr class="navbar-divider">
                      <a class="navbar-item">
                        Dropdown Item 4
                      </a>
                    </div>
                  </div>

                  <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link">
                      Groups
                    </a>

                    <div class="navbar-dropdown">
                      <a class="navbar-item">
                        Dropdown Item 1
                      </a>
                      <a class="navbar-item">
                        Dropdown Item 2
                      </a>
                      <a class="navbar-item">
                        Dropdown Item 3
                      </a>
                      <hr class="navbar-divider">
                      <a class="navbar-item">
                        Dropdown Item 4
                      </a>
                    </div>
                  </div>

                  <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link">
                      More
                    </a>

                    <div class="navbar-dropdown">
                      <a class="navbar-item">
                        Dropdown Item 1
                      </a>
                      <a class="navbar-item">
                        Dropdown Item 2
                      </a>
                      <a class="navbar-item">
                        Dropdown Item 3
                      </a>
                      <hr class="navbar-divider">
                      <a class="navbar-item">
                        Dropdown Item 4
                      </a>
                    </div>
                  </div>

                  <a class="navbar-item">
                    <b-tooltip label="Analytics"
                               position="is-bottom">
                      <b-icon
                        icon="google-analytics"
                        size="is-small">
                      </b-icon>
                    </b-tooltip>

                  </a>

                </div>
                <div class="navbar-end">

                  <a class="navbar-item">
                    <b-tooltip label="New"
                               position="is-bottom">
                      <b-icon
                        icon="plus-box"
                        size="is-small">
                      </b-icon>
                    </b-tooltip>
                  </a>

                  <div class="field navbar-item">
                    <p class="control has-icons-left has-icons-right">
                      <input class="input" type="email" placeholder="Search a Repository">
                    </p>
                  </div>

                  <a class="navbar-item">
                    <b-tooltip label="Issues"
                               position="is-bottom">
                      <b-icon
                        icon="alert-circle-outline"
                        size="is-small">
                      </b-icon>
                    </b-tooltip>
                  </a>

                  <a class="navbar-item">
                    <b-tooltip label="Merge Requests"
                               position="is-bottom">
                      <b-icon
                        icon="view-dashboard"
                        size="is-small">
                      </b-icon>
                    </b-tooltip>
                  </a>

                  <a class="navbar-item">
                    <b-tooltip label="To-Do List"
                               position="is-bottom">
                      <b-icon
                        icon="account"
                        size="is-small">
                      </b-icon>
                    </b-tooltip>
                  </a>

                  <div class="navbar-item has-dropdown is-right is-hoverable">
                    <a class="navbar-link">
                      <b-icon
                        icon="help"
                        size="is-small">
                      </b-icon>
                    </a>

                    <div class="navbar-dropdown is-right">
                      <a class="navbar-item">
                        Dropdown Item 1
                      </a>
                      <a class="navbar-item">
                        Dropdown Item 2
                      </a>
                      <a class="navbar-item">
                        Dropdown Item 3
                      </a>
                      <hr class="navbar-divider">
                      <a class="navbar-item">
                        Dropdown Item 4
                      </a>
                    </div>
                  </div>

                  <div class="navbar-item has-dropdown is-right is-hoverable">
                    <a class="navbar-link">
                      <img src="https://via.placeholder.com/20x20">
                    </a>

                    <div class="navbar-dropdown is-right">
                      <a class="navbar-item">
                        Dropdown Item 1
                      </a>
                      <a class="navbar-item">
                        Dropdown Item 2
                      </a>
                      <a class="navbar-item">
                        Dropdown Item 3
                      </a>
                      <hr class="navbar-divider">
                      <a class="navbar-item">
                        Dropdown Item 4
                      </a>
                    </div>
                  </div>

                </div>
              </div>
            </nav>
          </div>
        </div>
      </div>
    </div>

  <!--    HEADER ENDS-->

  </div>
</template>

<script>


  export default {
    props: ['content']
  }
</script>


