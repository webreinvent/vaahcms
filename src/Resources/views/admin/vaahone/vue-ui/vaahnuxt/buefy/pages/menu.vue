<template>

  <div>

  <TopMenu></TopMenu>
  <PageHeader></PageHeader>
  <div class="container" >

    <section class="main-content columns">
      <aside class="column is-2 section">
        <SideMenu></SideMenu>
      </aside>

      <div class="container column is-10">

          <div class="main-content">

            <SectionTitle title="Buefy - Menu"
                          link="https://bulma.io/documentation/components/menu/">
            </SectionTitle>


            <SectionCode name="Menu" :code="MenuCode">
              <b-notification
                type="is-warning"
                aria-close-label="Close notification"
                role="alert">
                Need to use menu from the Bulma.
              </b-notification>
            </SectionCode>


          </div>

      </div>
    </section>

  </div>




  <Footer></Footer>


  </div>



</template>

<script src="./menujs.js"></script>
