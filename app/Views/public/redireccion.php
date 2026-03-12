<main>

  <div class="px-4 py-5 my-5 text-center">
    <i class="bi-<?=$icon?> icon-redirect"></i>
    <h1 class="ret-titulo-panel"><?=$subtitle?></h1>
    <div class="col-lg-6 mx-auto">
      <p class="lead mb-4"><?=$message?></p>
      <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
      </div>
    </div>
  </div>

</main>

<script type="text/javascript">
  t1 = window.setTimeout(function(){ window.location = "<?=$url?>"; },<?=$time?>);
</script>