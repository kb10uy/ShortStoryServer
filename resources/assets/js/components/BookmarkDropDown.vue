<template>
<div>
  <button class="button primary" type="button" data-toggle="dd-bookmark">{{ tl_bookmark }}</button>
  <div class="dropdown-pane" id="dd-bookmark" data-dropdown data-auto-focus="true">
    <form role="form" method="POST" id="post-control">
      {{ csrf_field() }}
      <div class="row">
        <div class="small-12 coluimns">
          <label>
            {{ tl_bookmark_dest }}
            <select>
              <option value="husker">Husker</option>
              <option value="starbuck">Starbuck</option>
              <option value="hotdog">Hot Dog</option>
              <option value="apollo">Apollo</option>
            </select>
          </label>
        </div>
        <div class="small-12 coluimns">
          <button class="button primary" type="button" data-toggle="dd-bookmark">{{ tl_bookmark_add }}</button>
        </div>   
      </div>
    </form>
  </div>
</div>
</template>

<script>
    export default {
        methods: {
            fetchBookmarks() {

            },
            addBookmarks() {

            },
        },
        mounted() {
            this.fetchBookmarks();
        },
        props: ['tl_bookmark', 'tl_bookmark_dest', 'tl_bookmark_add'],
    }
</script>