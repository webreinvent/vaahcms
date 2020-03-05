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

          <SectionTitle title="Buefy - Checkbox"
                        link="https://buefy.org/documentation/checkbox/">
          </SectionTitle>


          <SectionCode name="Checkbox" :code="CheckboxCode">
            <Checkbox></Checkbox>
          </SectionCode>


          <SectionCode name="Grouped (Array)" :code="GroupedCode">
            <Grouped></Grouped>
          </SectionCode>


          <SectionCode name="Sizes" :code="SizesCode">
            <Sizes></Sizes>
          </SectionCode>


          <SectionCode name="Types" :code="TypesCode">
            <Types></Types>
          </SectionCode>


          <SectionCode name="Checkbox Button" :code="CheckboxButtonCode">
            <CheckboxButton></CheckboxButton>
          </SectionCode>


        </div>

      </div>
    </section>

  </div>




  <Footer></Footer>


  </div>

</template>

<script src="./checkboxjs.js"></script>
