<template>
  <div class="mapouter">
    <div class="gmap_canvas">
      <iframe
          width="100%"
          height="350"
          :id="id"
          :src="`https://maps.google.com/maps?q=${address}&t=&z=12&ie=UTF8&iwloc=&output=embed`"
          frameborder="0"
          scrolling="no"
          marginheight="0"
          marginwidth="0"></iframe>
    </div>
  </div>
</template>

<script>
export default {
  name: "GoogleMap",
  props: {
    id: {
      type: String,
      required: true
    },
    address: {
      type: String,
      required: true
    }
  }
}
</script>

<style scoped>
.mapouter {
  text-align: right;
  height: 350px;
  width: 100%;
}

.gmap_canvas {
  overflow: hidden;
  background: none !important;
  height: 350px;
  width: 100%;
}
</style>