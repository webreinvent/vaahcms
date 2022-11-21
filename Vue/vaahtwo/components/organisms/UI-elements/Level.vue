<template>
<div class="grid">

  <!-----Level with left and right items Start----->
  <div class="col-12 mb-5">
    <h6 class="mb-4">Level with left and right items</h6>
    <nav class="level">
      <div class="level-left">
        <div class="level-item">
          <div class="p-inputgroup">
            <InputText placeholder="Enter Search Terms"/>
            <Button icon="pi pi-search" label="Search" class="p-button-primary"/>
          </div>
        </div>
      </div>

      <div class="level-right">
        <p class="level-item"><strong>All</strong></p>
        <p class="level-item"><a>Published</a></p>
        <p class="level-item"><a>Drafts</a></p>
        <p class="level-item"><a>Deleted</a></p>
        <p class="level-item"><Button label="New" class="p-button-sm p-button-success"></Button></p>
      </div>
    </nav>
  </div>
  <!-----Level with left and right items End ----->

  <!-----Level with centered items Start----->
  <div class="col-12 mb-5">
    <h6 class="mb-4">Level with centered items</h6>
    <nav class="level">
      <div class="level-item text-center">
        <div>
          <h4>Tweets</h4>
          <p class="text-lg">3,456</p>
        </div>
      </div>
      <div class="level-item text-center">
        <div>
          <h4>Following</h4>
          <p class="text-lg">123</p>
        </div>
      </div>
      <div class="level-item text-center">
        <div>
          <h4>Followers</h4>
          <p class="text-lg">456K</p>
        </div>
      </div>
      <div class="level-item text-center">
        <div>
          <h4>Likes</h4>
          <p class="text-lg">789</p>
        </div>
      </div>
    </nav>
  </div>
  <!-----Level with centered items End----->

  <!-----Level with left,right and centered items Start----->
  <div class="col-12">
    <h6 class="mb-4">Level with left,right and centered items</h6>
    <nav class="level">
      <div class="level-left">
        <p class="level-item text-center">
          <a class="text-blue-500">Home</a>
        </p>
        <p class="level-item text-center">
          <a class="text-blue-500">Menu</a>
        </p>
      </div>
      <p class="level-item text-center text-3xl font-bold text-blue-700">
        WebReinvent
      </p>
      <div class="level-right">
        <p class="level-item text-center">
          <a class="text-blue-500">Reservations</a>
        </p>
        <p class="level-item text-center">
          <a class="text-blue-500">Contact</a>
        </p>
      </div>
    </nav>
  </div>
  <!-----Level with left,right and centered items Start----->

</div>
</template>

<script>
export default {
  name: "Level"
}
</script>

<style scoped>

</style>