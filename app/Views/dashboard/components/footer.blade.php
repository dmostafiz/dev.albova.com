@include('dashboard.components.right-nav')
<?php do_action('footer'); ?>
<?php do_action('init_footer'); ?>
<?php do_action('init_dashboard_footer'); ?>
<script src="{{asset('js/option.js')}}"></script>
<script src="{{asset('js/dashboard.js')}}"></script>

<script>
function clickAndCopy() {
  var copyText = document.getElementById("copyText");
  var copyBtn = document.getElementById("copyBtn");
  copyText.select();
  copyText.setSelectionRange(0, 99999)
  document.execCommand("copy");
  copyBtn.innerHTML = "Copied!";
}

</script>

</body>
</html>
