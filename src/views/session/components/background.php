<div class='background'>
  <div class="img-background"><img src="" alt="" srcset=""></div>
  <div class='divise'></div>
</div>

<style>
  .background {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: -1;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: auto auto;

  }

  .img-background {
    width: 100%;
    height: 100%;
    overflow: hidden;
  }

  .img-background img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    opacity: 0.5;
  }

  .divise {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 40%;
    background-color: #07004D;
  }
</style>