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

            <SectionTitle title="Buefy - Upload"
                          link="https://buefy.org/documentation/upload/">
            </SectionTitle>


            <SectionCode name="Upload" :code="UploadCode">
              <Upload></Upload>
            </SectionCode>


            <SectionCode name="Drag And Drop" :code="DragAndDropCode">
              <DragAndDrop></DragAndDrop>
            </SectionCode>


          </div>

      </div>
    </section>

  </div>




  <Footer></Footer>


  </div>

</template>

<script src="./uploadjs.js"></script>
