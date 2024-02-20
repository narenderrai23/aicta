var currentTab = 0;
showTab(currentTab);

function showTab(n) {
  var $x = $(".wizard-tab");
  $x.eq(n).css("display", "block");

  $("#prevBtn").css("display", n === 0 ? "none" : "inline");
  var $next = $("#nextBtn");
  $next.html(n === $x.length - 1 ? "Submit" : "Next");
  setTimeout(() => {
    $next.attr("type", n === $x.length - 1 ? "submit" : "button");
  }, 10);
  fixStepIndicator(n);
}

function nextPrev(n) {
  var $x = $(".wizard-tab");
  $x.hide()
    .eq((currentTab += n))
    .show();
  currentTab = Math.max(0, Math.min(currentTab, $x.length - 1));
  showTab(currentTab);
}

function fixStepIndicator(n) {
  $(".list-item").removeClass("active").eq(n).addClass("active");
}