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

            <SectionTitle title="Buefy - Message"
                          link="https://bulma.io/documentation/components/message/">
            </SectionTitle>


            <SectionCode name="Message" :code="MessageCode">
              <Message></Message>
            </SectionCode>


            <SectionCode name="Types" :code="TypesCode">
              <Types></Types>
            </SectionCode>


            <SectionCode name="Icons" :code="IconsCode">
              <Icons></Icons>
            </SectionCode>


            <SectionCode name="Headerless" :code="HeaderlessCode">
              <Headerless></Headerless>
            </SectionCode>


            <SectionCode name="Sizes" :code="SizesCode">
              <Sizes></Sizes>
            </SectionCode>


            <SectionCode name="Auto Close" :code="AutoCloseCode">
              <AutoClose></AutoClose>
            </SectionCode>


          </div>

      </div>
    </section>

  </div>




  <Footer></Footer>


  </div>


</template>

<script src="./messagejs.js"></script>
