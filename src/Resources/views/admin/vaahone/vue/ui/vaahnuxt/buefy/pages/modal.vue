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

            <SectionTitle title="Buefy - Modal"
                          link="https://buefy.org/documentation/modal">
            </SectionTitle>


            <SectionCode name="Modal" :code="ModalCode">
              <Modal></Modal>
            </SectionCode>


            <SectionCode name="Component" :code="ComponentModalCode">
              <ComponentModal></ComponentModal>
            </SectionCode>


            <SectionCode name="Programmatic" :code="ProgrammaticCode">
              <Programmatic></Programmatic>
            </SectionCode>


            <SectionCode name="Full Screen" :code="FullScreenCode">
              <FullScreen></FullScreen>
            </SectionCode>


          </div>

      </div>
    </section>

  </div>




  <Footer></Footer>


  </div>


</template>

<script src="./modaljs.js"></script>
