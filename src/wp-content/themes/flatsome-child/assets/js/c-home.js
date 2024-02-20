// Bảng gia (append nhãn)
jQuery(document).ready(function ($) {
  $(".c-price-vote ").each(function () {
    var htmlContent = `<label class="button c-nhan-noibat">Phù hợp với bạn</label>`;
    $(this).append(htmlContent);
  });
});
