<template>
  <div>
    <div class="control">
      <label class="radio">
        <input type="radio" name="answer">
        Yes
      </label>
      <label class="radio">
        <input type="radio" name="answer">
        No
      </label>
    </div>

    <div class="control">
      <label class="radio">
        <input type="radio" name="foobar">
        Foo
      </label>
      <label class="radio">
        <input type="radio" name="foobar" checked>
        Bar
      </label>
    </div>

    <div class="control">
      <label class="radio">
        <input type="radio" name="rsvp">
        Going
      </label>
      <label class="radio">
        <input type="radio" name="rsvp">
        Not going
      </label>
      <label class="radio" disabled>
        <input type="radio" name="rsvp" disabled>
        Maybe
      </label>
    </div>
  </div>
</template>
