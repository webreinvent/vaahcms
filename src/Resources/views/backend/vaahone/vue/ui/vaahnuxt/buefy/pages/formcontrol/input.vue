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

          <SectionTitle title="Buefy - Input"
                        link="https://buefy.org/documentation/input/">
          </SectionTitle>


          <SectionCode name="Input" :code="InputCode">
            <Input></Input>
          </SectionCode>


          <SectionCode name="Types And States" :code="TypesAndStatesCode">
            <TypesAndStates></TypesAndStates>
          </SectionCode>


          <SectionCode name="Icons" :code="IconsCode">
            <Icons></Icons>
          </SectionCode>


          <SectionCode name="Validation" :code="ValidationCode">
            <Validation></Validation>
          </SectionCode>


          <SectionCode name="Password" :code="PasswordCode">
            <Password></Password>
          </SectionCode>


          <SectionCode name="Sizes" :code="SizesCode">
            <Sizes></Sizes>
          </SectionCode>


        </div>

      </div>
    </section>

  </div>




  <Footer></Footer>


  </div>

</template>

<script src="./inputjs.js"></script>
