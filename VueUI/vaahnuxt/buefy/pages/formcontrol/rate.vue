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

          <SectionTitle title="Buefy - Rate"
                        link="https://buefy.org/documentation/rate/">
          </SectionTitle>


          <SectionCode name="Rate" :code="RateCode">
            <Rate></Rate>
          </SectionCode>


          <SectionCode name="Custom Rate" :code="CustomRateCode">
            <CustomRate></CustomRate>
          </SectionCode>


        </div>

      </div>
    </section>

  </div>




  <Footer></Footer>


  </div>

</template>

<script src="./ratejs.js"></script>
