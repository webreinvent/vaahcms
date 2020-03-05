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

          <SectionTitle title="Buefy - navbar"
                        link="https://bulma.io/documentation/components/navbar/">
          </SectionTitle>


          <SectionCode name="Navbar">
            <b-notification
              type="is-warning"
              aria-close-label="Close notification"
              role="alert">
              Need to use navbar from the Bulma.
            </b-notification>
          </SectionCode>


        </div>

      </div>
    </section>

  </div>




  <Footer></Footer>


  </div>


</template>

<script src="./navbarjs.js"></script>
