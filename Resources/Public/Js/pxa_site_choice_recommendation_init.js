(function () {
    let siteChoiceRecommendation = new PxaSiteChoiceRecommendation();

    // Load with default bar processing
    if (siteChoiceRecommendation.isBarEnabled()) {
        siteChoiceRecommendation.loadBar();
    }
})();
