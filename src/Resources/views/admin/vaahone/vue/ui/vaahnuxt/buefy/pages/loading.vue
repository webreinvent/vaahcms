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

            <SectionTitle title="Buefy - Loading"
                              link="https://buefy.org/documentation/loading/">
            </SectionTitle>


            <SectionCode name="Loading" :code="LoadingCode">
              <Loading></Loading>
            </SectionCode>


            <SectionCode name="Programmatically Opening" :code="ProgrammaticallyOpeningCode">
              <ProgrammaticallyOpening></ProgrammaticallyOpening>
            </SectionCode>


            <SectionCode name="Templated" :code="TemplatedCode">
              <Templated></Templated>
            </SectionCode>


          </div>

      </div>
    </section>

  </div>




  <Footer></Footer>


  </div>

</template>

<script src="./loadingjs.js"></script>
