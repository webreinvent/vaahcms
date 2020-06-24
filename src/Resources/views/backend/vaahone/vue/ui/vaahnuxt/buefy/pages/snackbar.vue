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

          <SectionTitle title="Buefy - Snackbar"
                        link="https://buefy.org/documentation/snackbar">
          </SectionTitle>


          <SectionCode name="Snackbar" :code="SnackbarCode">
            <Snackbar></Snackbar>
          </SectionCode>


        </div>

      </div>
    </section>

  </div>




  <Footer></Footer>


  </div>

</template>

<script src="./snackbarjs.js"></script>
