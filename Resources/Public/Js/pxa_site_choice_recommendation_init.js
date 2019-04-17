(function () {
    let siteChoiceRecommendation = new PxaSiteChoiceRecommendation();

    // Load with default bar processing
    if (siteChoiceRecommendation.isBarEnabled()) {
        siteChoiceRecommendation.loadBar();
    }
})();


$(window).on('load', function () {
  let $select = $('.site-choice__select');

  if ($select.length) {
    $select.on('click', function (e) {
      e.preventDefault();
      $(this).toggleClass('_open');
      if (e.target.className === 'site-choice__item-link') {
        $('.site-choice__selected-item').text($(e.target).text())
      }
    })
  
    $(window).on('click', e => {
      if ($select.has(e.target).length === 0 && !$select.is(e.target)) {
        $select.removeClass('_open')
      }
    })
  }
})
