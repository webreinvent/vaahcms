<template>
<div class="grid">

  <!-----Level with left and right items Start----->
  <div class="col-12 mb-5">
    <h6 class="mb-4">Level with left and right items</h6>
    <nav class="level">
      <div class="level-left">
        <div class="level-item">
          <InputGroup>
            <InputText placeholder="Enter Search Terms"/>
            <!-- M7-T4 — `p-button-primary` has zero rules in the v4 CSS and the default
             Button is already primary (css-class-migration-table.md), so the
             dead class is dropped with no prop — the tint is unchanged. -->
          <Button icon="pi pi-search" label="Search"/>
          </InputGroup>
        </div>
      </div>

      <div class="level-right">
        <p class="level-item"><strong>All</strong></p>
        <p class="level-item"><a>Published</a></p>
        <p class="level-item"><a>Drafts</a></p>
        <p class="level-item"><a>Deleted</a></p>
        <p class="level-item"><Button size="small" label="New" class=" p-button-success"></Button></p>
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
          <p class="vc-text-16">3,456</p>
        </div>
      </div>
      <div class="level-item text-center">
        <div>
          <h4>Following</h4>
          <p class="vc-text-16">123</p>
        </div>
      </div>
      <div class="level-item text-center">
        <div>
          <h4>Followers</h4>
          <p class="vc-text-16">456K</p>
        </div>
      </div>
      <div class="level-item text-center">
        <div>
          <h4>Likes</h4>
          <p class="vc-text-16">789</p>
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
          <a class="vc-link">Home</a>
        </p>
        <p class="level-item text-center">
          <a class="vc-link">Menu</a>
        </p>
      </div>
      <p class="level-item text-center vc-text-24 font-semibold vc-accent">
        WebReinvent
      </p>
      <div class="level-right">
        <p class="level-item text-center">
          <a class="vc-link">Reservations</a>
        </p>
        <p class="level-item text-center">
          <a class="vc-link">Contact</a>
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