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

          <SectionTitle title="Buefy - Radio"
                        link="https://buefy.org/documentation/radio/">
          </SectionTitle>


          <SectionCode name="Radio" :code="RadioCode">
            <Radio></Radio>
          </SectionCode>


          <SectionCode name="Sizes" :code="SizesCode">
            <Sizes></Sizes>
          </SectionCode>


          <SectionCode name="Types" :code="TypesCode">
            <Types></Types>
          </SectionCode>


          <SectionCode name="Radio Button" :code="RadioButtonCode">
            <RadioButton></RadioButton>
          </SectionCode>


        </div>

      </div>
    </section>

  </div>




  <Footer></Footer>


  </div>

</template>

<script src="./radiojs.js"></script>
